<?php // phpcs:ignore
/**
 * S3 Uploader class.
 *
 * @link  https://www.boldgrid.com
 * @since 1.2.0
 *
 * @package    Boldgrid_Backup
 * @subpackage Boldgrid_Backup/admin/remote
 * @copyright  BoldGrid
 * @version    $Id$
 * @author     BoldGrid <support@boldgrid.com>
 */

use Aws\S3\Model\MultipartUpload\UploadBuilder;

/**
 * S3 Uploader class.
 *
 * @since 1.2.0
 */
class Boldgrid_Backup_Premium_Admin_Remote_S3_Uploader {
	/**
	 * An array of error messages.
	 *
	 * @since 1.2.0
	 * @var array $errors
	 * @access private
	 */
	private $errors = [];

	/**
	 * Get errors.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	public function get_errors() {
		return $this->errors;
	}

	/**
	 * Whether or not we have errors.
	 *
	 * @since 1.2.0
	 *
	 * @return bool
	 */
	public function has_error() {
		return ! empty( $this->errors );
	}

	/**
	 * Upload a backup file.
	 *
	 * @since 1.2.0
	 *
	 * @param  Boldgrid_Backup_Premium_Admin_Remote_S3_Bucket $bucket   Our bucket.
	 * @param  string                                         $filepath File path.
	 * @return bool
	 */
	public function upload( Boldgrid_Backup_Premium_Admin_Remote_S3_Bucket $bucket, $filepath ) {
		$success = false;

		$core = apply_filters( 'boldgrid_backup_get_core', null );

		$client = $bucket->get_client();

		if ( ! $core->wp_filesystem->exists( $filepath ) ) {
			// Translators: 1: File path.
			$this->errors[] = sprintf( __( 'Failed to upload, filepath does not exist: %1$s', 'boldgrid-backup' ), $filepath );

			return $success;
		}

		/*
		 * When files are uploaded to an S3 host S3, the LastModified is the time the file was uploaded,
		 * not the time the file was last modified. When we enforce retention, we'll need to know when
		 * the backup archive was created, not when it was uploaded.
		 */
		$archive_data  = $core->archive_log->get_by_zip( $filepath );
		$last_modified = ! empty( $archive_data['lastmodunix'] ) ? $archive_data['lastmodunix'] : $core->wp_filesystem->mtime( $filepath );

		try {
			$uploader = UploadBuilder::newInstance()
				->setClient( $client->get_client() )
				->setSource( $filepath )
				->setBucket( $bucket->get_id() )
				->setKey( basename( $filepath ) )
				->setOption( 'ACL', 'private' )
				/*
				 * Set our meta data.
				 *
				 * Originally, our Amazon S3 class used is_boldgrid_backup and last_modified. These
				 * don't work with DreamObjects. Appears only lowercase letters are allowed.
				 */
				->setOption( 'Metadata', array(
					'isboldgridbackup' => 'true',
					'lastmodified'     => $last_modified,
				) )
				->setConcurrency( 3 )
				->build();
		} catch ( Exception $e ) {
			$this->errors[] = sprintf(
				// Translators: 1, the status code (such as 403), 2 the error code (such as "SignatureDoesNotMatch").
				__( '%1$s error: %2$s.', 'boldgrid-backup' ),
				$e->getStatusCode(),
				$e->getAwsErrorCode()
			);

			return $success;
		}

		try {
			$uploader->upload();

			// We've uploaded a new file. Delete this bucket's objects transient.
			$bucket->get_client()->get_provider()->get_transient()->delete_objects( $bucket->get_id() );

			// Upload was a success if our bucket has our backup file.
			$bucket->set_objects( true );
			$success = $bucket->has_object_key( basename( $filepath ) );
		} catch ( MultipartUploadException $e ) {
			$uploader->abort();

			$this->errors[] = __( 'Failed to upload.', 'boldgrid-inspirations' );

			return $success;
		}

		return $success;
	}
}

<?php
/**
 * Review class.
 *
 * @since 1.1.4.5
 *
 * @package OMAPI
 * @author  Devin Vinson
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Review class.
 *
 * @since 1.1.4.5
 */
class OMAPI_Review {

	/**
	 * Holds the class object.
	 *
	 * @since 1.1.4.5
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 1.1.4.5
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the base class object.
	 *
	 * @since 1.1.4.5
	 *
	 * @var object
	 */
	public $base;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.1.4.5
	 */
	public function __construct() {

		// Set our object.
		$this->set();

		// Review Notices
		add_action( 'admin_notices', array( $this, 'review' ) );
		add_action( 'wp_ajax_omapi_dismiss_review', array( $this, 'dismiss_review' ) );
	}

	/**
	 * Sets our object instance and base class instance.
	 *
	 * @since 1.1.4.5
	 */
	public function set() {
		self::$instance = $this;
		$this->base     = OMAPI::get_instance();
	}

	/**
	 * Add admin notices as needed for reviews.
	 *
	 * @since 1.1.6.1
	 */
	public function review() {

		// Don't show review request notice on welcome page.
		if ( ! empty( $_GET['page'] ) && 'optin-monster-api-welcome' === $_GET['page'] ) {
			return;
		}

		$review = get_option( 'omapi_review' );

		// If already dismissed...
		if ( ! empty( $review['dismissed'] ) ) {

			if ( empty( $review['later'] ) ) {

				// Dismissed and no later, so do not show.
				return;
			}

			$delayed_less_than_month_ago = ! empty( $review['later'] ) && $review['time'] + ( 30 * DAY_IN_SECONDS ) > time();
			if ( $delayed_less_than_month_ago ) {

				// Delayed less than a month ago, so do not show.
				return;
			}
		}

		// Check the installation time and find if it's ok to show the review notice.
		$option = $this->base->get_option();

		$installed_less_than_week_ago = $option['installed'] + ( 7 * DAY_IN_SECONDS ) > time();

		if ( $installed_less_than_week_ago ) {

			// Do not show the review if the plugin was installed less than 1 week ago.
			return;
		}

		// We have a candidate! Output a review message.

		wp_enqueue_script( $this->base->plugin_slug . '-notice', plugins_url( 'assets/js/notice.js', OMAPI_FILE ), array( 'jquery' ), $this->base->version, true );
		wp_localize_script( $this->base->plugin_slug . '-notice', 'omNotice', array(
			'nonce' => wp_create_nonce( 'om-review-nonce' ),
		) );

		?>
		<div class="notice notice-info is-dismissible om-review-notice">
			<div class="om-notice-wrap">
				<h3><?php esc_html_e( 'Are you enjoying OptinMonster?', 'optin-monster-api' ); ?></h3>
				<p style="margin-bottom:0">
					<a href="#" class="button button-primary om-review-btns" data-res="yes" rel="noopener"><?php esc_html_e( 'Yes!', 'optin-monster-api' ); ?> 🙂</a>
					<a href="#" class="button button-secondary om-review-btns" data-res="no" target="_blank" rel="noopener"><?php esc_html_e( 'Not Really!', 'optin-monster-api' ); ?></a>
					<?php if ( ! $this->base->get_api_credentials() ) : ?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=optin-monster-api-welcome' ) ); ?>" class="om-dismiss-review-notice om-dismiss-review-notice-delay button button-secondary" rel="noopener">
							<?php esc_html_e( 'What is OptinMonster?', 'optin-monster-api' ); ?>
						</a>
					<?php endif; ?>
				</p>
			</div>
			<br>
			<div class="om-notice-review">
				<div class="om-steps om-step-yes" style="display: none">
					<p><?php esc_html_e( 'That\'s awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation?', 'optin-monster-api' ); ?></p>
					<p><strong>~ Thomas Griffin<br><?php printf( esc_html__( 'Co-Founder of %1$s', 'optin-monster-api' ), 'OptinMonster' ); ?></strong></p>
					<p>
						<a href="https://wordpress.org/support/plugin/optinmonster/reviews/?filter=5#new-post" class="om-dismiss-review-notice button button-primary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Ok, you deserve it', 'optin-monster-api' ); ?></a>&nbsp;&nbsp;
						<a href="#" class="om-dismiss-review-notice om-dismiss-review-notice-delay" rel="noopener noreferrer"><?php esc_html_e( 'Nope, maybe later!', 'optin-monster-api' ); ?></a>&nbsp;&nbsp;
						<a href="#" class="om-dismiss-review-notice" rel="noopener noreferrer"><?php esc_html_e( 'I already did!', 'optin-monster-api' ); ?></a>
					</p>
				</div>
				<div class="om-steps om-step-no" style="display: none">
					<p><?php printf( esc_html__( 'We\'re sorry to hear you aren\'t enjoying %1$s. We would love a chance to improve. Could you take a minute and let us know what we can do better?', 'optin-monster-api' ), 'OptinMonster' ); ?></p>
					<p>
						<a href="https://optinmonster.com/plugin-review-feedback/" class="om-dismiss-review-notice button button-primary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Give feedback', 'optin-monster-api' ); ?></a>&nbsp;&nbsp;
						<a href="#" class="om-dismiss-review-notice" rel="noopener noreferrer"><?php esc_html_e( 'No thanks!', 'optin-monster-api' ); ?></a>
					</p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Dismiss the review nag
	 *
	 * @since 1.1.6.1
	 */
	public function dismiss_review() {

		// Checking ajax nonce.
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'om-review-nonce' ) ) {
			wp_send_json_error();
		}

		$option = array(
			'time'      => time(),
			'dismissed' => true,
			'later'     => ! empty( $_POST['later'] ) && wp_validate_boolean( $_POST['later'] ),
		);

		$option['updated'] = update_option( 'omapi_review', $option );

		wp_send_json_success( $option );
	}
}

<?php
/**
 * Archive Page Entry Header Template
 *
 * This file contains the markup for the archive page's
 * entry header.
 *
 * @package Prime
 */
?>

<header class="page-header">
	<?php
		the_archive_title( '<p class="h1 page-title">', '</p>' );
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
	?>
</header><!-- .page-header -->

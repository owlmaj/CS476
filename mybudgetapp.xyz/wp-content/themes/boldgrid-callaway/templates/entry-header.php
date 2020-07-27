<?php
/**
 * Entry Header Template
 *
 * This file contains the markup for the default entry header.
 *
 * @package Prime
 */
?>

<div class="bgtfw <?php echo BoldGrid::print_container_class( 'entry-header' )?>">
	<?php if ( is_page() || is_single() ) :
		$id = get_the_ID();
		$post_meta = get_post_meta( $id );
		// This was updated to invert logic, from hide page title to display page title.
		if ( ! ( empty( $post_meta['boldgrid_hide_page_title'][0] ) && isset( $post_meta['boldgrid_hide_page_title'] ) ) && 'page_home.php' !== get_page_template_slug() ) : ?>
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<?php endif; ?>
	<?php else : ?>
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	<?php endif; ?>
</div>

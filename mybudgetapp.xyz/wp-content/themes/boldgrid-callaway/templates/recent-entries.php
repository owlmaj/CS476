<?php
/**
 * Recent Entries Template
 *
 * This file contains the markup for recent entries displayed in the
 * 404 pages of the Prime theme.
 *
 * @package Prime
 */
?>

<?php
	$recent_posts = wp_get_recent_posts( array( 'numberposts' => '10', 'post_status' => 'publish' ) );
	$pages = get_pages( array( 'sort_column' => 'menu_order' ) );
?>

<?php if ( $recent_posts || $pages ) : ?>
	<div class="row">
		<?php if ( $recent_posts ) : ?>
			<div class="<?php echo ! $pages ? 'col-md-12' : 'col-md-6'; ?> search-posts">
				<h3><?php _e( 'Recent Articles' ); ?></h3>
				<ul class="list-group">
					<?php
						$args = array( 'numberposts' => '10', 'post_status' => 'publish' );
						$recent_posts = wp_get_recent_posts( $args );
					foreach ( $recent_posts as $recent ) {
						if ( $recent['post_title'] ) {
							echo '<li class="list-group-item"><a href="' . get_permalink( $recent['ID'] ) . '">' . $recent['post_title'] . '</a></li>';
						}
					}
					?>
				</ul>
			</div> <!-- .search-posts -->
		<?php endif; ?>
		<?php if ( $pages ) : ?>
			<div class="<?php echo ! $recent_posts ? 'col-md-12' : 'col-md-6'; ?> search-pages">
				<h3><?php _e( 'Page Sitemap' ); ?></h3>
				<ul class="list-group">
					<?php
						$count = 0;
					foreach ( $pages as $page ) {
						if ( $page->post_title && $count < 10 ) {
							echo '<li class="list-group-item"><a href="' . get_permalink( $page->ID ) . '">' . $page->post_title . '</a></li>';
						}
						$count++;
					}
					?>
				</ul>
			</div> <!-- .search-pages -->
		<?php endif; ?>
	</div> <!-- .row -->
<?php endif; ?>

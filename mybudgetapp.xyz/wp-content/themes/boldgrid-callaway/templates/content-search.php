<?php
/**
 * Search Template.
 *
 * This contains the markup used on the search result pages.
 *
 * @package Prime
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php boldgrid_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<footer class="entry-footer">
		<?php boldgrid_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

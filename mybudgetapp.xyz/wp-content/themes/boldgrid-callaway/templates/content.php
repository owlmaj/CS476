<?php
/**
 * Content Template
 *
 * This file contains the markup for the default content template.
 *
 * @package Prime
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php get_template_part( 'templates/entry-header' ); ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php boldgrid_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail(); ?>
		<?php endif; ?>
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'boldgrid' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'bgtfw' ),
			'after'  => '</div>',
			)
		); ?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php boldgrid_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

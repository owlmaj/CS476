<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package x-blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php x_blog_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
    <?php if(has_post_thumbnail()): ?>
        <div class="baby-feature-image"> 
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php endif; ?>

	<div class="entry-content">
		<?php
		$xblog_content_type = get_theme_mod( 'xblog_content_type', 'full' );
        if($post->post_excerpt && !is_single() || $xblog_content_type == 'short' && !is_single() ){ 
            the_excerpt();
            echo sprintf('<div class="redmore-btn"><a href="%s" class="more-link" rel="bookmark">'. esc_html__('Continue Reading','x-blog').the_title('<span class="screen-reader-text">"','"</span>', false).'</a></div>', esc_url(get_permalink()));
        }else{ 
            the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'x-blog' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );
        }
			

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'x-blog' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php x_blog_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

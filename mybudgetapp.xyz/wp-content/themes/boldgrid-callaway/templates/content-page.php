<?php
/**
 * Default Page Template.
 *
 * This is the template responsible for displaying the
 * default page in the BoldGrid Theme.
 *
 * @since 2.0
 * @package Prime
 */

// Get the theme configs.
global $boldgrid_theme_framework;
$configs = $boldgrid_theme_framework->get_configs();

// Display the call to action widget area if configs are set.
$cta = $configs['template']['call-to-action'];
if ( 'all-pages' === $cta ) {
	include locate_template( 'templates/call-to-action.php' );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'before_entry_title' ); ?>
	<header class="entry-header">
		<?php get_template_part( 'templates/entry-header' ); ?>
	</header><!-- .entry-header -->
	<?php do_action( 'after_entry_title' ); ?>
	<div class="entry-content">
		<div class="bgtfw <?php echo BoldGrid::print_container_class( 'entry-content' )?>">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<nav class="page-links"><p>' . esc_html__( 'Pages:', 'bgtfw' ), 'after' => '</p></nav>' ) ); ?>
		</div><!-- .bgtfw container -->
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php get_template_part( 'templates/entry-footer' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

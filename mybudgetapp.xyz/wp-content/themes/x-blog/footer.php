<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package x-blog
 */
$xblog_theme = wp_get_theme();
$xtheme_domain = $xblog_theme->get( 'TextDomain' );
if( $xtheme_domain == 'x-magazine' ){
	$theme_slug = $xtheme_domain; 
}else{
	$theme_slug = 'x-blog'; 
}

?>

	</div><!-- #content -->
    <?php if(is_dynamic_sidebar('footer-widget')): ?>
    <div class="footer-widget-area"> 
        <div class="baby-container widget-footer"> 
            <?php dynamic_sidebar('footer-widget'); ?>
        </div>
    </div>
    <?php endif; ?>
	<footer id="colophon" class="site-footer footer-display">
		<div class="baby-container site-info">
			<p class="footer-copyright">&copy;
				<?php
					echo date_i18n(
						/* translators: Copyright date format, see https://www.php.net/date */
					_x( 'Y', 'copyright date format', 'x-blog' )
							);
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</p><!-- .footer-copyright -->
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'x-blog' ) ); ?>"><?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'x-blog' ), 'WordPress' );
				?></a>
				<span class="sep"> | </span>
				<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %1$s by %2$s', 'x-blog' ), $xtheme_domain, '<a href="'.esc_url('https://wpthemespace.com/product/'.$theme_slug).'">wpthemespace.com</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Footer Template
 *
 * This file contains the markup for the footer template.
 *
 * @since 2.0
 * @package Prime
 */

// Get the theme configs.
global $boldgrid_theme_framework;
$configs = $boldgrid_theme_framework->get_configs();
?>

<footer id="colophon" role="contentinfo" <?php BoldGrid_Framework_Schema::footer( true ); ?>>
	<?php do_action( 'boldgrid_footer_top' ); ?>
		<div class='boldgrid-section'>
			<div class="bgtfw <?php echo $configs['template']['pages']['global']['footer']; ?>">
				<div class='row footer-1'>
					<div class='col-md-12 footer-1'><?php do_action( 'boldgrid-theme-location', 'footer', '1' ); ?></div>
				</div>
				<div class='row footer-2 footer-3 footer-4'>
					<div class='col-md-4 footer-2'><?php do_action( 'boldgrid-theme-location', 'footer', '2' ); ?></div>
					<div class='col-md-4 footer-3'><?php do_action( 'boldgrid-theme-location', 'footer', '3' ); ?></div>
					<div class='col-md-4 footer-4'><?php do_action( 'boldgrid-theme-location', 'footer', '4' ); ?></div>
				</div>
				<div class='row footer-5'>
					<div class='col-md-12 footer-5'><?php do_action( 'boldgrid-theme-location', 'footer', '5' ); ?></div>
				</div>
				<div class='row footer-6 footer-7'>
					<div class='col-md-7 footer-6'><?php do_action( 'boldgrid-theme-location', 'footer', '6' ); ?></div>
					<div class='col-md-5 footer-7'><?php do_action( 'boldgrid-theme-location', 'footer', '7' ); ?></div>
				</div>
				<div class='row footer-8'>
					<div class='col-md-12 footer-8'><?php do_action( 'boldgrid-theme-location', 'footer', '8' ); ?></div>
				</div>
				<div class='row footer-9 footer-10'>
					<div class='col-md-6 footer-9'><?php do_action( 'boldgrid-theme-location', 'footer', '9' ); ?></div>
					<div class='col-md-6 footer-10'><?php do_action( 'boldgrid-theme-location', 'footer', '10' ); ?></div>
				</div>
				<div class='row footer-11'>
					<div class='col-md-12 footer-11'><?php do_action( 'boldgrid-theme-location', 'footer', '11' ); ?></div>
				</div>
			</div><!-- .container -->
		</div><!-- .section -->
	<?php do_action( 'boldgrid_footer_bottom' ); ?>
</footer><!-- #colophon -->

<?php
/**
 * Header Template
 *
 * This file contains the markup for the header template.
 *
 * @package Prime
 */

// Get the theme configs.
global $boldgrid_theme_framework;
$configs = $boldgrid_theme_framework->get_configs();
?>

<header id="masthead" class="<?php echo basename( __FILE__, '.php' ); ?>" role="banner" <?php BoldGrid_Framework_Schema::header( true ); ?>>
	<?php do_action( 'boldgrid_header_top' ); ?>
		<div class='boldgrid-section'>
			<?php do_action( 'boldgrid-theme-location', 'header', '12' ); ?>
		</div>
		<div class='boldgrid-section'>
			<div class="bgtfw <?php echo $configs['template']['pages']['global']['header']; ?>">
				<div class='row header-1'>
					<div class='col-md-12 header-1'><?php do_action( 'boldgrid-theme-location', 'header', '1' ); ?></div>
				</div>
				<div class='row header-2 header-3 header-4'>
					<div class='col-md-4 header-2'><?php do_action( 'boldgrid-theme-location', 'header', '2' ); ?></div>
					<div class='col-md-4 header-3'><?php do_action( 'boldgrid-theme-location', 'header', '3' ); ?></div>
					<div class='col-md-4 header-4'><?php do_action( 'boldgrid-theme-location', 'header', '4' ); ?></div>
				</div>
				<div class='row header-14 header-15'>
					<div class='col-md-9 header-14'><?php do_action( 'boldgrid-theme-location', 'header', '14' ); ?></div>
					<div class='col-md-3 header-15'><?php do_action( 'boldgrid-theme-location', 'header', '15' ); ?></div>
				</div>
				<div class='row header-5'>
					<div class='col-md-12 header-5'><?php do_action( 'boldgrid-theme-location', 'header', '5' ); ?></div>
				</div>
				<div class='row header-6 header-7'>
					<div class='col-md-6 header-6'><?php do_action( 'boldgrid-theme-location', 'header', '6' ); ?></div>
					<div class='col-md-6 header-7'><?php do_action( 'boldgrid-theme-location', 'header', '7' ); ?></div>
				</div>
				<div class='row header-8'>
					<div class='col-md-12 header-8'><?php do_action( 'boldgrid-theme-location', 'header', '8' ); ?></div>
				</div>
				<div class='row header-9 header-10'>
					<div class='col-md-6 header-9'><?php do_action( 'boldgrid-theme-location', 'header', '9' ); ?></div>
					<div class='col-md-6 header-10'><?php do_action( 'boldgrid-theme-location', 'header', '10' ); ?></div>
				</div>
				<div class='row header-11'>
					<div class='col-md-12 header-11'><?php do_action( 'boldgrid-theme-location', 'header', '11' ); ?></div>
				</div>
			</div><!-- .container -->
		</div><!-- .section -->
		<div class='boldgrid-section'>
			<?php do_action( 'boldgrid-theme-location', 'header', '13' ); ?>
		</div>
	<?php do_action( 'boldgrid_header_bottom' ); ?>
</header><!-- #masthead -->

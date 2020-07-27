<?php
/**
 * Search Template
 *
 * This file contains the markup for search template.
 *
 * @package Prime
 */

// Get the theme configs.
global $boldgrid_theme_framework;
$configs = $boldgrid_theme_framework->get_configs();
// Default navbar-right search form.
$search_classes = 'navbar-form navbar-right';
// If offcanvas is enabled, menu is vertical.
if ( true === $configs['scripts']['offcanvas-menu'] ) {
	$search_classes = 'navbar-form';
}
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="<?php echo esc_attr( $search_classes ) ?>">
	<div class="form-group">
		<input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query( ) ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'bgtfw' ); ?>" />
	</div>
	<button type="submit" class="btn btn-default button-primary"><span class="fa fa-search"></span><span>&nbsp;Search</span></button>
</form>

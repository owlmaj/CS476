<?php
/**
 * Call To Action Template
 *
 * This is the call to action template used in Prime themes.
 *
 * @package Prime
 */

// Get the theme configs.
$widgets = $configs['widget']['widget_instances'];
// Display the call to action widget area if configs are set.
?>
<div class="bgtfw-cta <?php echo $configs['template']['pages']['global']['call-to-action']; ?>">
	<?php
		$location = 'boldgrid-widget-1';
	foreach ( $widgets as $widget => $widget_configs ) {
		if ( isset( $widget_configs[0]['title'] ) && 'Call To Action' === $widget_configs[0]['title'] ) {
			$location = $widget;
			break;
		}
	}
		dynamic_sidebar( $location );
	?>
</div>

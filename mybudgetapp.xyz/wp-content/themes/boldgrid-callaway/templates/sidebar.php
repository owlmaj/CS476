<?php
/**
 * The template for displaying the sidebar.
 *
 * @package Prime
 */

// Link to the widgets section in the customizer.
$current_page = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$link = esc_url(
	add_query_arg(
		array(
			'url' => urlencode( $current_page ),
			array(
				'autofocus' => array(
					'control' => 'sidebars_widgets[sidebar-1]',
				),
			),
			'return' => $current_page,
		),
		wp_customize_url()
	)
);

dynamic_sidebar( 'sidebar-1' ); ?>

<?php if ( current_user_can( 'edit_pages' ) && ! is_customize_preview() ) : ?>
	<?php if ( ! is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="empty-sidebar-message">
			<h2>Empty Sidebar</h2>
			<p>This sidebar doesn't have any widgets assigned to it yet.</p>
			<p><a href="<?php echo $link ?>"><i class="fa fa-plus-square" aria-hidden="true"></i> Add widgets here.</a></p>
		</div>
		<?php elseif ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div class="add-widget-message">
				<p><a href="<?php echo $link ?>"><i class="fa fa-plus-square" aria-hidden="true"></i> Add another widget.</a></p>
			</div>
	<?php endif; ?>
<?php endif; ?>

<?php
/**
 * 404 Template
 *
 * This file contains the 404 template used in this theme.
 *
 * @since 2.0
 * @package Prime
 */
?>

<?php do_action( '404_before' ); ?>
<div class="jumbotron text-center">
	<div class="container">
		<h1>404: Page Not Found.</h1>
			<p><?php _e( 'The page you requested could not be found.' ); ?></p>
		<div class="row">
			<div class="col-md-12">
				<?php get_search_form(); ?>
			</div>
		</div>
		<?php get_template_part( 'templates/recent-entries' ); ?>
	</div> <!-- .container -->
</div> <!-- .jumbotron -->
<?php do_action( '404_after' ); ?>

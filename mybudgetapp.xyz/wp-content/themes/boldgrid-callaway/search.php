<?php
/**
 * The template for displaying search results pages.
 *
 * @package BoldGrid
 */

// Get number of results.
$results_count = $wp_query->found_posts;
?>
<div class="jumbotron">
	<div class="bgtfw">
		<h1>Search <span class="keyword">&ldquo;<?php the_search_query(); ?>&rdquo;</span></h1>
		<?php if ( '' == $results_count || 0 == $results_count ) { // No Results ?>
			<p><span class="label label-danger"><?php _e( 'No Results' ); ?></span>&nbsp; <?php _e( 'Try different search terms.' ); ?></p>
		<?php } else { // Results Found. ?>
			<p><span class="label label-success"><?php echo $results_count . __( ' Results' ); ?></span></p>
		<?php } // End results check. ?>
		<div class="row">
			<div class="<?php echo BoldGrid::display_sidebar() ? 'col-md-9' : 'col-md-12'; ?>">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div> <!-- .container -->
</div> <!-- .jumbotron -->
<div class="bgtfw search-results">
	<div class="row">
		<div class="<?php echo BoldGrid::display_sidebar() ? 'col-md-9' : 'col-md-12'; ?>">
			<?php if ( have_posts() ) : // Results Found. ?>
				<h1><?php _e( 'Search Results' ); ?></h1>
				<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
					<div class="entry">
						<p><?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?></p>
					</div>
				</article>
				<hr />
				<?php endwhile; ?>
				<ul class="pager">
					<li><?php next_posts_link( '<i class="icon-chevron-left"></i>&nbsp; Older Results' ) ?></li>
					<li><?php previous_posts_link( 'Newer Results &nbsp;<i class="icon-chevron-right"></i>' ) ?></li>
				</ul>
		</div> <!-- .col-md-12 -->
	</div> <!-- .row -->
	<?php else : // No Results. ?>
	<div class="row">
		<div class="<?php echo BoldGrid::display_sidebar( ) ? 'col-md-9' : 'col-md-12'; ?>">
			<p><?php _e( 'Sorry. We couldn&rsquo;t find anything for that search. View one of our site&rsquo;s pages or a recent article below.' ); ?></p>
		</div><!-- .col-md-12 -->
	</div> <!-- .row -->
	<?php get_template_part( 'templates/recent-entries' ); ?>
	<?php endif; ?>
</div><!-- .container -->

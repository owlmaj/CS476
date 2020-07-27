<?php
/**
 * The core template of a BoldGrid theme.  If there's no home template
 * then this template gets used.  One of two required WordPress files.
 *
 * @since 2.0
 *
 * @package Prime
 */

if ( ! have_posts() ) :
	get_template_part( 'templates/content', 'none' );
endif;

if ( is_archive() ) :
	get_template_part( 'templates/entry-header', 'archive' );
endif;

while ( have_posts() ) : the_post();
	get_template_part( 'templates/content', get_post_type() !== 'post' ? get_post_type() : get_post_format() );
endwhile;

boldgrid_paging_nav();

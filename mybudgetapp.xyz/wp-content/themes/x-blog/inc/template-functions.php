<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package x-blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function x_blog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	$theme_color = get_theme_mod('theme_color');
	$content_title_position = get_theme_mod('content_title_position','title-center');
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	$classes[] = $theme_color;
	$classes[] = $content_title_position;

	return $classes;
}
add_filter( 'body_class', 'x_blog_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function x_blog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'x_blog_pingback_header' );

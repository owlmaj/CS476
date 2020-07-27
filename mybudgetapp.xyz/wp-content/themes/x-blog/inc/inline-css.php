<?php
/**
 * Add inline css 
 *
 * 
 */
if ( ! function_exists( 'x_blog_header_inline_css' ) ) :
function x_blog_header_inline_css() {
$header_text_color = get_header_textcolor();
 $header_bgcolor = get_theme_mod('header_bgcolor');
 $content_bg_color = get_theme_mod('content_bg_color');


	wp_enqueue_style(
		'x-blog-custom-style',
		get_template_directory_uri() . '/assets/css/custom_script.css'
	);
    
        $style = '';
   
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		$style .= '.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}';
			
		
			// If the user has set a custom color for the text use that.
			else :
		$style .= '.site-title a,
			.site-description {
				color: #'.esc_attr( $header_text_color ).' ;
			}';
			
		 endif;
         if ( ! is_active_sidebar( 'sidebar-1' ) ){ 
            $style .= '#content .content-area {
                    width: 100% !important;
                    margin: 0 !important;
                }';
         }
         if($header_bgcolor){ 
         	$style .= 'header.site-header{
                    background: '.esc_attr($header_bgcolor).';
                }';
         }
         if($content_bg_color){ 
         	$style .= '.site-header, .hentry, .comments-area, .site-main section, .site-main .post-navigation, .site-main .posts-navigation, .paging-navigation, .widget, .page-header{
                    background: '.esc_attr($content_bg_color).';
                }';
         }


   
        wp_add_inline_style( 'x-blog-custom-style', $style );
}
add_action( 'wp_enqueue_scripts', 'x_blog_header_inline_css' );
endif;
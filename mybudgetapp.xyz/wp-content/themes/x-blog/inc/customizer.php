<?php
/**
 * x-blog Theme Customizer
 *
 * @package x-blog
 */
//Sanitize layout
function x_blog_sanitize_layout($value){ 
	if(!in_array($value, array('right-sidebar','left-sidebar','full-width'))){
		$value = 'right-sidebar';
	}
	return $value;
}

//Sanitize theme color
function x_blog_sanitize_theme_color($value){ 
	if(!in_array($value, array('theme-black','theme-green','theme-blue','theme-indigo','theme-brown','theme-bluegrey'))){
		$value = 'theme-black';
	}
	return $value;
}
//Sanitize content title position
function x_blog_sanitize_content_title_position($value){ 
	if(!in_array($value, array('title-center','title-left'))){
		$value = 'title-center';
	}
	return $value;
}
//Sanitize content title position
function x_blog_sanitize_content_type($value){ 
    if(!in_array($value, array('full','short'))){
        $value = 'full';
    }
    return $value;
}
//Sanitize logo
function x_blog_logo_position($value){ 
    if(!in_array($value, array('logo-right','logo-left','logo-center'))){
        $value = 'logo-center';
    }
    return $value;
}
//Sanitize logo
function x_blog_menu_position($value){ 
	if(!in_array($value, array('right','left','center'))){
		$value = 'center';
	}
	return $value;
}


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function x_blog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'x_blog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'x_blog_customize_partial_blogdescription',
		) );
	}

        //select sanitization function
        function x_blog_sanitize_select( $input, $setting ){
            $input = sanitize_key($input);
            $choices = $setting->manager->get_control( $setting->id )->choices;
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
              
        }
        //add setting to your section
        $wp_customize->add_setting( 
            'x_blog_header_image_show', 
            array(
                'default'        => 'all-pages',
                'sanitize_callback' => 'x_blog_sanitize_select'
            )
        );
          
        $wp_customize->add_control( 
            'x_blog_header_image_show', 
            array(
                'label' => esc_html__( 'Header image visibility', 'x-blog' ),
                'section' => 'header_image',
                'type' => 'select',
                'choices' => array(
                    'all-pages' => esc_html__('Show All pages','x-blog'),
                    'home-page' => esc_html__('Show only homepage','x-blog'),
                    'hide' => esc_html__('Hide Header image','x-blog')               
                )
            )
        );



	// Add x-blog options section
	$wp_customize->add_section('x_blog_options', array(
		'title' => __('X Blog Options', 'x-blog'),
		'capability'     => 'edit_theme_options',
		'description'     => __('The x Blog theme options ', 'x-blog'),

	));
	/*
	* Create header background color
	*/
	// Add setting
	$wp_customize->add_setting('header_bgcolor', array(
		'default' => '#fff',
		'type' =>'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));
	// Add color control 
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'header_bgcolor', array(
				'label' => __('Header Background Color','x-blog'),
				'section' => 'colors'
			)
		)
	);

	// Add setting
	$wp_customize->add_setting('content_bg_color', array(
		'default' => '#ededed',
		'type' =>'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));
	// Add color control 
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'content_bg_color', array(
				'label' => __('Content Background Color','x-blog'),
				'section' => 'colors'
			)
		)
	);
      /*
      * Logo position 
       */
    $wp_customize->add_setting('logo_position', array(
        'default'        => 'logo-center',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'x_blog_logo_position',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('logo_position_control', array(
        'label'      => __('Select logo position', 'x-blog'),
        'section'    => 'x_blog_options',
        'settings'   => 'logo_position',
        'type'       => 'select',
        'choices'    => array(
            'logo-left' => __('Logo left', 'x-blog'),
            'logo-center' => __('Logo center', 'x-blog'),
            'logo-right' => __('Logo right', 'x-blog'),
        ),
    ));
	  /*
	  * menu position
	   */
    $wp_customize->add_setting('menu_position', array(
        'default'        => 'center',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'x_blog_menu_position',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('menu_position_control', array(
        'label'      => __('Select menu position', 'x-blog'),
        'section'    => 'x_blog_options',
        'settings'   => 'menu_position',
        'type'       => 'select',
        'choices'    => array(
            'left' => __('Menu left', 'x-blog'),
            'center' => __('Menu center', 'x-blog'),
            'right' => __('Menu right', 'x-blog'),
        ),
    ));

    $wp_customize->add_setting( 'xblog_header_search' , array(
    'capability'     => 'edit_theme_options',
    'type'           => 'theme_mod',
    'default'       =>  '',
    'sanitize_callback' => 'absint',
    'transport'     => 'refresh',
    ) );
    $wp_customize->add_control( 'xblog_header_search_control', array(
        'label'      => __('Active header search? ', 'x-blog'),
        'description'=> __('You can active or hide header search.', 'x-blog'),
        'section'    => 'x_blog_options',
        'settings'   => 'xblog_header_search',
        'type'       => 'checkbox',
        
    ) );
	
	  /*
	  * content title position 
	   */
    $wp_customize->add_setting('content_title_position', array(
        'default'        => 'title-center',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'x_blog_sanitize_content_title_position',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('content_title_position_control', array(
        'label'      => __('Content title position', 'x-blog'),
        'section'    => 'x_blog_options',
        'settings'   => 'content_title_position',
        'type'       => 'select',
        'choices'    => array(
            'title-center' => __('Center Content Title', 'x-blog'),
            'title-left' => __('Left Content Title', 'x-blog'),
        ),
    ));
    $wp_customize->add_setting('xblog_content_type', array(
        'default'        => 'full',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'x_blog_sanitize_content_type',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('xblog_content_type_control', array(
        'label'      => __('Content show type', 'x-blog'),
        'section'    => 'x_blog_options',
        'settings'   => 'xblog_content_type',
        'type'       => 'select',
        'choices'    => array(
            'full' => __('Full content', 'x-blog'),
            'short' => __('Short content', 'x-blog'),
        ),
    ));

	  /*
	  * Theme Color
	   */
      
    $wp_customize->add_setting('theme_color', array(
        'default'        => 'theme-black',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'x_blog_sanitize_theme_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('theme_color_control', array(
        'label'      => __('Select Theme color', 'x-blog'),
        'section'    => 'x_blog_options',
        'settings'   => 'theme_color',
        'type'       => 'select',
        'choices'    => array(
            'theme-black' => __('Theme Black', 'x-blog'),
            'theme-green' => __('Theme Green', 'x-blog'),
            'theme-blue' => __('Theme Blue', 'x-blog'),
            'theme-indigo' => __('Theme Indigo', 'x-blog'),
            'theme-brown' => __('Theme Brown', 'x-blog'),
            'theme-bluegrey' => __('Theme Blue Grey', 'x-blog'),

        ),
    ));



    // Theme layout
     $wp_customize->add_setting('theme_layout', array(
        'default'        => 'right-sidebar',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'x_blog_sanitize_layout',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('layout_control', array(
        'label'      => __('Select Theme layout', 'x-blog'),
        'section'    => 'x_blog_options',
        'settings'   => 'theme_layout',
        'type'       => 'select',
        'choices'    => array(
            'right-sidebar' => __('Right Sidebar', 'x-blog'),
            'left-sidebar' => __('Left Sidebar', 'x-blog'),
            'full-width' => __('No Sidebar', 'x-blog'),
        ),
    ));

    // Footer text change
     $wp_customize->add_setting('slider_text', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('slider_text_control', array(
        'label'      => __('slider shortcode', 'x-blog'),
        'description'     => __('Paste Niso carousel slider shortcode for Home Feature slider  .', 'x-blog').'<a target="_blank" href="https://wordpress.org/plugins/niso-carousel-slider/">'.__('Niso carousel','x-blog').'</a>',
        'section'    => 'x_blog_options',
        'settings'   => 'slider_text',
        'type'       => 'text',
    ));
  
    // Footer text change
     $wp_customize->add_setting('footer_copy_text', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'x_blog_sanitize_footer_text',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_copy_text_control', array(
        'label'      => __('Footer copyright text', 'x-blog'),
        'description'     => __('You can change copyright when you update with xblog pro.', 'x-blog').'<a target="_blank" href="https://wpthemespace.com/product/x-blog/">'.__(' update pro','x-blog').'</a>',
        'section'    => 'x_blog_options',
        'settings'   => 'footer_copy_text',
        'type'       => 'text',
    ));


  

    

}
add_action( 'customize_register', 'x_blog_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function x_blog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function x_blog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function x_blog_customize_preview_js() {
	wp_enqueue_script( 'x-blog-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'x_blog_customize_preview_js' );

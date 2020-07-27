<?php
/**
 * x-blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package x-blog
 */

if ( ! function_exists( 'x_blog_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function x_blog_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on x-blog, use a find and replace
		 * to change 'x-blog' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'x-blog', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'x-blog' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

			// Add support for Block Styles.
		  add_theme_support( 'wp-block-styles' );
		  
		  // Add support for full and wide align images.
		  add_theme_support( 'align-wide' );
		       
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'x_blog_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_editor_style( array( x_blog_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'x_blog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function x_blog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'x_blog_content_width', 960 );
}
add_action( 'after_setup_theme', 'x_blog_content_width', 0 );

function x_blog_gb_block_style() {

   wp_enqueue_style( 'xblog-gb-block', get_theme_file_uri( '/assets/css/admin-block.css' ), false, '1.0', 'all' );
   wp_enqueue_style( 'xblog-admin-google-font', x_blog_fonts_url(), array(), null );

}
add_action( 'enqueue_block_assets', 'x_blog_gb_block_style' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function x_blog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'x-blog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'x-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget', 'x-blog' ),
		'id'            => 'footer-widget',
		'description'   => esc_html__( 'Add footer widgets here.', 'x-blog' ),
		'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'x_blog_widgets_init' );
/**
 * Register custom fonts.
 */
function x_blog_fonts_url() {
	$fonts_url = '';

		$font_families = array();

		$font_families[] = 'PT Serif:400,400i,700,700i';
		$font_families[] = 'Crete Round:400,400i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );


	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function x_blog_scripts() {
    wp_enqueue_style( 'xblog-google-font', x_blog_fonts_url(), array(), null );
    wp_enqueue_style( 'font-awesome-five-all', get_template_directory_uri() . '/assets/css/all.css', array(),'5.13.0','all' );
    wp_enqueue_style( 'slicknav', get_template_directory_uri() . '/assets/css/slicknav.css', array(),1.0,'all' );
    wp_enqueue_style( 'block-style', get_template_directory_uri() . '/assets/css/block.css', array(), '1.0' );
	wp_enqueue_style( 'xblog-style', get_stylesheet_uri() );
	wp_enqueue_style( 'xblog-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(),'1.3.10','all' );

	
	wp_enqueue_script( 'xblog-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '1.3.10', true );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.js');
	wp_enqueue_script( 'slicknav', get_template_directory_uri() . '/assets/js/jquery.slicknav.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'xblog-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.3.10', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'x_blog_scripts' );
    /*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array(x_blog_fonts_url(), get_stylesheet_uri(),'assets/css/font-awesome.css' ) );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Customizer pro info .
 */
require get_template_directory() . '/inc/info/class-customize.php';

/**
 * Add inline css.
 */
require get_template_directory() . '/inc/inline-css.php';

/**
 * Add tgm class
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Add tgm plugin recommended code
 */
require get_template_directory() . '/inc/plugin-recommended.php';


/**
 * Load about.
 */
$xblog_theme = wp_get_theme();
$xtheme_domain = $xblog_theme->get( 'TextDomain' );

if ( is_admin() && $xtheme_domain == 'x-blog' ) {
    require_once trailingslashit( get_template_directory() ) . 'inc/about/class.about.php';
    require_once trailingslashit( get_template_directory() ) . 'inc/about/about.php';
}






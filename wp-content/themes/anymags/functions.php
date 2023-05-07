<?php

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'anymags_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function anymags_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on BlogPress, use a find and replace
		 * to change 'anymags' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'anymags', get_template_directory() . '/languages' );

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
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary', 'anymags' ),
				'topbar-menu' => esc_html__( 'Topbar Menu', 'anymags' )
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'anymags_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'anymags_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function anymags_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'anymags_content_width', 640 );
}
add_action( 'after_setup_theme', 'anymags_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function anymags_widgets_init() {
	register_sidebar(array(
		'name'          => esc_html__( 'Sidebar', 'anymags' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'anymags' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		));
	register_sidebar( array(
		'name' => 'Footer 1',
		'id' => 'footer-1',
		'description' => 'Appears in the footer area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer 2',
		'id' => 'footer-2',
		'description' => 'Appears in the footer area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer 3',
		'id' => 'footer-3',
		'description' => 'Appears in the footer area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'anymags_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function anymags_scripts() {
	wp_enqueue_style( 'anymags-style', get_stylesheet_uri(), array(), _S_VERSION );
	
	//CSS

	wp_enqueue_style('bootstrap_css',get_template_directory_uri().'/assets/css/bootstrap.css');
	
	wp_enqueue_style('font-awesome_css',get_template_directory_uri().'/assets/css/font-awesome.css');
	
	
	
	wp_enqueue_style('anymags_responsive_css',get_template_directory_uri().'/assets/css/responsive.css');
	
	wp_enqueue_style('anymags-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap');

	//JS

	wp_enqueue_script( 'bootstrap.js', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), _S_VERSION, true );

	

	wp_enqueue_script( 'popper.js', get_template_directory_uri() . '/assets/js/popper.js', array('jquery'), _S_VERSION, true );

	if ( has_nav_menu( 'primary-menu' ) ) {
	wp_enqueue_script( 'anymags_navigation.js', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), _S_VERSION, true );
	}
	wp_enqueue_script( 'anymags_main.js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), _S_VERSION, true );
	
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
}
add_action( 'wp_enqueue_scripts', 'anymags_scripts' );


function anymags_excerpt_more( $more ) {

	$more='...';
	if ( is_admin() ){
		return $more;
	} 
	
}
add_filter('excerpt_more', 'anymags_excerpt_more');




/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/controls.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';

require get_template_directory()  . '/inc/tgm/class-tgm-plugin-activation.php';
require get_template_directory(). '/inc/tgm/hook-tgm.php';

/**
 * Added buttom in customizer 
 */
require_once( trailingslashit( get_template_directory() ) . '/inc/custom-button/class-customize.php' );


/**
 * Add theme admin page.
 */
if ( is_admin() ) {
	require get_parent_theme_file_path( 'inc/about.php' );
}

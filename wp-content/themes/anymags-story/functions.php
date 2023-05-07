<?php
function anymags_story_enqueue_scripts(){

    wp_enqueue_script( 'anymags-story-main', get_stylesheet_directory_uri() . '/assets/js/anymags-main.js',array('jquery'),true);
    wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.js',array('jquery'),true);

    wp_enqueue_style( 'anymags-story-parent-style', get_template_directory_uri() . '/style.css');  
    
    wp_enqueue_style('anymags-story-style',get_stylesheet_uri());
    wp_enqueue_style( 'anymags-story-slick-css', get_stylesheet_directory_uri() . '/assets/css/slick.css'); 

    wp_enqueue_style('anymags-story-font', 'https://fonts.googleapis.com/css2?family=Prosto+One&display=swap');
    
    wp_enqueue_style('font-awesome-css-child', get_stylesheet_directory_uri() . '/assets/css/font-awesome.css');

    add_theme_support( 'automatic-feed-links' );

     /**
 * Add a sidebar.
 */
    function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'anymags-story' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'anymags-story' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );

}
    add_action('wp_enqueue_scripts','anymags_story_enqueue_scripts');
    function wpse_filter_excerpt_length( $length ) {
     if ( is_front_page() ) {
        return 28; // change this to number of words you want on homepage.
    } else {
        return $length;
    } 
}
    add_filter( 'excerpt_length', 'wpse_filter_excerpt_length', 999 );

function as_story_theme_setup() {

    // Adds <title> tag support
    add_theme_support( 'title-tag');  

}
add_action('after_setup_theme', 'as_story_theme_setup');

<?php
/**
 * BlogPress Theme Customizer
 *
 * @package BlogPress
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */



function anymags_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'anymags_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'anymags_customize_partial_blogdescription',
			)
		);
	}
	/**
	 * Anymags Theme Options Panel
	 */
	$wp_customize->add_panel( 'anymags_theme_options', array(
	    'title'     => esc_html__( 'Anymags Settings', 'anymags' ),
	    'priority'  => 2,
	) );

	//Header Socail Icon Section

	$wp_customize->add_section( 'anymags_header_social_icon_section', array (
		'title'     => esc_html__( 'Anymags Social Icon setting', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10
	) );

	// Top Header Menu Social Icon Display Control
	$wp_customize->add_setting ( 'anymags_left_header_social_icon_display', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_left_header_social_icon_display', array (
		'label'           => esc_html__( 'Display Left Header Social Icons', 'anymags' ),
		'section'         => 'anymags_header_social_icon_section',
		'priority'        => 4,
		'type'            => 'checkbox'
	) );

	// Social URL Target Display Control
	$wp_customize->add_setting ( 'anymags_social_icon_target_display', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_social_icon_target_display', array (
		'label'           => esc_html__( 'Display Social URL in new Window', 'anymags' ),
		'section'         => 'anymags_header_social_icon_section',
		'priority'        => 5,
		'type'            => 'checkbox',
		'active_callback' => 'anymags_header_social_active_callback'
	) );

	// Facebook URL
	$wp_customize->add_setting ( 'anymags_social_icon_fb_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control ( 'anymags_social_icon_fb_url', array(
		'label'    => esc_html__( 'Facebook URL', 'anymags' ),
		'section'  => 'anymags_header_social_icon_section',
		'priority' => 6,
		'type'     => 'url',
		'active_callback' => 'anymags_header_social_active_callback'
	) );

	// Twitter URL
	$wp_customize->add_setting ( 'anymags_social_icon_twitter_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control ( 'anymags_social_icon_twitter_url', array(
		'label'    => esc_html__( 'Twitter URL', 'anymags' ),
		'section'  => 'anymags_header_social_icon_section',
		'priority' => 7,
		'type'     => 'url',
		'active_callback' => 'anymags_header_social_active_callback'
	) );

	// Youtube URL
	$wp_customize->add_setting ( 'anymags_social_icon_youtube_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control ( 'anymags_social_icon_youtube_url', array(
		'label'    => esc_html__( 'Youtube URL', 'anymags' ),
		'section'  => 'anymags_header_social_icon_section',
		'priority' => 8,
		'type'     => 'url',
		'active_callback' => 'anymags_header_social_active_callback'
	) );

	// Instagram URL
	$wp_customize->add_setting ( 'anymags_social_icon_instagram_url', array(
		'default'           => '',

		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control ( 'anymags_social_icon_instagram_url', array(
		'label'    => esc_html__( 'Instagram URL', 'anymags' ),
		'section'  => 'anymags_header_social_icon_section',
		'priority' => 9,
		'type'     => 'url',
		'active_callback' => 'anymags_header_social_active_callback'
	) );

	

	/*Header Menu Section*/
	$wp_customize->add_section( 'anymags_header_menu_section', array (
		'title'     => esc_html__( 'Header Top Menu Section', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10,
		'description' => esc_html__( 'Personalize the settings header Menu.', 'anymags' ),
	) );
	// Header Right Menu Display Control
	$wp_customize->add_setting ( 'anymags_header_menu_display', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_header_menu_display', array (
		'label'           => esc_html__( 'Display Header Right Menu', 'anymags' ),
		'section'         => 'anymags_header_menu_section',
		'priority'        => 2,
		'type'            => 'checkbox'
	) );

	/*enable sticky*/
	$wp_customize->add_setting( 'anymags_sticky_menu_enable', array(
	    'default'			=> true,
	    'sanitize_callback' => 'anymags_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'anymags_sticky_menu_enable', array(
	    'label'		=> esc_html__( 'Enable Sticky Menu', 'anymags' ),
	    'section'   => 'anymags_header_menu_section',
	    'settings'  => 'anymags_sticky_menu_enable',
	    'type'	  	=> 'checkbox'
	) );

	//Slider Section

	$wp_customize->add_section( 'anymags_slider_section', array (
		'title'     => esc_html__( 'Anymags Slider setting', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10
	) );

	$wp_customize->add_setting ( 'anymags_slider_display', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_slider_display', array (
		'label'           => esc_html__( 'Display Slider', 'anymags' ),
		'section'         => 'anymags_slider_section',
		'priority'        => 2,
		'type'            => 'checkbox',
	
	) );

	//category wise post
	$categories = get_categories();

	$cats = array();
	$i = 0;
	foreach($categories as $category){
	    if($i==0){
	        $default = $category->slug;
	        $i++;
	    }
	    $cats[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('anymags_featured_category', array(
	    'default'        => $default,
	    'sanitize_callback' => 'anymags_sanitize_select',
	));

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'anymags_featured_category', array(
	    'label' => 'Select category vise post',
	    'description' => '',
	    'section' => 'anymags_slider_section',
	    'settings' => 'anymags_featured_category',
	    'priority'        => 4,
	    'type'    => 'select',
	    'choices' => $cats,
	    'active_callback' => 'anymags_slider_callback'
	)));


	// Number of post
	$wp_customize->add_setting ( 'anymags_number_of_post', array(
		'default'           => 10,
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control ( 'anymags_number_of_post', array(
		'label'    => esc_html__( 'Number of Post', 'anymags' ),
		'section'  => 'anymags_slider_section',
		'priority' => 7,
		'type'     => 'number',
		'active_callback' => 'anymags_slider_callback'
	) );


	/*Blog Post Options Section*/
	$wp_customize->add_section( 'anymags_general_options', array (
		'title'     => esc_html__( 'General Options', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10,
		'description' => esc_html__( 'Personalize the settings of your theme.', 'anymags' ),
	) );

	

	// Read More Label
	$wp_customize->add_setting ( 'anymags_read_more_label', array(
		'default'           => esc_html__( 'Read More', 'anymags' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control ( 'anymags_read_more_label', array(
		'label'    => esc_html__( 'Read More Label', 'anymags' ),
		'section'  => 'anymags_general_options',
		'priority' => 1,
		'type'     => 'text',
	) );

	// Excerpt Length
	$wp_customize->add_setting ( 'anymags_excerpt_length', array(
		'default'           => esc_html__( '55', 'anymags' ),
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control ( 'anymags_excerpt_length', array(
		'label'    => esc_html__( 'Excerpt Length', 'anymags' ),
		'description' => esc_html__( '0 will not show the excerpt.', 'anymags' ),
		'section'  => 'anymags_general_options',
		'priority' => 2,
		'type'     => 'number',
	) );

	/*Blog Post Options*/
	$wp_customize->add_section( 'anymags_archive_content_options', array (
		'title'     => esc_html__( 'Blog Post Options', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10,
		'description' => esc_html__( 'Setting will also apply on archieve and search page.', 'anymags' ),
	) );

	/*======================*/

	// Post Author Display Control
	$wp_customize->add_setting ( 'anymags_archive_co_post_author', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_archive_co_post_author', array (
		'label'           => esc_html__( 'Display Author', 'anymags' ),
		'section'         => 'anymags_archive_content_options',
		'priority'        => 2,
		'type'            => 'checkbox',
	) );

	// Post Date Display Control
	$wp_customize->add_setting ( 'anymags_archive_co_post_date', array (
		'default'           =>  true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_archive_co_post_date', array (
		'label'           => esc_html__( 'Display Date', 'anymags' ),
		'section'         => 'anymags_archive_content_options',
		'priority'        => 3,
		'type'            => 'checkbox',
	) );

	// Featured Image Archive Control
	$wp_customize->add_setting ( 'anymags_archive_co_featured_image', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_archive_co_featured_image', array (
		'label'           => esc_html__( 'Display Featured Image', 'anymags' ),
		'section'         => 'anymags_archive_content_options',
		'priority'        => 5,
		'type'            => 'checkbox',
	) );

	/*Single Post Options*/
	$wp_customize->add_section( 'anymags_single_content_options', array (
		'title'     => esc_html__( 'Single Post Options', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10,
		'description' => esc_html__( 'Setting will apply on the content of single posts.', 'anymags' ),
	) );


	// Post Author Display Control
	$wp_customize->add_setting ( 'anymags_single_co_post_author', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_single_co_post_author', array (
		'label'           => esc_html__( 'Display Author', 'anymags' ),
		'section'         => 'anymags_single_content_options',
		'priority'        => 2,
		'type'            => 'checkbox',
	) );

	// Post Date Display Control
	$wp_customize->add_setting ( 'anymags_single_co_post_date', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_single_co_post_date', array (
		'label'           => esc_html__( 'Display Date', 'anymags' ),
		'section'         => 'anymags_single_content_options',
		'priority'        => 3,
		'type'            => 'checkbox',
	) );


	// Single Post Tags Display Control
	$wp_customize->add_setting ( 'anymags_single_co_post_tags', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_single_co_post_tags', array (
		'label'           => esc_html__( 'Display Tags', 'anymags' ),
		'section'         => 'anymags_single_content_options',
		'priority'        => 5,
		'type'            => 'checkbox',
	) );

	// Featured Image Post Display Control
	$wp_customize->add_setting ( 'anymags_single_co_featured_image_post', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_single_co_featured_image_post', array (
		'label'           => esc_html__( 'Display Featured Image', 'anymags' ),
		'section'         => 'anymags_single_content_options',
		'priority'        => 7,
		'type'            => 'checkbox',
	) );


	//Sidebar Section

	$wp_customize->add_section( 'anymags_sidebar_section', array (
		'title'     => esc_html__( 'Anymags Sidebar setting', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10
	) );
	
	// Main Sidebar Position
	$wp_customize->add_setting ( 'anymags_sidebar_position', array (
		'default'           => esc_html__( 'right', 'anymags' ),
		'sanitize_callback' => 'anymags_sanitize_select',
	) );

	$wp_customize->add_control ( 'anymags_sidebar_position', array (
		'label'    => esc_html__( 'Sidebar Position', 'anymags' ),
		'section'  => 'anymags_sidebar_section',
		'priority' => 2,
		'type'     => 'select',
		'choices'  => array(
			'right' => esc_html__( 'Right Sidebar', 'anymags'),
			'left'  => esc_html__( 'Left Sidebar',  'anymags'),
			'no'  => esc_html__( 'No Sidebar',  'anymags'),
		),
	) );

	//Footer Section

	$wp_customize->add_section( 'anymags_footer_section', array (
		'title'     => esc_html__( 'Anymags Footer setting', 'anymags' ),
		'panel'     => 'anymags_theme_options',
		'priority'  => 10
	) );

	//Footer bottom Copyright Display Control
	$wp_customize->add_setting ( 'anymags_footer_copyright_display', array (
		'default'           => true,
		'sanitize_callback' => 'anymags_sanitize_checkbox',
	) );

	$wp_customize->add_control ( 'anymags_footer_copyright_display', array (
		'label'           => esc_html__( 'Display Copyright Footer', 'anymags' ),
		'section'         => 'anymags_footer_section',
		'priority'        => 1,
		'type'            => 'checkbox',
	) );

	// Copyright Control
	$wp_customize->add_setting ( 'anymags_copyright', array (
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control ( 'anymags_copyright', array (
		'label'    => esc_html__( 'Copyright', 'anymags' ),
		'section'  => 'anymags_footer_section',
		'priority' => 2,
		'type'     => 'textarea',
		'active_callback'=> 'anymags_footer_copyright_callback'
	) );




}
add_action( 'customize_register', 'anymags_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function anymags_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function anymags_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function anymags_customize_preview_js() {
	wp_enqueue_script( 'anymags-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'anymags_customize_preview_js' );
/*callback function for top header section*/

if ( !function_exists('anymags_header_social_active_callback') ) :
  function anymags_header_social_active_callback(){
  	  $show_social = get_theme_mod('anymags_left_header_social_icon_display',true);
      
      if( $show_social){
          return true;
      }
      else{
          return false;
      }
  }
endif;

if ( !function_exists('anymags_footer_copyright_callback') ) :
  function anymags_footer_copyright_callback(){
  
  	  $show_copyright = get_theme_mod('anymags_footer_copyright_display',true);
      
      if( true == $show_copyright ){
          return true;
      }
      else{
          return false;
      }
  }
endif;

if ( !function_exists('anymags_slider_callback') ) :
  function anymags_slider_callback(){
  
  	  $show_copyright = get_theme_mod('anymags_slider_display',true);
      
      if( true == $show_copyright ){
          return true;
      }
      else{
          return false;
      }
  }
endif;
<?php
/**
 * The cpt plugin class.
 *
 * This is used to define the custom post type that will be used for galleries
 *
 * @since      1.0.1
 */
class Accordion_Slider_CPT {
    
	private $labels    = array();
	private $args      = array();
	private $metaboxes = array();
	private $cpt_name;
    private $builder;
    
    
	public function __construct() {

        $this->labels = apply_filters('accordion_slider_cpt_labels', array(
            'singular_name'         => esc_html__( 'Accordion Slider', 'accordion-slider' ),
			'menu_name'             => esc_html__( 'Accordion Slider', 'accordion-slider' ),
			'name_admin_bar'        => esc_html__( 'Accordion Slider', 'accordion-slider' ),
			'archives'              => esc_html__( 'Item Archives', 'accordion-slider' ),
			'attributes'            => esc_html__( 'Item Attributes', 'accordion-slider' ),
			'parent_item_colon'     => esc_html__( 'Parent Item:', 'accordion-slider' ),
			'all_items'             => esc_html__( 'All Accordion', 'accordion-slider' ),
			'add_new_item'          => esc_html__( 'Add New Item', 'accordion-slider' ),
			'add_new'               => esc_html__( 'Add New', 'accordion-slider' ),
			'new_item'              => esc_html__( 'New Item', 'accordion-slider' ),
			'edit_item'             => esc_html__( 'Edit Item', 'accordion-slider' ),
			'update_item'           => esc_html__( 'Update Item', 'accordion-slider' ),
			'view_item'             => esc_html__( 'View Item', 'accordion-slider' ),
			'view_items'            => esc_html__( 'View Items', 'accordion-slider' ),
			'search_items'          => esc_html__( 'Search Item', 'accordion-slider' ),
			'not_found'             => esc_html__( 'Not found', 'accordion-slider' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'accordion-slider' ),
			'featured_image'        => esc_html__( 'Featured Image', 'accordion-slider' ),
			'set_featured_image'    => esc_html__( 'Set featured image', 'accordion-slider' ),
			'remove_featured_image' => esc_html__( 'Remove featured image', 'accordion-slider' ),
			'use_featured_image'    => esc_html__( 'Use as featured image', 'accordion-slider' ),
			'insert_into_item'      => esc_html__( 'Insert into item', 'accordion-slider' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'accordion-slider' ),
			'items_list'            => esc_html__( 'Items list', 'accordion-slider' ),
			'items_list_navigation' => esc_html__( 'Items list navigation', 'accordion-slider' ),
			'filter_items_list'     => esc_html__( 'Filter items list', 'accordion-slider' ),
        ));

        $this->args = apply_filters( 'accordion_slider_cpt_args', array(
			'label'                 => esc_html__( 'Accordion Slider', 'accordion-slider' ),
			'description'           => esc_html__( 'Accordion Slider Post Type Description.', 'accordion-slider' ),
			'supports'              => array( 'title' ),
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-images-alt2',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'rewrite'               => false,
			'show_in_rest'          => true,
        ) );
        
        $this->metaboxes = apply_filters( 'accordion_slider_cpt_metaboxes', array(
			'accordion-slider-builder' => array(
				'title' => esc_html__( 'Gallery Images', 'accordion-slider' ),
				'callback' => 'output_accordion_slider_builder',
				'context' => 'normal',
			),
			'accordion-slider-settings' => array(
				'title' => esc_html__( 'Settings', 'accordion-slider' ),
				'callback' => 'output_gallery_settings',
				'context' => 'normal',
			),
			'accordion-slider-upgrade-to-pro' => array(
				'title' => esc_html__( 'Upgrade To Pro', 'accordion-slider' ),
				'callback' => 'output_upgrade_to_pro',
				'context' => 'side',
			),
			'accordion-slider-shortcode' => array(
				'title' => esc_html__( 'Shortcode', 'accordion-slider' ),
			 	'callback' => 'output_gallery_shortcode',
			 	'context' => 'side',
			 	'priority' => 'default',
			 ),
        ) );
        
		$this->cpt_name = apply_filters( 'accordion_slider_cpt_name', 'accordion_slider' );

        add_action( 'init', array( $this, 'register_cpt' ) );

        /* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'meta_boxes_setup' ) );
        add_action( 'load-post-new.php', array( $this, 'meta_boxes_setup' ) );

  		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'asg_register_menu'), 12 );        
        
		// Post Table Columns
		add_filter( "manage_{$this->cpt_name}_posts_columns", array( $this, 'add_columns' ) );
		add_action( "manage_{$this->cpt_name}_posts_custom_column" , array( $this, 'output_column' ), 10, 2 );

		/* Load Fields Helper */
		require_once ACCORDION_SLIDER_ADMIN . 'class-accordion-slider-cpt-fields-helper.php';

		/* Load Builder */
		require_once ACCORDION_SLIDER_ADMIN . 'class-accordion-slider-field-builder.php';
		$this->builder = Accordion_Slider_Field_Builder::get_instance();

		/* Initiate Image Resizer */
		$this->resizer = new Accordion_Slider_Image();

	}
    
	public function register_cpt() {

		$args = $this->args;
		$args['labels'] = $this->labels;
		register_post_type( $this->cpt_name, $args );

    }
    public function meta_boxes_setup() {
		/* Add meta boxes on the 'add_meta_boxes' hook. */
  		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

  		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 2 );
    }

    public function asg_register_menu() {

		// How It Work Page
		add_submenu_page( 'edit.php?post_type='.'accordion_slider', __('Documentation, our plugins and offers', 'accordion-slider'), __('Documentation', 'accordion-slider'), 'manage_options', 'asg-designs', array($this, 'asg_designs_page') );

		// Register plugin premium page
		add_submenu_page( 'edit.php?post_type='.'accordion_slider', __('Upgrade To Premium -  Timeline Event History', 'accordion-slider'), '<span style="color:#57a7c9">'.__('Upgrade To Premium', 'accordion-slider').'</span>', 'manage_options', 'asg-premium', array($this, 'asg_premium_page') );

		// Installation Other WPdiscover plugin
		add_submenu_page( 'edit.php?post_type='.'accordion_slider', __('Install Popular Plugins From WPdiscover', 'accordion-slider'), '<span style="color:#ff2700">'.__('Install Popular Plugins From WPdiscover', 'accordion-slider').'</span>', 'manage_options', 'asg-dashboard', array($this, 'asg_dashboard_page') );

	}

	function asg_designs_page() {
		include_once( ACCORDION_SLIDER_INCLUDES . 'admin/asg-how-it-work.php' );
	}

	function asg_premium_page() {
		include_once( ACCORDION_SLIDER_INCLUDES . 'admin/asg-premium.php' );
	}

	function asg_dashboard_page() {
		include_once( ACCORDION_SLIDER_INCLUDES . 'admin/asg-dashboard.php' );
	}
    
    
	public function add_meta_boxes() {

		global $post;

		foreach ( $this->metaboxes as $metabox_id => $metabox ) {
            
            if ( 'accordion-slider-shortcode' == $metabox_id && 'auto-draft' == $post->post_status ) {
				break;
			}
            
			add_meta_box(
                $metabox_id,      // Unique ID
			    $metabox['title'],    // Title
			    array( $this, $metabox['callback'] ),   // Callback function
			    'accordion_slider',         // Admin page (or post type)
			    $metabox['context'],         // Context
			    'high'         // Priority
			);
		}

    }
    
    public function output_accordion_slider_builder() {
 		 $this->builder->render( 'gallery' );
	}

	public function output_gallery_settings() {
        $this->builder->render( 'settings' );	
	}



	public function output_gallery_shortcode( $post ) {
		$this->builder->render( 'shortcode', $post );
	}

	public function output_upgrade_to_pro() {
        $this->builder->render( 'upgrade-to-pro' );
	}

    
	public function save_meta_boxes( $post_id, $post ) {

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) || 'accordion_slider' != $post_type->name ) {
			return $post_id;
		}

		// We need to resize our images
		$images = get_post_meta( $post_id, 'slider-images', true );
		if ( $images && is_array( $images ) ) {
			if ( isset( $_POST['accordion-slider-settings']['img_size'] ) && apply_filters( 'accordion_slider_resize_images', true, $_POST['accordion-slider-settings'] ) ) {

				$gallery_type = isset( $_POST['accordion-slider-settings']['type'] ) ? sanitize_text_field($_POST['accordion-slider-settings']['type']) : 'creative-gallery';
				$img_size = absint( $_POST['accordion-slider-settings']['img_size'] );
				
				foreach ( $images as $image ) {
					$grid_sizes = array(
						'width' => isset( $image['width'] ) ? absint( $image['width'] ) : 1,
						'height' => isset( $image['height'] ) ? absint( $image['height'] ) : 1,
					);
					$sizes = $this->resizer->get_image_size( $image['id'], $img_size, $gallery_type, $grid_sizes );
					if ( ! is_wp_error( $sizes ) ) {
						$this->resizer->resize_image( $sizes['url'], $sizes['width'], $sizes['height'] );
					}

				}

			}
		}

		if ( isset( $_POST['accordion-slider-settings'] ) ) {

			
			$fields_with_tabs = Accordion_Slider_WP_CPT_Fields_Helper::get_fields( 'all' );

			// Here we will save all our settings
			$accordion_slider_settings = array();

			// We will save only our settings.
			foreach ( $fields_with_tabs as $tab => $fields ) {

			    // We will iterate throught all fields of current tab
				foreach ( $fields as $field_id => $field ) {

					if ( isset( $_POST['accordion-slider-settings'][ $field_id ] ) ) {

						
						switch ( $field_id ) {
							case 'description':
								$accordion_slider_settings[ $field_id ] = wp_filter_post_kses( $_POST['accordion-slider-settings'][ $field_id ] );
								break;
							case 'img_size':
							
							case 'captionFontSize':
							case 'titleFontSize':
							case 'captionColor':
							
							default:
								if( is_array( $_POST['accordion-slider-settings'][ $field_id ] ) ){
									$sanitized = array_map( 'sanitize_text_field', $_POST['accordion-slider-settings'][ $field_id ] );
									$accordion_slider_settings[ $field_id ] = apply_filters( 'accordion_slider_settings_field_sanitization', $sanitized, $field_id, $field );
								}else{
									$accordion_slider_settings[ $field_id ] = apply_filters( 'accordion_slider_settings_field_sanitization', sanitize_text_field( $_POST['accordion-slider-settings'][ $field_id ] ), $field_id, $field );
								}

								break;
						}

					}else{
						if ( 'toggle' == $field['type'] ) {
							$accordion_slider_settings[ $field_id ] = '0';
						}else{
							$accordion_slider_settings[ $field_id ] = '';
						}
					}

				}

			}

			// Add settings to gallery meta
			update_post_meta( $post_id, 'accordion-slider-settings', $accordion_slider_settings );

		}

	}

    

    public function add_columns( $columns ){

		$date = $columns['date'];
		unset( $columns['date'] );
		$columns['shortcode'] = esc_html__( 'Shortcode', 'accordion-slider' );
		$columns['date'] = $date;

		return $columns;

	}

	public function output_column( $column, $post_id ){

		if ( 'shortcode' == $column ) {
			$shortcode = '[accordion-slider id="' . $post_id . '"]';
			echo '<input type="text" value="' . esc_attr( $shortcode ) . '"  onclick="select()" readonly style="width:32%;">';
            /*echo '<a href="#" class="copy-accordion-slider-shortcode button button-primary" style="margin-left:15px;">'.esc_html__('Copy shortcode','accordion-slider').'</a><span style="margin-left:15px;"></span>';*/
		}

	}

}


function asg_sort_plugin_data( $a, $b ) {

	$a_active_installs = is_numeric( $a['active_installs'] ) ? $a['active_installs'] : 0;
	$b_active_installs = is_numeric( $b['active_installs'] ) ? $b['active_installs'] : 0;
	
	if ($a_active_installs == $b_active_installs) {
		return 0;
	}
	return ($a_active_installs > $b_active_installs) ? -1 : 1;
}

function asg_get_plugin_data() {

	// Get cache result
	$plugins_data = get_transient( 'asg_plugins_data' );

	// If no cache is there
	if( empty( $plugins_data ) ) {

		// Call Plugin API
		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin-install.php';
		}

		$plugins_data = plugins_api( 'query_plugins', array(
											'per_page'	=> 60,
											'author'	=> 'wpdiscover',
											'fields'	=> array(
																'icons'				=> true,
																'active_installs'	=> true,
															)
										) );

		if( is_wp_error( $plugins_data ) || empty( $plugins_data->plugins ) ) {

			$file = WPOS_ESPBW_DIR . 'plugins-data.json';

			// We don't need to write to the file, so just open for reading.
			$fp = fopen( $file, 'r' );

			// Pull data of the file in.
			$file_data = fread( $fp, 1024 * KB_IN_BYTES );

			// Close file handle
			fclose( $fp );

			$file_data				= utf8_encode($file_data); 
			$plugins_data_arr		= json_decode( $file_data, true );
			$plugins_data			= json_decode( $file_data );
			$plugins_data->plugins	= $plugins_data_arr['plugins'];
		}

		if( ! is_wp_error( $plugins_data ) && ! empty( $plugins_data->plugins ) ) {

			// Sort the data based on active install
			usort( $plugins_data->plugins, "asg_sort_plugin_data" );

			set_transient( 'asg_plugins_data', $plugins_data, (12 * HOUR_IN_SECONDS) );
		}
	}

	return $plugins_data;
}


function asg_plugins_filter() {

	$plugin_filters = array(
		'photo-gallery-builder'						=> array(
												'class' => 'asg-photo-gallery-builder',
												'tags'	=> 'gallery, image slider, lightbox',
											),
		'accordion-slider-gallery'			=> array(
												'class' => 'asg-accordion-slider-gallery',
												'tags'	=> 'accordion slider, Accordion Slider Block',
											),

		'blog-manager-wp'			=> array(
												'class' => 'asg-blog-manager-wp',
												'tags'	=> 'blog design, blog layout, blog template, custom blog template, wordpress blog',
											),
		'coming-soon-countdown'			=> array(
												'class' => 'asg-coming-soon-countdown',
												'tags'	=> 'admin, coming soon, offline mode, site offline',
											),
		'client-partner-showcase'			=> array(
												'class' => 'asg-client-partner-showcase',
												'tags'	=> 'Client, partner, sponsors',
											),
		'pricetable-wp'			=> array(
												'class' => 'asg-pricetable-wp',
												'tags'	=> 'price, price table, pricing, table price',
											),
		'social-feed-gallery-portfolio'			=> array(
												'class' => 'asg-social-feed-gallery-portfolio',
												'tags'	=> 'instagram gallery, instagram post, Instagram widget',
											),
		
	);
	return $plugin_filters;
}


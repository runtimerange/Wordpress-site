<?php
/**
    * Plugin Name: Blog Manager WP
    * Plugin URI: http://wordpress.org/plugins/blog-manager-wp
    * Description: To make your blog design more pretty, attractive, colorful and Featured.
    * Author: wpdiscover
    * Author URI: #
    * Version: 1.0.2
    * Text Domain: blog-manager-wp
 */
/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}
if(!defined( 'BLOGMANAGER_WP_PLUGIN_UPGRADE' ) ) {
    define('BLOGMANAGER_WP_PLUGIN_UPGRADE','https://blogwpthemes.com/downloads/blog-manager-pro-wordpress-plugin/'); // Plugin Check link
}

define('PBSM_URL', plugin_dir_url(__FILE__));
define('PBSM_DIR', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, 'pbsm_plugin_activate');
register_deactivation_hook(__FILE__, 'pbsm_update_optin');
add_action('admin_menu', 'pbsm_add_menu');
add_action('admin_init', 'pbsm_redirection', 1);
add_action('admin_init', 'pbsm_reg_function', 5);
add_action('admin_init', 'pbsm_session_start',1);
add_action('admin_init', 'pbsm_save_settings', 10);
add_action('admin_init', 'pbsm_admin_scripts');
add_action('wp_head', 'pbsm_stylesheet', 20);
add_action('wp_head', 'pbsm_ajaxurl', 5);
add_action('wp_ajax_nopriv_pbsm_get_page_link', 'pbsm_get_page_link');
add_action('wp_ajax_pbsm_get_page_link', 'pbsm_get_page_link');
add_action('wp_ajax_pbsm_closed_bdboxes', 'pbsm_closed_bdboxes');
add_action('wp_ajax_pbsm_template_search_result', 'pbsm_template_search_result');
add_action('wp_ajax_pbsm_create_sample_layout', 'pbsm_create_sample_layout');
add_filter('excerpt_length', 'pbsm_excerpt_length', 999);
add_action('plugins_loaded', 'pbsm_load_language_files');

add_image_size( 'pbsm_image_slider',1600,900,true);

// All script Goes Here
require PBSM_DIR . 'includes/shortcode.php';

// Shortcode
require PBSM_DIR . 'includes/scripts.php';

/**
 * Extra Function and Addons
 * VC Support
 * Fusion page builder support
 */
require PBSM_DIR . 'includes/extra-functions.php';

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'pbsm_plugin_links');

/**
 * add menu at admin panel
 */
function pbsm_add_menu() {
    $pbsm_is_optin = get_option('pbsm_is_optin');
    if ($pbsm_is_optin == 'yes' || $pbsm_is_optin == 'no') {
        add_menu_page(__('Blog Manager', 'blog-manager-wp'), __('Blog Manager', 'blog-manager-wp'), 'administrator', 'pbsm_settings', 'pbsm_main_menu_function', PBSM_URL . 'assets/images/pbsm.png');
    } else {
        add_menu_page(__(' Blog Manager', 'blog-manager-wp'), __('Blog Manager', 'blog-manager-wp'), 'administrator', 'pbsm_welcome_page', 'pbsm_welcome_function', PBSM_URL . 'assets/images/pbsm.png');
    }
    add_submenu_page('pbsm_settings', __('Blog Manager Settings', 'blog-manager-wp'), __('Blog Manager Settings', 'blog-manager-wp'), 'manage_options', 'pbsm_settings', 'pbsm_add_menu');
    add_submenu_page('pbsm_settings', __('Getting Started', 'blog-manager-wp'), __('Getting Started', 'blog-manager-wp'), 'manage_options', 'pbsm_getting_started', 'pbsm_getting_started');
    add_submenu_page('pbsm_settings', __('Documentation', 'blog-manager-wp'), __('Documentation', 'blog-manager-wp'), 'manage_options', 'pbsm_documentation', 'pbsm_documentation');
    add_submenu_page('pbsm_settings', __('Upgrade To Premium', 'blog-manager-wp'), '<span style="color:#57a7c9">'.__('Upgrade To Premium', 'blog-manager-wp').'</span>', 'manage_options', 'pbsm_upgrade_to_premium', 'pbsm_upgrade_to_premium');
    add_submenu_page('pbsm_settings', __('Install Popular Plugins From WPdiscover', 'blog-manager-wp'), '<span style="color:#ff2700">'.__('Install Popular Plugins From WPdiscover', 'blog-manager-wp').'</span>', 'manage_options', 'pbsm_other_plugin', 'pbsm_other_plugin');
}

/**
 * Include admin getting started page
 */
function pbsm_getting_started() {
    include_once 'includes/getting_started.php';
}

/**
 * Include admin documentation page
 */
function pbsm_documentation() {
    include_once 'includes/documentation.php';
}

/**
 * Include upgrade to premium page
 */
function pbsm_upgrade_to_premium() {
    include_once 'includes/upgrade_to_premium.php';
}

/**
 * Include other plugin page
 */
function pbsm_other_plugin() {
    include_once 'includes/other_plugin.php';
}

/**
 * Loads plugin textdomain
 */
function pbsm_load_language_files() {
    load_plugin_textdomain('blog-manager-wp', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

/**
 * Deactivate pro version when lite version is activated
 */
function pbsm_plugin_activate() {
    add_option('pbsm_plugin_do_activation_redirect', false);
    add_option('pbsm_is_optin', 'no' );
}

/**
 * Delete optin on deactivation of plugin
 */
function pbsm_update_optin() {
    update_option('pbsm_is_optin', '');
}

/**
 * Redirection on welcome page
 */
function pbsm_redirection() {
    if (is_user_logged_in()) {
        if (get_option('pbsm_plugin_do_activation_redirect', false)) {
            delete_option('pbsm_plugin_do_activation_redirect');
            if (!isset($_GET['activate-multi'])) {
                $pbsm_is_optin = get_option('pbsm_is_optin');
                if ($pbsm_is_optin == 'yes' || $pbsm_is_optin == 'no') {
                    exit(wp_redirect(admin_url('admin.php?page=pbsm_getting_started')));
                } else {
                    exit(wp_redirect(admin_url('admin.php?page=pbsm_welcome_page')));
                }
            }
        }
    }
}

/**
 * Get template list
 */
function pbsm_template_list() {
    $tempate_list = array(
        'grid-layout' => array(
            'template_name' => __('Grid Template', 'blog-manager-wp'),
            'class' => 'grid free',
            'image_name' => 'grid-layout.jpg',
            'demo_link' => esc_url('#'),
        ),
        'default_layout' => array(
            'template_name' => __('Default Layout Template', 'blog-manager-wp'),
            'class' => 'full-width free',
            'image_name' => 'default_layout.jpg',
            'demo_link' => esc_url('#'),
        ),
        'default_slider' => array(
            'template_name' => __('Crayon Slider Template', 'blog-manager-wp'),
            'class' => 'slider free',
            'image_name' => 'default_slider.jpg',
            'demo_link' => esc_url('#')
        ),
        'center_top' => array(
            'template_name' => __('Center Top Template', 'blog-manager-wp'),
            'class' => 'full-width free',
            'image_name' => 'center_top.jpg',
            'demo_link' => esc_url('#'),
        ),
        'news_feed' => array(
            'template_name' => __('News Feed Template', 'blog-manager-wp'),
            'class' => 'magazine free',
            'image_name' => 'news_feed.jpg',
            'demo_link' => esc_url('#'),
        ),
        'timeline' => array(
            'template_name' => __('Timeline Template', 'blog-manager-wp'),
            'class' => 'timeline free',
            'image_name' => 'timeline.jpg',
            'demo_link' => esc_url('#'),
        ),
        'default_slider' => array(
            'template_name' => __('Default Slider Template', 'blog-manager-wp'),
            'class' => 'slider free',
            'image_name' => 'default_slider.jpg',
            'demo_link' => esc_url('#'),
        ),
        'style-1'            => array(
                'template_name' => esc_html__( 'Style 1', 'blog-manager-wp' ),
                'class'         => 'slider',
                'image_name'    => 'style-1.jpg',
                'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-1/' ),
        ),
        'style-2'            => array(
                'template_name' => esc_html__( 'Style 2', 'blog-manager-wp' ),
                'class'         => 'slider',
                'image_name'    => 'style-2.jpg',
                'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-2/' ),
        ),
        'style-3'            => array(
                'template_name' => esc_html__( 'Style 3', 'blog-manager-wp' ),
                'class'         => 'grid',
                'image_name'    => 'style-3.jpg',
                'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-3/' ),
            ),
        'style-4'            => array(
            'template_name' => esc_html__( 'Style 4', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-4.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-4/' ),
        ),
        'style-5'            => array(
            'template_name' => esc_html__( 'Style 5', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-5.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-5/' ),
        ),
        'style-6'            => array(
            'template_name' => esc_html__( 'Style 6', 'blog-manager-wp' ),
            'class'         => 'slider',
            'image_name'    => 'style-6.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-6/' ),
        ),
        'style-7'            => array(
            'template_name' => esc_html__( 'Style 7', 'blog-manager-wp' ),
            'class'         => 'slider',
            'image_name'    => 'style-7.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-7/' ),
        ),
        'style-8'            => array(
            'template_name' => esc_html__( 'Style 8', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-8.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-8/' ),
        ),
        'style-9'            => array(
            'template_name' => esc_html__( 'Style 9', 'blog-manager-wp' ),
            'class'         => 'timeline',
            'image_name'    => 'style-9.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-9/' ),
        ),
        'style-10'            => array(
            'template_name' => esc_html__( 'Style 10', 'blog-manager-wp' ),
            'class'         => 'timeline',
            'image_name'    => 'style-10.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-10/' ),
        ),
        'style-11'            => array(
            'template_name' => esc_html__( 'Style 11', 'blog-manager-wp' ),
            'class'         => 'timeline slider',
            'image_name'    => 'style-11.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-11/' ),
        ),
        'style-12'            => array(
            'template_name' => esc_html__( 'Style 12', 'blog-manager-wp' ),
            'class'         => 'timeline',
            'image_name'    => 'style-12.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-12/' ),
        ),
        'style-13'            => array(
            'template_name' => esc_html__( 'Style 13', 'blog-manager-wp' ),
            'class'         => 'timeline slider',
            'image_name'    => 'style-13.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-13/' ),
        ),
        'style-14'            => array(
            'template_name' => esc_html__( 'Style 14', 'blog-manager-wp' ),
            'class'         => 'list',
            'image_name'    => 'style-14.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-14/' ),
        ),
        'style-15'            => array(
            'template_name' => esc_html__( 'Style 15', 'blog-manager-wp' ),
            'class'         => 'list',
            'image_name'    => 'style-15.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-15/' ),
        ),
        'style-16'            => array(
            'template_name' => esc_html__( 'Style 16', 'blog-manager-wp' ),
            'class'         => 'list',
            'image_name'    => 'style-16.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-16/' ),
        ),
        'style-17'            => array(
            'template_name' => esc_html__( 'Style 17', 'blog-manager-wp' ),
            'class'         => 'list',
            'image_name'    => 'style-17.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-17/' ),
        ),
        'style-18'            => array(
            'template_name' => esc_html__( 'Style 18', 'blog-manager-wp' ),
            'class'         => 'list',
            'image_name'    => 'style-18.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-18/' ),
        ),
        'style-19'            => array(
            'template_name' => esc_html__( 'Style 19', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-19.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-19/' ),
        ),
        'style-20'            => array(
            'template_name' => esc_html__( 'Style 20', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-20.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-20/' ),
        ),
        'style-21'            => array(
            'template_name' => esc_html__( 'Style 21', 'blog-manager-wp' ),
            'class'         => 'masonry',
            'image_name'    => 'style-21.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-21/' ),
        ),
        'style-22'            => array(
            'template_name' => esc_html__( 'Style 22', 'blog-manager-wp' ),
            'class'         => 'masonry',
            'image_name'    => 'style-22.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-22/' ),
        ),
        'style-23'            => array(
            'template_name' => esc_html__( 'Style 23', 'blog-manager-wp' ),
            'class'         => 'masonry',
            'image_name'    => 'style-23.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-23/' ),
        ),
        'style-24'            => array(
            'template_name' => esc_html__( 'Style 24', 'blog-manager-wp' ),
            'class'         => 'masonry',
            'image_name'    => 'style-24.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-24/' ),
        ),
        'style-25'            => array(
            'template_name' => esc_html__( 'Style 25', 'blog-manager-wp' ),
            'class'         => 'masonry',
            'image_name'    => 'style-25.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-25/' ),
        ),
        'style-26'            => array(
            'template_name' => esc_html__( 'Style 26', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-26.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-26/' ),
        ),
        'style-27'            => array(
            'template_name' => esc_html__( 'Style 27', 'blog-manager-wp' ),
            'class'         => 'slider',
            'image_name'    => 'style-27.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-27/' ),
        ),
        'style-28'            => array(
            'template_name' => esc_html__( 'Style 28', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-28.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-28/' ),
        ),
        'style-29'            => array(
            'template_name' => esc_html__( 'Style 29', 'blog-manager-wp' ),
            'class'         => 'grid',
            'image_name'    => 'style-29.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-29/' ),
        ),
        'style-30'            => array(
            'template_name' => esc_html__( 'Style 30', 'blog-manager-wp' ),
            'class'         => 'timeline slider',
            'image_name'    => 'style-30.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-30/' ),
        ),
        'style-31'            => array(
            'template_name' => esc_html__( 'Style 31', 'blog-manager-wp' ),
            'class'         => 'magazine',
            'image_name'    => 'style-31.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-31/' ),
        ),
        'style-32'            => array(
            'template_name' => esc_html__( 'Style 32', 'blog-manager-wp' ),
            'class'         => 'magazine',
            'image_name'    => 'style-32.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-32/' ),
        ),
        'style-33'            => array(
            'template_name' => esc_html__( 'Style 33', 'blog-manager-wp' ),
            'class'         => 'magazine',
            'image_name'    => 'style-33.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-33/' ),
        ),
        'style-34'            => array(
            'template_name' => esc_html__( 'Style 34', 'blog-manager-wp' ),
            'class'         => 'magazine',
            'image_name'    => 'style-34.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-34/' ),
        ),
        'style-35'            => array(
            'template_name' => esc_html__( 'Style 35', 'blog-manager-wp' ),
            'class'         => 'magazine',
            'image_name'    => 'style-35.jpg',
            'demo_link'     => esc_url( 'https://blogwpthemes.com/demo/blog-manager-pro/design-35/' ),
        ),
    );
    //ksort($tempate_list);
    return $tempate_list;
}

/**
 * Ajax handler for Store closed box id
 */
function pbsm_closed_bdboxes() {
    $closed = isset( $_POST['closed'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_POST['closed'] ) ) ) : array();
    $page   = isset( $_POST['page'] ) ? sanitize_text_field( wp_unslash( $_POST['page'] ) ) : ''; 
    if ($page != sanitize_key($page)) {
        wp_die(0);
    }
    if (!$user = wp_get_current_user()) {
        wp_die(-1);
    }
    if (is_array($closed)) {
        update_user_option($user->ID, "bdpclosedbdpboxes_$page", $closed, true);
    }
    wp_die(1);
}

function pbsm_ajaxurl() {
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
}

/**
 * Ajax handler for page link
 */
function pbsm_get_page_link() {
    if (isset($_POST['page_id'])) {
        $page_id = intval($_POST['page_id']);
        echo '<a target="_blank" href="' . get_permalink($page_id) . '">' . __('View Blog', 'blog-manager-wp') . '</a>';
    }
    exit();
}

/**
 *
 * @param type $id
 * @param type $page
 * @return type closed class
 */
function pbsm_postbox_classes($id, $page) {
    if (!isset($_GET['action'])) {
        $closed = array('bdpgeneral');
        $closed = array_filter($closed);
        $page = 'pbsm_settings';
        $user = wp_get_current_user();
        if (is_array($closed)) {
            update_user_option($user->ID, "bdpclosedbdpboxes_$page", $closed, true);
        }
    }
    if ($closed = get_user_option('bdpclosedbdpboxes_' . $page)) {
        if (!is_array($closed)) {
            $classes = array('');
        } else {
            $classes = in_array($id, $closed) ? array('closed') : array('');
        }
    } else {
        $classes = array('');
    }
    return implode(' ', $classes);
}

/**
 * Set default value
 */
function pbsm_reg_function() {
    if (is_user_logged_in()) {
        $settings = get_option('wp_blog_pbsm_settings');
        if (empty($settings)) {
            $settings = array(
                'template_category' => '',
                'template_tags' => '',
                'template_authors' => '',
                'template_name' => 'default_layout',
                'template_bgcolor' => '#ffffff',
                'template_color' => '#dd3333',
                'template_ftcolor' => '#b3b3b3',
                'template_fthovercolor' => '#b3b3b3',
                'template_titlecolor' => '#000000',
                'template_titlehovercolor' => '#b3b3b3',
                'template_titlebackcolor' => '#ffffff',
                'template_contentcolor' => '#b3b3b3',
                'template_readmorecolor' => '#ffffff',
                'template_readmorebackcolor' => '#000000',
                'template_alterbgcolor' => '#ffffff',
            );
            update_option('posts_per_page', '6');
            update_option('display_sticky', '1');
            update_option('display_category', '0');
            update_option('social_icon_style', '0');
            update_option('rss_use_excerpt', '1');
            update_option('template_alternativebackground', '1');
            update_option('display_tag', '0');
            update_option('display_author', '0');
            update_option('display_date', '0');
            update_option('social_share', '1');
            update_option('facebook_link', '0');
            update_option('twitter_link', '0');
            update_option('linkedin_link', '0');
            update_option('pinterest_link', '0');
            update_option('display_comment_count', '0');
            update_option('excerpt_length', '50');
            update_option('display_html_tags', '0');
            update_option('read_more_on', '2');
            update_option('read_more_text', 'Read More');
            update_option('template_titlefontsize', '26');
            update_option('template_titleLineHeight', '30');
            update_option('template_titleLetterSpacing', '0');
            update_option('content_fontsize', '18');
            update_option('content_LineHeight', '22');
            update_option('content_LetterSpacing', '0');
            update_option('wp_blog_pbsm_settings', $settings);
        }
    }
}

/**
 * Save plugin options
 */
function pbsm_save_settings() {
    if (is_user_logged_in() && isset($_POST['blog_nonce']) && wp_verify_nonce($_POST['blog_nonce'], 'blog_nonce_ac')) {
        if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'save' && isset($_REQUEST['updated']) && $_REQUEST['updated'] === 'true') {
            $blog_page_display = '';
            if (isset($_POST['blog_page_display'])) {
                $blog_page_display = intval($_POST['blog_page_display']);
                update_option('blog_page_display', $blog_page_display);
            }
            if (isset($_POST['posts_per_page'])) {
                $posts_per_page = intval($_POST['posts_per_page']);
                update_option('posts_per_page', $posts_per_page);
            }
            if (isset($_POST['rss_use_excerpt'])) {
                $rss_use_excerpt = intval($_POST['rss_use_excerpt']);
                update_option('rss_use_excerpt', $rss_use_excerpt);
            }
            if (isset($_POST['display_date'])) {
                $display_date = intval($_POST['display_date']);
                update_option('display_date', $display_date);
            }
            if (isset($_POST['display_author'])) {
                $display_author = intval($_POST['display_author']);
                update_option('display_author', $display_author);
            }
            if (isset($_POST['display_sticky'])) {
                $display_sticky = intval($_POST['display_sticky']);
                update_option('display_sticky', $display_sticky);
            }
            if (isset($_POST['display_category'])) {
                $display_category = intval($_POST['display_category']);
                update_option('display_category', $display_category);
            }
            if (isset($_POST['display_tag'])) {
                $display_tag = intval($_POST['display_tag']);
                update_option('display_tag', $display_tag);
            }
            if (isset($_POST['txtExcerptlength'])) {
                $txtExcerptlength = intval($_POST['txtExcerptlength']);
                update_option('excerpt_length', $txtExcerptlength);
            }
            if (isset($_POST['display_html_tags'])) {
                $display_html_tags = intval($_POST['display_html_tags']);
                update_option('display_html_tags', $display_html_tags);
            } else {
                update_option('display_html_tags', 0);
            }
            if (isset($_POST['readmore_on'])) {
                $readmore_on = intval($_POST['readmore_on']);
                update_option('read_more_on', $readmore_on);
            }
            if (isset($_POST['txtReadmoretext'])) {
                $txtReadmoretext = sanitize_text_field($_POST['txtReadmoretext']);
                update_option('read_more_text', $txtReadmoretext);
            }
            if (isset($_POST['template_alternativebackground'])) {
                $template_alternativebackground = sanitize_text_field($_POST['template_alternativebackground']);
                update_option('template_alternativebackground', $template_alternativebackground);
            }
            if (isset($_POST['social_icon_style'])) {
                $social_icon_style = intval($_POST['social_icon_style']);
                update_option('social_icon_style', $social_icon_style);
            }
            if (isset($_POST['social_share'])) {
                $social_share = intval($_POST['social_share']);
                update_option('social_share', $social_share);
            }
            if (isset($_POST['facebook_link'])) {
                $facebook_link = intval($_POST['facebook_link']);
                update_option('facebook_link', $facebook_link);
            }
            if (isset($_POST['twitter_link'])) {
                $twitter_link = intval($_POST['twitter_link']);
                update_option('twitter_link', $twitter_link);
            }
            if (isset($_POST['pinterest_link'])) {
                $pinterest_link = intval($_POST['pinterest_link']);
                update_option('pinterest_link', $pinterest_link);
            }
            if (isset($_POST['linkedin_link'])) {
                $linkedin_link = intval($_POST['linkedin_link']);
                update_option('linkedin_link', $linkedin_link);
            }
            if (isset($_POST['display_comment_count'])) {
                $display_comment_count = intval($_POST['display_comment_count']);
                update_option('display_comment_count', $display_comment_count);
            }
            if (isset($_POST['template_titlefontsize'])) {
                $template_titlefontsize = intval($_POST['template_titlefontsize']);
                update_option('template_titlefontsize', $template_titlefontsize);
            }
            if (isset($_POST['template_titleLineHeight'])) {
                $template_titleLineHeight = intval($_POST['template_titleLineHeight']);
                update_option('template_titleLineHeight', $template_titleLineHeight);
            }
            if (isset($_POST['template_titleLetterSpacing'])) {
                $template_titleLetterSpacing = intval($_POST['template_titleLetterSpacing']);
                update_option('template_titleLetterSpacing', $template_titleLetterSpacing);
            }
            if (isset($_POST['content_fontsize'])) {
                $content_fontsize = intval($_POST['content_fontsize']);
                update_option('content_fontsize', $content_fontsize);
            }
            if (isset($_POST['content_LineHeight'])) {
                $content_LineHeight = intval($_POST['content_LineHeight']);
                update_option('content_LineHeight', $content_LineHeight);
            }
            if (isset($_POST['content_LetterSpacing'])) {
                $content_LetterSpacing = intval($_POST['content_LetterSpacing']);
                update_option('content_LetterSpacing', $content_LetterSpacing);
            }
        
            $templates = array();
            $templates['ID'] = $blog_page_display;
            $templates['post_content'] = '[wp_pbsm]';
            wp_update_post($templates);

            $settings = $_POST;
            if (isset($settings) && !empty($settings)) {
                foreach ($settings as $single_key => $single_val) {
                    if (is_array($single_val)) {
                        foreach ($single_val as $s_key => $s_val) {
                            $settings[$single_key][$s_key] = sanitize_text_field($s_val);
                        }
                    } else {
                        $settings[$single_key] = sanitize_text_field($single_val);
                    }
                }
            }
            $settings = is_array($settings) ? $settings : unserialize($settings);
            $updated = update_option('wp_blog_pbsm_settings', $settings);
        }
    }
}

/**
 * Display total downloads of plugin
 */
function pbsm_get_total_downloads() {
    // Set the arguments. For brevity of code, I will set only a few fields.
    $plugins = $response = '';
    $args = array(
        'author' => 'wpdiscover',
        'fields' => array(
            'downloaded' => true,
            'downloadlink' => true,
        ),
    );
    // Make request and extract plug-in object. Action is query_plugins
    $response = wp_remote_post(
            'http://api.wordpress.org/plugins/info/1.0/', array(
        'body' => array(
            'action' => 'query_plugins',
            'request' => serialize((object) $args),
        ),
            )
    );
    if (!is_wp_error($response)) {
        $returned_object = unserialize(wp_remote_retrieve_body($response));
        $plugins = $returned_object->plugins;
    }

    $current_slug = 'blog-manager-wp';
    if ($plugins) {
        foreach ($plugins as $plugin) {
            if ($current_slug == $plugin->slug) {
                if ($plugin->downloaded) {
                    ?>
                    <span class="total-downloads">
                        <span class="download-number"><?php echo esc_html($plugin->downloaded); ?></span>
                    </span>
                    <?php
                }
            }
        }
    }
}

/**
 * enqueue admin side plugin js
 */
function pbsm_admin_scripts() {
    if (is_user_logged_in()) {
        wp_enqueue_script('jquery');
    }
}

/**
 * include plugin dynamic css
 */
function pbsm_stylesheet() {
    if (!is_admin()) {
        $stylesheet = PBSM_DIR . 'pbsm_layouts_css.php';

        if (file_exists($stylesheet)) {
            include 'pbsm_layouts_css.php';
        }
    }
    if (!is_admin() && is_rtl()) {
        $stylesheet = PBSM_DIR . 'designerrtl_css.php';

        if (file_exists($stylesheet)) {
            include 'designerrtl_css.php';
        }
    }
}

/**
 * Change content length
 */
function pbsm_excerpt_length($length) {
    if (get_option('excerpt_length') != '') {
        return get_option('excerpt_length');
    } else {
        return 50;
    }
}

/**
 * html display default_layout design
 */
function pbsm_default_layout_template($alterclass) {
    ?>
    <div class="blog_template pbsmp_blog_template default_layout">
        <?php
        if (has_post_thumbnail()) {
            ?>
            <div class="pbsm-post-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a></div>
            <?php
        }
        ?>
        <div class="pbsm-blog-header">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php
            $display_date = get_option('display_date');
            $display_author = get_option('display_author');
            $display_comment_count = get_option('display_comment_count');
            if ($display_date == 0 || $display_author == 0 || $display_comment_count == 0) {
                ?>
                <div class="pbsm-metadatabox"><p>
                        <?php
                        if ($display_author == 0 && $display_date == 0) {
                            _e('Posted by ', 'blog-manager-wp');
                            ?>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><span><?php the_author(); ?></span></a>&nbsp;<?php _e('on', 'blog-manager-wp'); ?>&nbsp;
                            <?php
                            $date_format = get_option('date_format');
                           echo get_the_time(esc_html($date_format));
                        } elseif ($display_author == 0) {
                            _e('Posted by ', 'blog-manager-wp');
                            ?>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><span><?php the_author(); ?></span></a>&nbsp;
                            <?php
                        } elseif ($display_date == 0) {
                            _e('Posted on ', 'blog-manager-wp');
                            $date_format = get_option('date_format');
                            echo get_the_time(esc_html($date_format));
                        }
                        ?>
                    </p>
                    <?php
                    if ($display_comment_count == 0) {
                        ?>
                        <div class="pbsm-metacomments">
                            <i class="fas fa-comment"></i><?php comments_popup_link('0', '1', '%'); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }

            if (get_option('display_category') == 0) {
                ?>
                <div><span class="pbsm-category-link">
                        <?php
                        echo '<span class="pbsm-link-label">';
                        echo '<i class="fas fa-folder-open"></i>';
                        _e('Category', 'blog-manager-wp');
                        echo ':&nbsp;';
                        echo '</span>';
                        $categories_list = get_the_category_list(', ');
                        if ($categories_list) :
                            print_r($categories_list);
                            $show_sep = true;
                        endif;
                        ?>
                    </span></div>
                <?php
            }

            if (get_option('display_tag') == 0) {
                $tags_list = get_the_tag_list('', ', ');
                if ($tags_list) :
                    ?>
                    <div class="pbsm-tags">
                        <?php
                        echo '<span class="pbsm-link-label">';
                        echo '<i class="fa fa-list-alt"></i>';
                        _e('Tags', 'blog-manager-wp');
                        echo ':&nbsp;';
                        echo '</span>';
                        print_r($tags_list);
                        $show_sep = true;
                        ?>
                    </div>
                    <?php
                endif;
            }
            ?>
        </div>
        <div class="pbsm-post-content">
            <?php echo pbsm_get_content(get_the_ID()); ?>
            <?php
            if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 1) {
                $read_more_class = ( get_option('read_more_on') == 1 ) ? 'pbsm-more-tag-inline' : 'pbsm-more-tag';
                if (get_option('read_more_text') != '') {
                    echo '<a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a>';
                } else {
                    echo ' <a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . __('Continue Reading...', 'blog-manager-wp') . '</a>';
                }
            }
            ?>
        </div>
        <div class="pbsm-post-footer">
            <?php if (get_option('social_share') != 0 && ( ( get_option('facebook_link') == 0 ) || ( get_option('twitter_link') == 0 ) || ( get_option('linkedin_link') == 0 ) || ( get_option('pinterest_link') == 0 ) )) { ?>
                <div class="social-component">
                    <?php if (get_option('facebook_link') == 0) : ?>
                        <a data-share="facebook" data-href="https://www.facebook.com/sharer/sharer.php" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-facebook-share pbsm-social-share"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('twitter_link') == 0) : ?>
                        <a data-share="twitter" data-href="https://twitter.com/share" data-text="<?php echo get_the_title(); ?>" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-twitter-share pbsm-social-share"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('linkedin_link') == 0) : ?>
                        <a data-share="linkedin" data-href="https://www.linkedin.com/shareArticle" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-linkedin-share pbsm-social-share"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>
                    <?php
                    $pinterestimage = '';
                    if (get_option('pinterest_link') == 0) :
                        $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        ?>
                        <a data-share="pinterest" data-href="https://pinterest.com/pin/create/button/" data-url="<?php echo get_the_permalink(); ?>" data-description="<?php echo get_the_title(); ?>" class="pbsm-pinterest-share pbsm-social-share"> <i class="fab fa-pinterest-p"></i></a>
                    <?php endif; ?>
                </div>
            <?php } ?>
            <?php
            if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 2) {
                if (get_option('read_more_text') != '') {
                    echo '<a class="pbsm-more-tag" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a>';
                } else {
                    echo ' <a class="pbsm-more-tag" href="' . get_the_permalink() . '">' . __('Read More', 'blog-manager-wp') . '</a>';
                }
            }
            ?>
        </div></div>
    <?php
}

/**
 * Column layout template class
 * @since 2.0
 * @global object $pagenow;
 */
if (!function_exists('pbsm_column_class')) {

    function pbsm_column_class($settings) {
        $column_class = '';

        $total_col = (isset($settings['template_columns']) && $settings['template_columns'] != '') ? $settings['template_columns'] : 2;
        if ($total_col == 1) {
            $col_class = 'one_column';
        }
        if ($total_col == 2) {
            $col_class = 'two_column';
        }
        if ($total_col == 3) {
            $col_class = 'three_column';
        }
        if ($total_col == 4) {
            $col_class = 'four_column';
        }

        $total_col_ipad = (isset($settings['template_columns_ipad']) && $settings['template_columns_ipad'] != '') ? $settings['template_columns_ipad'] : 1;
        if ($total_col_ipad == 1) {
            $col_class_ipad = 'one_column_ipad';
        }
        if ($total_col_ipad == 2) {
            $col_class_ipad = 'two_column_ipad';
        }
        if ($total_col_ipad == 3) {
            $col_class_ipad = 'three_column_ipad';
        }
        if ($total_col_ipad == 4) {
            $col_class_ipad = 'four_column_ipad';
        }

        $total_col_tablet = (isset($settings['template_columns_tablet']) && $settings['template_columns_tablet'] != '') ? $settings['template_columns_tablet'] : 1;
        if ($total_col_tablet == 1) {
            $col_class_tablet = 'one_column_tablet';
        }
        if ($total_col_tablet == 2) {
            $col_class_tablet = 'two_column_tablet';
        }
        if ($total_col_tablet == 3) {
            $col_class_tablet = 'three_column_tablet';
        }
        if ($total_col_tablet == 4) {
            $col_class_tablet = 'four_column_tablet';
        }

        $total_col_mobile = (isset($settings['template_columns_mobile']) && $settings['template_columns_mobile'] != '') ? $settings['template_columns_mobile'] : 1;
        if ($total_col_mobile == 1) {
            $col_class_mobile = 'one_column_mobile';
        }
        if ($total_col_mobile == 2) {
            $col_class_mobile = 'two_column_mobile';
        }
        if ($total_col_mobile == 3) {
            $col_class_mobile = 'three_column_mobile';
        }
        if ($total_col_mobile == 4) {
            $col_class_mobile = 'four_column_mobile';
        }

        $column_class = $col_class . ' ' . $col_class_ipad . ' ' . $col_class_tablet . ' ' . $col_class_mobile;
        return $column_class;
    }

}

/**
 * html display default_slider design
 */
function pbsm_default_slider_template() {
    $display_date = get_option('display_date');
    $display_author = get_option('display_author');
    $display_category = get_option('display_category');
    $display_comment_count = get_option('display_comment_count');

    $id = get_post_thumbnail_id();
    $url = wp_get_attachment_image_src($id, 'pbsm_image_slider', true);
    ?>
    <li class="blog_template pbsmp_blog_template default_slider">
        <div class="pbsmp-post-image">
            <?php
            if (has_post_thumbnail()) {
                ?>
                <div class="pbsm-post-image"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($url['0']); ?>"></a></div> 
                <?php
            }
            else{
                ?>
                   <img src="<?php echo esc_url(PBSM_URL . 'assets/images/default-post-img.jpg'); ?>" alt="post image" />
                <?php
            }
            ?>
        </div>
        <div class="blog_manager_wp_header">
            <div class="blog-manager-wp-overlay">
            <?php
            if ($display_category == 0) {
                ?>
                <div class="category-link">
                    <?php
                    $categories_list = get_the_category_list(', ');
                    if ($categories_list) :
                        echo ' ';
                        print_r($categories_list);
                        $show_sep = true;
                    endif;
                    ?>
                </div>
                <?php
            }
            ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php
            if ($display_author == 0 || $display_date == 0 || $display_comment_count == 0) {
                ?>
                <div class="metadatabox">
                    <?php
                    if ($display_author == 0 || $display_date == 0) {
                        if ($display_author == 0) {
                            ?>
                            <div class="mauthor">
                                <span class="author">
                                    <i class="fas fa-user"></i>
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><span><?php the_author(); ?></span></a>
                                </span>
                            </div>
                            <?php
                        }
                        if ($display_date == 0) {
                            $date_format = get_option('date_format');
                            ?>
                            <div class="post-date">
                                <span class="mdate"><i class="far fa-calendar-alt"></i> <?php echo get_the_time(esc_html($date_format)); ?></span>
                            </div>
                            <?php
                        }
                    }
                    if ($display_comment_count == 0) {
                        ?>
                        <div class="post-comment">
                            <?php
                            comments_popup_link('<i class="fas fa-comment"></i>' . __('Leave a Comment', 'blog-manager-wp'), '<i class="fas fa-comment"></i>' . __('1 comment', 'blog-manager-wp'), '<i class="fas fa-comment"></i>% ' . __('comments', 'blog-manager-wp'), 'comments-link', '<i class="fas fa-comment"></i>' . __('Comments are off', 'blog-manager-wp'));
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <div class="post_content">
                <div class="post_content-inner">
                    <?php echo pbsm_get_content(get_the_ID()); ?>
                    <?php
                    if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 1 ||get_option('read_more_on') == 2) {
                        if (get_option('read_more_on') == 2) {
                            echo '<div class="slider_read_more"><a class="slider-more-tag" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a></div>';
                        } else if(get_option('read_more_on') == 1) {
                            echo '<a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . __('Read More', 'blog-manager-wp') . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
            if (get_option('display_tag') == 0) {
                $tags_list = get_the_tag_list('', ', ');
                if ($tags_list) :
                    ?>
                    <div class="tags"><i class="fas fa-bookmark"></i>&nbsp;
                        <?php
                        print_r($tags_list);
                        $show_sep = true;
                        ?>
                    </div>
                    <?php
                endif;
            }
            ?>
            <div class='pbsm_social_share_wrap'>
                <?php if (get_option('social_share') != 0 && ( ( get_option('facebook_link') == 0 ) || ( get_option('twitter_link') == 0 ) || ( get_option('linkedin_link') == 0 ) || ( get_option('pinterest_link') == 0 ) )) { ?>
                    <div class="social-component">
                        <?php if (get_option('facebook_link') == 0) : ?>
                            <a data-share="facebook" data-href="https://www.facebook.com/sharer/sharer.php" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-facebook-share pbsm-social-share"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('twitter_link') == 0) : ?>
                            <a data-share="twitter" data-href="https://twitter.com/share" data-text="<?php echo get_the_title(); ?>" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-twitter-share pbsm-social-share"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('linkedin_link') == 0) : ?>
                            <a data-share="linkedin" data-href="https://www.linkedin.com/shareArticle" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-linkedin-share pbsm-social-share"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php
                        if (get_option('pinterest_link') == 0) :
                            $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            ?>
                            <a data-share="pinterest" data-href="https://pinterest.com/pin/create/button/" data-url="<?php echo get_the_permalink(); ?>" data-mdia="<?php echo esc_attr($pinterestimage[0]); ?>" data-description="<?php echo get_the_title(); ?>" class="pbsm-pinterest-share pbsm-social-share"> <i class="fab fa-pinterest-p"></i></a>
                    <?php endif; ?>
                    </div>
    <?php } ?>
            </div>
            </div>
        </div>
    </li>
    <?php
}

/**
 * html display grid-layout design
 */
function pbsm_boxy_clean_template($settings) {
    $col_class = pbsm_column_class($settings);
    ?>
    <li class="blog_wrap pbsmp_blog_template <?php echo esc_attr($col_class != '') ? esc_attr($col_class) : ''; ?> pbsmp_blog_single_post_wrapp">
        <?php
        $display_date = get_option('display_date');
        $display_author = get_option('display_author');
        $display_category = get_option('display_category');
        $display_comment_count = get_option('display_comment_count');
        ?>
        <div class="post-meta">
            <?php
            if ($display_date == 0) {
                $date_format = get_option('date_format');
                ?>
                <div class="postdate">
                    <span class="month"><?php echo get_the_time('M d'); ?></span>
                    <span class="year"><?php echo get_the_time('Y'); ?></span>
                </div>
                <?php
            }
            if ($display_comment_count == 0) {
                if (comments_open()) {
                    ?>
                    <span class="post-comment">
                        <i class="fas fa-comment"></i>
                        <?php
                        comments_popup_link('0', '1', '%');
                        ?>
                    </span>  
                    <?php
                }
            }
            ?>
        </div>
        <div class="post-media">
            <?php
            if (has_post_thumbnail()) {
                ?>
                <div class="pbsm-post-image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a></div> 
                <?php
            }
            if ($display_author == 0) {
                ?>
                <span class="author">
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><span><?php the_author(); ?></span></a>
                </span>
                <?php
            }
            ?>
        </div>
        <div class="post_summary_outer">
            <div class="blog_manager_wp_header">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
            <div class="post_content">
                <?php echo pbsm_get_content(get_the_ID()); ?>
                <?php
                if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 1 ||get_option('read_more_on') == 2) {
                        if (get_option('read_more_on') == 2) {
                            echo '<div class="grid_read_more"><a class="grid-more-tag" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a></div>';
                        } else if(get_option('read_more_on') == 1) {
                            echo '<a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . __('Continue Reading...', 'blog-manager-wp') . '</a>';
                        }
                    }
                ?>
            </div>
        </div>
        <div class="blog_footer">
            <div class="footer_meta">
                <?php
                if ($display_category == 0) {
                    ?>
                    <div class="pbsm-metacats">
                        <i class="fas fa-bookmark"></i>&nbsp;
                        <?php
                        $categories_list = get_the_category_list(', ');
                        if ($categories_list) :
                            print_r($categories_list);
                            $show_sep = true;
                        endif;
                        ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (get_option('display_tag') == 0) {
                    $tags_list = get_the_tag_list('', ', ');
                    if ($tags_list) :
                        ?>
                        <div class="pbsm-tags"><i class="fa fa-list-alt"></i>&nbsp;
                            <?php
                            print_r($tags_list);
                            $show_sep = true;
                            ?>
                        </div>
                        <?php
                    endif;
                }
                ?>
            </div>
            <div class='pbsm_social_share_wrap'>
                    <?php if (get_option('social_share') != 0 && ( ( get_option('facebook_link') == 0 ) || ( get_option('twitter_link') == 0 ) || ( get_option('linkedin_link') == 0 ) || ( get_option('pinterest_link') == 0 ) )) { ?>
                    <div class="social-component">
                        <?php if (get_option('facebook_link') == 0) : ?>
                            <a data-share="facebook" data-href="https://www.facebook.com/sharer/sharer.php" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-facebook-share pbsm-social-share"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('twitter_link') == 0) : ?>
                            <a data-share="twitter" data-href="https://twitter.com/share" data-text="<?php echo get_the_title(); ?>" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-twitter-share pbsm-social-share"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('linkedin_link') == 0) : ?>
                            <a data-share="linkedin" data-href="https://www.linkedin.com/shareArticle" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-linkedin-share pbsm-social-share"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php
                        if (get_option('pinterest_link') == 0) :
                            $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            ?>
                            <a data-share="pinterest" data-href="https://pinterest.com/pin/create/button/" data-url="<?php echo get_the_permalink(); ?>" data-mdia="<?php echo esc_attr($pinterestimage[0]); ?>" data-description="<?php echo get_the_title(); ?>" class="pbsm-pinterest-share pbsm-social-share"> <i class="fab fa-pinterest-p"></i></a>
                    <?php endif; ?>
                    </div>
    <?php } ?>
            </div>
        </div>
    </li>

    <?php
}

/**
 * Html display center_top design
 */
function pbsm_center_top_template($alterclass) {
    ?>
    <div class="blog_template pbsmp_blog_template center_top <?php echo esc_attr($alterclass); ?>">
            <?php if (get_option('display_category') == 0) { ?>
            <div class="pbsm-categories">
                <?php
                $categories_list = get_the_category_list(', ');
                if ($categories_list) :
                    print_r($categories_list);
                    $show_sep = true;
                endif;
                ?>
            </div>
        <?php } ?>

        <div class="pbsm-blog-header"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>

        <?php
        $display_date = get_option('display_date');
        $display_author = get_option('display_author');
        $display_comment_count = get_option('display_comment_count');
        if ($display_date == 0 || $display_author == 0 || $display_comment_count == 0) {
            ?>
            <div class="post-entry-meta">
                <?php
                if ($display_date == 0) {
                    $date_format = get_option('date_format');
                    ?>
                    <span class="date"><i class="far fa-clock"></i><?php echo get_the_time(esc_html($date_format)); ?></span>
                    <?php
                }
                if ($display_author == 0) {
                    ?>
                    <span class="author"><i class="fas fa-user"></i><?php _e('Posted by ', 'blog-manager-wp'); ?><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></span>
                    <?php
                }
                if ($display_comment_count == 0) {
                    if (!post_password_required() && ( comments_open() || get_comments_number() )) :
                        ?>
                        <span class="comment"><i class="fas fa-comment"></i><?php comments_popup_link('0', '1', '%'); ?></span>
                        <?php
                    endif;
                }
                ?>
            </div>
    <?php } ?>

    <?php if (has_post_thumbnail()) { ?>
            <div class="pbsm-post-image">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?>
                    <span class="overlay"></span>
                </a>
            </div>
            <?php } ?>

        <div class="pbsm-post-content">
            <?php
            echo pbsm_get_content(get_the_ID());

            if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 1) {
                if (get_option('read_more_text') != '') {
                    echo '<a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a>';
                } else {
                    echo ' <a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . __('Continue Reading...', 'blog-manager-wp') . '</a>';
                }
            }
            ?>
        </div>

        <?php
        $display_tag = get_option('display_tag');
        if ($display_tag == 0) {
            $tags_list = get_the_tag_list('', ', ');
            if ($tags_list) :
                ?>
                <div class="pbsm-tags">
                    <?php
                    echo '<span class="pbsm-link-label">';
                    echo '<i class="fa fa-list-alt"></i>';
                    _e('Tags', 'blog-manager-wp');
                    echo ':&nbsp;';
                    echo '</span>';
                    print_r($tags_list);
                    $show_sep = true;
                    ?>
                </div>
                <?php
            endif;
        }
        ?>

        <div class="pbsm-post-footer">
                <?php if (get_option('social_share') != 0 && ( ( get_option('facebook_link') == 0 ) || ( get_option('twitter_link') == 0 ) || ( get_option('linkedin_link') == 0 ) || ( get_option('pinterest_link') == 0 ) )) { ?>
                <div class="social-component">
                    <?php
                    if (get_option('facebook_link') == 0) :
                        ?>
                        <a data-share="facebook" data-href="https://www.facebook.com/sharer/sharer.php" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-facebook-share pbsm-social-share"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('twitter_link') == 0) : ?>
                        <a data-share="twitter" data-href="https://twitter.com/share" data-text="<?php echo get_the_title(); ?>" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-twitter-share pbsm-social-share"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('linkedin_link') == 0) : ?>
                        <a data-share="linkedin" data-href="https://www.linkedin.com/shareArticle" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-linkedin-share pbsm-social-share"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>																			<?php
            if (get_option('pinterest_link') == 0) :
                $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                ?>
                        <a data-share="pinterest" data-href="https://pinterest.com/pin/create/button/" data-url="<?php echo get_the_permalink(); ?>" data-mdia="<?php echo esc_attr($pinterestimage[0]); ?>" data-description="<?php echo get_the_title(); ?>" class="pbsm-pinterest-share pbsm-social-share"> <i class="fab fa-pinterest-p"></i></a>
                <?php endif; ?>
                </div>
            <?php } ?>
            <?php
            if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 2) {
                if (get_option('read_more_text') != '') {
                    echo '<a class="pbsm-more-tag" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a>';
                } else {
                    echo ' <a class="pbsm-more-tag" href="' . get_the_permalink() . '">' . __('Read More', 'blog-manager-wp') . '</a>';
                }
            }
            ?>
        </div></div>
    <?php
}

/**
 * Html display timeline design
 */
function pbsm_timeline_template($alterclass) {
    ?>
    <div class="blog_template pbsmp_blog_template timeline blog-wrap <?php echo esc_attr($alterclass); ?>">
        <div class="post_hentry"><p><i class="fas" data-fa-pseudo-element=":before"></i></p><div class="post_content_wrap">
                <div class="post_wrapper box-blog">
    <?php if (has_post_thumbnail()) { ?>
                        <div class="pbsm-post-image photo">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?>
                                <span class="overlay"></span>
                            </a>
                        </div>
                        <?php } ?>
                    <div class="desc">
                        <h3 class="entry-title text-center text-capitalize"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php
                        $display_author = get_option('display_author');
                        $display_comment_count = get_option('display_comment_count');
                        $display_date = get_option('display_date');
                        if ($display_date == 0 || $display_comment_count == 0 || $display_date == 0) {
                            ?>
                            <div class="date_wrap">
                                    <?php if ($display_author == 0) { ?>
                                    <p class='pbsm-margin-0'><span title="Posted By <?php the_author(); ?>"><i class="fas fa-user"></i>&nbsp;<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><span><?php the_author(); ?></span></a></span>&nbsp;&nbsp;
            <?php
        } if ($display_comment_count == 0) {
            ?>
                                        <span class="pbsm-metacomments"><i class="fas fa-comment"></i>&nbsp;<?php comments_popup_link(__('No Comments', 'blog-manager-wp'), __('1 Comment', 'blog-manager-wp'), '% ' . __('Comments', 'blog-manager-wp')); ?>
                                        </span></p>
            <?php
        } if ($display_date == 0) {
            ?>
                                    <div class="pbsm-datetime">
                                        <span class="month"><?php the_time('M'); ?></span><span class="date"><?php the_time('d'); ?></span>
                                    </div><?php } ?></div>
                            <?php } ?>
                        <div class="pbsm-post-content">
                            <?php
                            echo pbsm_get_content(get_the_ID());

                            if (get_option('rss_use_excerpt') == 1 && get_option('excerpt_length') > 0) {
                                if (get_option('read_more_on') == 1) {
                                    if (get_option('read_more_text') != '') {
                                        echo '<a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a>';
                                    } else {
                                        echo ' <a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . __('Read More', 'blog-manager-wp') . '</a>';
                                    }
                                }
                            }
                            ?>
                        </div>
                            <?php if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') != 0) : ?>
                            <div class="read_more">
                                <?php
                                global $post;
                                if (get_option('read_more_on') == 2) {
                                    if (get_option('read_more_text') != '') {
                                        echo '<a class="pbsm-more-tag" href="' . get_permalink($post->ID) . '"><i class="fas fa-plus"></i> ' . get_option('read_more_text') . ' </a>';
                                    } else {
                                        echo ' <a class="pbsm-more-tag" href="' . get_permalink($post->ID) . '"><i class="fas fa-plus"></i> ' . __('Read more', 'blog-manager-wp') . ' &raquo;</a>';
                                    }
                                }
                                ?>
                            </div><?php endif; ?></div></div>
                    <?php if (get_option('display_category') == 0 || ( get_option('social_share') != 0 && ( get_option('display_tag') == 0 || ( get_option('facebook_link') == 0 ) || ( get_option('twitter_link') == 0 ) || ( get_option('linkedin_link') == 0 ) || ( get_option('pinterest_link') == 0 ) ) )) { ?>
                    <footer class="blog_footer text-capitalize">
                                <?php
                                if (get_option('display_category') == 0) {
                                    ?>
                            <p class="pbsm-margin-0"><span class="pbsm-categories"><i class="fas fa-folder"></i>
                                    <?php
                                    $categories_list = get_the_category_list(', ');
                                    if ($categories_list) :
                                        echo '<span class="pbsm-link-label">';
                                        _e('Categories', 'blog-manager-wp');
                                        echo ' :&nbsp;';
                                        echo '</span>';
                                        print_r($categories_list);
                                        $show_sep = true;
                                    endif;
                                    ?>
                                </span></p>
                            <?php
                        }
                        if (get_option('display_tag') == 0) {
                            $tags_list = get_the_tag_list('', ', ');
                            if ($tags_list) :
                                ?>
                                <p class="pbsm-margin-0"><span class="pbsm-tags"><i class="fas fa-bookmark"></i>
                                        <?php
                                        echo '<span class="pbsm-link-label">';
                                        _e('Tags', 'blog-manager-wp');
                                        echo ' :&nbsp;';
                                        echo '</span>';
                                        print_r($tags_list);
                                        $show_sep = true;
                                        ?>
                                    </span></p>
                                <?php
                            endif;
                        }

                        if (get_option('social_share') != 0 && ( ( get_option('facebook_link') == 0 ) || ( get_option('twitter_link') == 0 ) || ( get_option('linkedin_link') == 0 ) || ( get_option('pinterest_link') == 0 ) )) {
                            ?>
                            <div class="social-component">
                                <?php if (get_option('facebook_link') == 0) : ?>
                                    <a data-share="facebook" data-href="https://www.facebook.com/sharer/sharer.php" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-facebook-share pbsm-social-share"><i class="fab fa-facebook-f"></i></a>
                                    <?php
                                endif;
                                if (get_option('twitter_link') == 0) :
                                    ?>
                                    <a data-share="twitter" data-href="https://twitter.com/share" data-text="<?php echo get_the_title(); ?>" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-twitter-share pbsm-social-share"><i class="fab fa-twitter"></i></a>
                                    <?php
                                endif;
                                if (get_option('linkedin_link') == 0) :
                                    ?>
                                    <a data-share="linkedin" data-href="https://www.linkedin.com/shareArticle" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-linkedin-share pbsm-social-share"><i class="fab fa-linkedin-in"></i></a>
                                    <?php
                                endif;
                                if (get_option('pinterest_link') == 0) :
                                    $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                    ?>
                                    <a data-share="pinterest" data-href="https://pinterest.com/pin/create/button/" data-url="<?php echo get_the_permalink(); ?>" data-mdia="<?php echo esc_attr($pinterestimage[0]); ?>" data-description="<?php echo get_the_title(); ?>" class="pbsm-pinterest-share pbsm-social-share"> <i class="fab fa-pinterest-p"></i></a>
                            <?php endif; ?>
                            </div>
                        <?php
                    }
                    ?>
                    </footer>
    <?php } ?>
            </div></div></div>
    <?php
}

/**
 * Html display news_feed design
 */
function pbsm_news_feed_template($alter) {
    ?>
    <div class="blog_template pbsmp_blog_template news_feed <?php echo esc_attr($alter); ?>">
        <?php
        $full_width_class = ' full_with_class';
        if (has_post_thumbnail()) {
            $full_width_class = '';
            ?>
            <div class="pbsm-post-image">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
            </div>
        <?php
    }
    ?>
        <div class="post-content-div<?php echo esc_attr($full_width_class); ?>">
            <div class="pbsm-blog-header">
                <?php
                $display_date = get_option('display_date');
                if ($display_date == 0) {
                    $date_format = get_option('date_format');
                    ?>
                    <p class="pbsm_date_cover"><span class="date"><?php echo get_the_time(esc_html($date_format)); ?></span></p><?php } ?><h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php
                $display_author = get_option('display_author');
                $display_comment_count = get_option('display_comment_count');
                if ($display_author == 0 || $display_comment_count == 0) {
                    ?>
                    <div class="pbsm-metadatabox">
        <?php
        if ($display_author == 0) {
            ?>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?>
                            </a>
                            <?php
                        }
                        if ($display_comment_count == 0) {
                            comments_popup_link(__('Leave a Comment', 'blog-manager-wp'), __('1 Comment', 'blog-manager-wp'), '% ' . __('Comments', 'blog-manager-wp'), 'comments-link', __('Comments are off', 'blog-manager-wp'));
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
            <div class="pbsm-post-content">
                <?php
                echo pbsm_get_content(get_the_ID());
                if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 1) {
                    if (get_option('read_more_text') != '') {
                        echo '<a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a>';
                    } else {
                        echo '<a class="pbsm-more-tag-inline" href="' . get_the_permalink() . '">' . __('Read More', 'blog-manager-wp') . '</a>';
                    }
                }
                ?>
            </div>

            <?php
            $display_category = get_option('display_category');
            $display_tag = get_option('display_tag');
            if ($display_category == 0 || $display_tag == 0) {
                ?>
                <div class="post_cat_tag">
                        <?php if ($display_category == 0) { ?>
                        <span class="pbsm-category-link">
                            <?php
                            $categories_list = get_the_category_list(', ');
                            if ($categories_list) :
                                echo '<i class="fas fa-bookmark"></i>';
                                print_r($categories_list);
                                $show_sep = true;
                            endif;
                            ?>
                        </span>
                        <?php
                    }
                    if ($display_tag == 0) {
                        $tags_list = get_the_tag_list('', ', ');
                        if ($tags_list) :
                            ?>
                            <span class="pbsm-tags"><i class="fa fa-list-alt"></i>&nbsp;
                                <?php
                                print_r($tags_list);
                                $show_sep = true;
                                ?>
                            </span>
                            <?php
                        endif;
                    }
                    ?>
                </div>
                <?php } ?>

            <div class="pbsm-post-footer">
                    <?php if (get_option('social_share') != 0 && ( ( get_option('facebook_link') == 0 ) || ( get_option('twitter_link') == 0 ) || ( get_option('linkedin_link') == 0 ) || ( get_option('pinterest_link') == 0 ) )) { ?>
                    <div class="social-component">
                        <?php if (get_option('facebook_link') == 0) : ?>
                            <a data-share="facebook" data-href="https://www.facebook.com/sharer/sharer.php" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-facebook-share pbsm-social-share"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('twitter_link') == 0) : ?>
                            <a data-share="twitter" data-href="https://twitter.com/share" data-text="<?php echo get_the_title(); ?>" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-twitter-share pbsm-social-share"><i class="fab fa-twitter"></i></a><?php endif; ?>
                        <?php if (get_option('linkedin_link') == 0) : ?>
                            <a data-share="linkedin" data-href="https://www.linkedin.com/shareArticle" data-url="<?php echo get_the_permalink(); ?>" class="pbsm-linkedin-share pbsm-social-share"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>																		<?php if (get_option('pinterest_link') == 0) : $pinterestimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                            <a data-share="pinterest" data-href="https://pinterest.com/pin/create/button/" data-url="<?php echo get_the_permalink(); ?>" data-mdia="<?php echo esc_attr($pinterestimage[0]); ?>" data-description="<?php echo get_the_title(); ?>" class="pbsm-pinterest-share pbsm-social-share"> <i class="fab fa-pinterest-p"></i></a>
                    <?php endif; ?>
                    </div>
                <?php } ?>

                <?php
                if (get_option('rss_use_excerpt') == 1 && get_option('read_more_on') == 2) {
                    if (get_option('read_more_text') != '') {
                        echo '<a class="pbsm-more-tag" href="' . get_the_permalink() . '">' . get_option('read_more_text') . ' </a>';
                    } else {
                        echo ' <a class="pbsm-more-tag" href="' . get_the_permalink() . '">' . __('Read More', 'blog-manager-wp') . '</a>';
                    }
                }
                ?>
            </div></div></div>
    <?php
}

/**
 * Html Display setting options
 */
function pbsm_main_menu_function() {
    global $wp_version;
    ?>
    <div class="wrap">
        <?php
        $view_post_link = ( get_option('blog_page_display') != 0 ) ? '<span class="page_link"> <a target="_blank" href="' . get_permalink(get_option('blog_page_display')) . '"> ' . __('View Blog', 'blog-manager-wp') . ' </a></span>' : '';

        if (isset($_REQUEST['bdRestoreDefault']) && isset($_GET['updated']) && 'true' == sanitize_text_field($_GET['updated'])) {
            echo '<div class="updated" ><p>' . __('Blog Manager setting restored successfully.', 'blog-manager-wp') . ' ' . wp_kses($view_post_link,'blog-manager-wp') . '</p></div>';
        
        } elseif (isset($_GET['updated']) && 'true' == sanitize_text_field($_GET['updated'])) {
            echo '<div class="updated" ><p>' . __('Blog Manager settings updated.', 'blog-manager-wp') . ' ' . wp_kses($view_post_link,'blog-manager-wp') . '</p></div>';
        }
        $settings = get_option('wp_blog_pbsm_settings');
        if (isset($_SESSION['success_msg'])) {
            ?>
            <div class="updated is-dismissible notice settings-error">
                <?php
                echo '<p>' . esc_html($_SESSION['success_msg']) . '</p>';
                unset($_SESSION['success_msg']);
                ?>
            </div>
                <?php
            }
            ?>
        <form method="post" action="?page=pbsm_settings&action=save&updated=true" class="pbsm-form-class">
            <?php $page = ''; 
            if (isset($_GET['page']) && $_GET['page'] != '') { 
                $page = sanitize_text_field($_GET['page']); ?>
                <input type="hidden" name="originalpage" class="bdporiginalpage" value="<?php echo esc_attr($page); ?>">
            <?php } ?>
            <div class="wl-pages" >
                <div class="pbsm-settings-wrappers pbsm_poststuff">
                    <div class="pbsm-header-wrapper">
                        <div class="pbsm-logo-wrapper pull-left">
                            <h3><?php _e('Blog Manager settings', 'blog-manager-wp'); ?></h3>
                        </div>
                        <div class="pull-right">
                            <a id="pbsm-submit-button" title="<?php _e('Save Changes', 'blog-manager-wp'); ?>" class="button">
                                <span><i class="fas fa-check"></i>&nbsp;&nbsp;<?php _e('Save Changes', 'blog-manager-wp'); ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="pbsm-menu-setting">
                        <?php
                        $pbsmpgeneral_class = $dbptimeline_class = $pbsmpstandard_class = $pbsmptitle_class = $pbsmpcontent_class = $pbsmpmedia_class = $pbsmpslider_class = $pbsmpcustomreadmore_class = $pbsmpsocial_class = $pbsmpslider_class = '';
                        $pbsmpgeneral_class_show = $dbptimeline_class_show = $pbsmpstandard_class_show = $pbsmptitle_class_show = $pbsmpcontent_class_show = $pbsmpmedia_class_show = $pbsmpslider_class_show = $pbsmpcustomreadmore_class_show = $pbsmpsocial_class_show = '';

                        if (pbsm_postbox_classes('bdpgeneral', $page)) {
                            $pbsmpgeneral_class = 'pbsm-active-tab';
                            $pbsmpgeneral_class_show = 'display: block;';
                        } elseif (pbsm_postbox_classes('dbptimeline', $page)) {
                            $dbptimeline_class = 'class="pbsm-active-tab"';
                            $dbptimeline_class_show = 'style="display: block;"';
                        } elseif (pbsm_postbox_classes('bdpstandard', $page)) {
                            $pbsmpstandard_class = 'pbsm-active-tab';
                            $pbsmpstandard_class_show = 'display: block;';
                        } elseif (pbsm_postbox_classes('bdptitle', $page)) {
                            $pbsmptitle_class = 'pbsm-active-tab';
                            $pbsmptitle_class_show = 'display: block;';
                        } elseif (pbsm_postbox_classes('bdpcontent', $page)) {
                            $pbsmpcontent_class = 'pbsm-active-tab';
                            $pbsmpcontent_class_show = 'display: block;';
                        } elseif (pbsm_postbox_classes('bdpslider', $page)) {
                            $pbsmpslider_class = 'pbsm-active-tab';
                            $pbsmpslider_class_show = 'display: block;';
                        } elseif (pbsm_postbox_classes('bdpcustomreadmore', $page)) {
                            $pbsmpcustomreadmore_class = 'class="pbsm-active-tab"';
                            $pbsmpcustomreadmore_class_show = 'style="display: block;"';
                        } elseif (pbsm_postbox_classes('bdpsocial', $page)) {
                            $pbsmpsocial_class = 'pbsm-active-tab';
                            $pbsmpsocial_class_show = 'display: block;';
                        } else {
                            $pbsmpgeneral_class = 'pbsm-active-tab';
                            $pbsmpgeneral_class_show = 'display: block;';
                        }
                        ?>
                        <ul class="pbsm-setting-handle">
                            <li data-show="bdpgeneral" class="<?php echo esc_attr($pbsmpgeneral_class); ?>">
                                <i class="fas fa-cog"></i>
                                <span><?php _e('General Settings', 'blog-manager-wp'); ?></span>
                            </li>
                            <li data-show="bdpstandard" class="<?php echo esc_attr($pbsmpstandard_class); ?>">
                                <i class="fas fa-gavel"></i>
                                <span><?php _e('Standard Settings', 'blog-manager-wp'); ?></span>
                            </li>
                            <li data-show="bdptitle" class="<?php echo esc_attr($pbsmptitle_class); ?>">
                                <i class="fas fa-text-width"></i>
                                <span><?php _e('Post Title Settings', 'blog-manager-wp'); ?></span>
                            </li>
                            <li data-show="bdpcontent" class="<?php echo esc_attr($pbsmpcontent_class); ?>">
                                <i class="far fa-file-alt"></i>
                                <span><?php _e('Post Content Settings', 'blog-manager-wp'); ?></span>
                            </li>
                            <li data-show="bdpslider" class="<?php echo esc_attr($pbsmpslider_class); ?>">
                                <i class="fas fa-sliders-h"></i>
                                <span><?php _e('Slider Settings', 'blog-manager-wp'); ?></span>
                            </li>
                            <li data-show="bdpsocial" class="<?php echo esc_attr($pbsmpsocial_class); ?>">
                                <i class="fas fa-share-alt"></i>
                                <span><?php _e('Social Share Settings', 'blog-manager-wp'); ?></span>
                            </li>
                        </ul>
                    </div>
                    <div id="bdpgeneral" class="postbox postbox-with-fw-options" style="<?php echo esc_attr($pbsmpgeneral_class_show);?>">
                        <ul class="pbsm-settings">
                            <li>
                                <h3 class="pbsm-table-title"><?php _e('Select Blog Layout', 'blog-manager-wp'); ?></h3>
                                <div class="pbsm-left">
                                    <p class="pbsm-margin-bottom-50"><?php _e('Select your favorite layout from 6 free layouts.', 'blog-manager-wp'); ?></p>
                                    <p class="pbsm-margin-bottom-30"><b><?php _e('Current Template:', 'blog-manager-wp'); ?></b> &nbsp;&nbsp;
                                        <span class="pbsm-template-name">
                                            <?php
                                            if (isset($settings['template_name'])) {
                                                echo str_replace('_', '-', esc_attr($settings['template_name'])) . ' ';
                                                _e('Template', 'blog-manager-wp');
                                            }
                                            ?>
                                        </span></p>
                                    <div class="pbsm_select_template_button_div">
                                        <input type="button" class="pbsm_select_template" value="<?php esc_attr_e('Select Other Template', 'blog-manager-wp'); ?>">
                                    </div>
                                    <input type="hidden" name="template_name" id="template_name" value="<?php
                                if (isset($settings['template_name']) && $settings['template_name'] != '') {
                                    echo  esc_attr($settings['template_name']);
                                }
                                ?>" />
                                    <div class="pbsm_select_template_button_div">
                                        <a id="pbsm-reset-button" title="<?php _e('Reset Layout Settings', 'blog-manager-wp'); ?>" class="pbsmp-restore-default button change-theme">
                                            <span><?php _e('Reset Layout Settings', 'blog-manager-wp'); ?></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="pbsm-right">
                                    <div class="select-cover select-cover-template">
                                        <div class="pbsm_selected_template_image">
                                            <div 
                                            <?php
                                            if (isset($settings['template_name']) && empty($settings['template_name'])) {
                                                echo esc_attr('class="pbsm_no_template_found"');
                                            }
                                            ?>
                                                >
                                                <?php
                                                if (isset($settings['template_name']) && !empty($settings['template_name'])) {
                                                    $image_name = $settings['template_name'] . '.jpg';
                                                    ?>
                                                    <img src="<?php echo esc_url(PBSM_URL . 'assets/images/layouts/' . esc_attr($image_name)); ?>" alt="
                                                    <?php
                                                    if (isset($settings['template_name'])) {
                                                        echo str_replace('_', '-', esc_attr($settings['template_name'])) . ' ';
                                                        esc_attr_e('Template', 'blog-manager-wp');
                                                    }
                                                    ?>
                                                         " title="
                                                         <?php
                                                         if (isset($settings['template_name'])) {
                                                             echo str_replace('_', '-', esc_attr($settings['template_name'])) . ' ';
                                                             esc_attr_e('Template', 'blog-manager-wp');
                                                         }
                                                         ?>
                                                         " />
                                                    <label id="pbsm_template_select_name">
                                                        <?php
                                                        if (isset($settings['template_name'])) {
                                                            echo str_replace('_', '-', esc_attr($settings['template_name'])) . ' ';
                                                            _e('Template', 'blog-manager-wp');
                                                        }
                                                        ?>
                                                    </label>
                                                    <?php
                                                } else {
                                                    _e('No template exist for selection', 'blog-manager-wp');
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="pbsm_selected_template_image premium">
                                            <div>
                                                <img src="<?php echo esc_url(PBSM_URL . 'assets/images/premium.jpg'); ?>">
                                                <a href="https://blogwpthemes.com/downloads/blog-manager-pro-wordpress-plugin/" id="pbsm_premium_name" target="_blank">
                                                    Check 35+ Premium Template
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pbsm-caution">
                                <div class="pbsmp-setting-caution">
                                    <b><?php _e('Caution:', 'blog-manager-wp'); ?></b>
                                    <?php _e('You are about to select the page for your layout. This will overwrite all the content on the page that you will select. Changes once lost can not be recovered. Please be cautious!', 'blog-manager-wp');    ?>
                                </div>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                        <?php _e(' Select Page for Blog ', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select page for display blog layout', 'blog-manager-wp'); ?></span></span>
                                    <div class="select-cover">
                                        <?php
                                        echo wp_dropdown_pages(
                                                array(
                                                    'name' => 'blog_page_display',
                                                    'echo' => 0,
                                                    'depth' => -1,
                                                    'show_option_none' => '-- ' . __('Select Page', 'blog-manager-wp') . ' --',
                                                    'option_none_value' => '0',
                                                    'selected' => get_option('blog_page_display'),
                                                )
                                        );
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Number of Posts to Display', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e(' Select number of posts to display on blog page', 'blog-manager-wp'); ?></span></span>
                                    <div class="quantity">
                                        <input name="posts_per_page" type="number" step="1" min="1" id="posts_per_page" value="<?php echo get_option('posts_per_page'); ?>" class="small-text" onkeypress="return isNumberKey(event)" />
                                        <div class="quantity-nav">
                                            <div class="quantity-button quantity-up">+</div>
                                            <div class="quantity-button quantity-down">-</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                    <?php _e('Select Post Categories', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e(' Select post categories to filter posts via categories', 'blog-manager-wp'); ?></span></span>
                                    <?php
                                    $categories = get_categories(
                                            array(
                                                'child_of' => '',
                                                'hide_empty' => 1,
                                            )
                                    );
                                    ?>
                                    <select data-placeholder="<?php esc_attr_e('Choose Post Categories', 'blog-manager-wp'); ?>" class="chosen-select" multiple style="width:220px;" name="template_category[]" id="template_category">
                                        <?php foreach ($categories as $categoryObj) : ?>
                                            <option value="<?php echo esc_attr($categoryObj->term_id); ?>" 
                                            <?php
                                            if (@in_array($categoryObj->term_id, $settings['template_category'])) {
                                                echo esc_html('selected="selected"');
                                            }
                                            ?>
                                                    ><?php echo esc_html($categoryObj->name); ?>
                                            </option><?php endforeach; ?>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                    <?php _e('Select Post Tags', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e(' Select post tag to filter posts via tags', 'blog-manager-wp'); ?></span></span>
                                        <?php
                                        $tags = get_tags();
                                        $template_tags = isset($settings['template_tags']) ? $settings['template_tags'] : array();
                                        ?>
                                    <select data-placeholder="<?php esc_attr_e('Choose Post Tags', 'blog-manager-wp'); ?>" class="chosen-select" multiple style="width:220px;" name="template_tags[]" id="template_tags">
                                        <?php foreach ($tags as $tag) : ?>
                                            <option value="<?php echo esc_html($tag->term_id); ?>"
                                            <?php
                                            if (@in_array($tag->term_id, $template_tags)) {
                                                echo 'selected="selected"';
                                            }
                                            ?>
                                                    ><?php echo esc_html($tag->name); ?></option>
    <?php endforeach; ?>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                    <?php _e('Select Post Authors', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e(' Select post authors to filter posts via authors', 'blog-manager-wp'); ?></span></span>
                                        <?php
                                        $blogusers = get_users('orderby=nicename&order=asc');
                                        $template_authors = isset($settings['template_authors']) ? $settings['template_authors'] : array();
                                        ?>
                                    <select data-placeholder="<?php esc_attr_e('Choose Post Authors', 'blog-manager-wp'); ?>" class="chosen-select" multiple style="width:220px;" name="template_authors[]" id="template_authors">
                                        <?php foreach ($blogusers as $user) : ?>
                                            <option value="<?php echo esc_attr($user->ID); ?>" 
                                            <?php
                                            if (@in_array($user->ID, $template_authors)) {
                                                echo 'selected="selected"';
                                            }
                                            ?>
                                                    ><?php echo esc_html($user->display_name); ?></option>
    <?php endforeach; ?>
                                    </select>
                                </div>
                            </li>
                            <li class="pbsm-display-settings">
                                <h3 class="pbsm-table-title"><?php _e('Display Settings', 'blog-manager-wp'); ?></h3>
                                <div class="pbsm-typography-wrapper pbsm-button-settings">
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Post Category', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show post category on blog layout', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
												<div class="switch">
                                                <input class="switch-input" id="display_category_0" name="display_category" type="radio" value="0" <?php echo checked(0, get_option('display_category')); ?>/>
                                                <label class="switch-label switch-label-off" for="display_category_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="display_category_1" name="display_category" type="radio" value="1" <?php echo checked(1, get_option('display_category')); ?> />
                                                <label class="switch-label switch-label-on" for="display_category_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                             </div>
                                        </div>
                                    </div>

                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Post Tag', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show post tag on blog layout', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                           
                                        <div class="switch">
										<input class="switch-input" id="display_tag_0" name="display_tag" type="radio" value="0" <?php echo checked(0, get_option('display_tag')); ?> >
										<label class="switch-label switch-label-off" for="display_tag_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
										<input class="switch-input" id="display_tag_1" name="display_tag" type="radio" value="1" <?php echo checked(1, get_option('display_tag')); ?> >
										<label class="switch-label switch-label-on" for="display_tag_1"><?php _e('No', 'blog-manager-wp'); ?></label>
										<span class="switch-selection"></span>
										</div>
                                           
                                        </div>
                                    </div>

                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Post Author ', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show post author on blog layout', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                             <div class="switch">
                                                <input class="switch-input" id="display_author_0" name="display_author" type="radio" value="0" <?php echo checked(0, get_option('display_author')); ?>/>
                                                <label class="switch-label switch-label-off" for="display_author_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="display_author_1" name="display_author" type="radio" value="1" <?php echo checked(1, get_option('display_author')); ?> />
                                                <label class="switch-label switch-label-on" for="display_author_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                             </div>
                                        </div>
                                    </div>

                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Post Published Date', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show post published date on blog layout', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="switch">
                                                <input class="switch-input" id="display_date_0" name="display_date" type="radio" value="0" <?php echo checked(0, get_option('display_date')); ?>/>
                                                <label class="switch-label switch-label-off" for="display_date_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="display_date_1" name="display_date" type="radio" value="1" <?php echo checked(1, get_option('display_date')); ?> />
                                                <label class="switch-label switch-label-on" for="display_date_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Comment Count', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show post comment count on blog layout', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="switch">
                                                <input class="switch-input" id="display_comment_count_0" name="display_comment_count" type="radio" value="0" <?php echo checked(0, get_option('display_comment_count')); ?>/>
                                                <label class="switch-label switch-label-off" for="display_comment_count_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="display_comment_count_1" name="display_comment_count" type="radio" value="1" <?php echo checked(1, get_option('display_comment_count')); ?> />
                                                <label class="switch-label switch-label-on" for="display_comment_count_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                             </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                            <?php _e('Display Sticky Post First', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show Sticky Post first on blog layout', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
    <?php
    $display_sticky = get_option('display_sticky');
    ?>
                                            <div class="switch">
                                                <input class="switch-input" id="display_sticky_0" name="display_sticky" type="radio" value="0" <?php echo checked(0, esc_attr($display_sticky)); ?>/>
                                                <label class="switch-label switch-label-off" for="display_sticky_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="display_sticky_1" name="display_sticky" type="radio" value="1" <?php echo checked(1, esc_attr($display_sticky)); ?> />
                                                <label class="switch-label switch-label-on" for="display_sticky_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </li>                        
                        </ul>
                    </div>

                    <div id="bdpstandard" class="postbox postbox-with-fw-options" style="<?php echo esc_attr($pbsmpstandard_class_show);?>">
                        <ul class="pbsm-settings">
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Main Container Class Name', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter main container class name.', 'blog-manager-wp'); ?> <br/> <?php _e('Leave it blank if you do not want to use it', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="main_container_class" id="main_container_class" placeholder="<?php esc_attr_e('main cover class name', 'blog-manager-wp'); ?>" value="<?php echo esc_attr(isset($settings['main_container_class'])) ? esc_attr($settings['main_container_class']) : ''; ?>"/>
                                </div>
                            </li>

                            <li class="blog-columns-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php echo _e('Blog Grid Columns', 'blog-manager-wp'); ?>
                                    <?php echo '<br />(<i>' . __('Desktop - Above', 'blog-manager-wp') . ' 980px</i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-cosettingslor"><span class="pbsm-tooltips"><?php _e('Select column for post', 'blog-manager-wp'); ?></span></span>
    <?php $settings["template_columns"] = isset($settings["template_columns"]) ? $settings["template_columns"] : 3; ?>
                                    <select name="template_columns" id="template_columns" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_columns"] == '1') { ?> selected="selected"<?php } ?>>
    <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_columns"] == '2') { ?> selected="selected"<?php } ?>>
    <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_columns"] == '3') { ?> selected="selected"<?php } ?>>
    <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_columns"] == '4') { ?> selected="selected"<?php } ?>>
    <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>
                            <li class="blog-columns-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php echo _e('Blog Grid Columns', 'blog-manager-wp'); ?>
                                    <?php echo '<br />(<i>' . __('iPad', 'blog-manager-wp') . ' - 720px - 980px</i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select column for post', 'blog-manager-wp'); ?></span></span>
    <?php $settings["template_columns_ipad"] = isset($settings["template_columns_ipad"]) ? $settings["template_columns_ipad"] : 2; ?>
                                    <select name="template_columns_ipad" id="template_columns_ipad" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_columns_ipad"] == '1') { ?> selected="selected"<?php } ?>>
    <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_columns_ipad"] == '2') { ?> selected="selected"<?php } ?>>
    <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_columns_ipad"] == '3') { ?> selected="selected"<?php } ?>>
    <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_columns_ipad"] == '4') { ?> selected="selected"<?php } ?>>
    <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>
                            <li class="blog-columns-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php echo _e('Blog Grid Columns', 'blog-manager-wp'); ?>
                                    <?php echo '<br />(<i>' . __('Tablet', 'blog-manager-wp') . ' - 480px - 720px</i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select column for post', 'blog-manager-wp'); ?></span></span>
    <?php $settings["template_columns_tablet"] = isset($settings["template_columns_tablet"]) ? $settings["template_columns_tablet"] : 2; ?>
                                    <select name="template_columns_tablet" id="template_columns_tablet" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_columns_tablet"] == '1') { ?> selected="selected"<?php } ?>>
    <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_columns_tablet"] == '2') { ?> selected="selected"<?php } ?>>
    <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_columns_tablet"] == '3') { ?> selected="selected"<?php } ?>>
    <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_columns_tablet"] == '4') { ?> selected="selected"<?php } ?>>
    <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>
                            <li class="blog-columns-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php echo _e('Blog Grid Columns', 'blog-manager-wp'); ?>
                                    <?php echo '<br />(<i>' . __('Mobile - Smaller Than', 'blog-manager-wp') . ' 480px </i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select column for post', 'blog-manager-wp'); ?></span></span>
    <?php $settings["template_columns_mobile"] = isset($settings["template_columns_mobile"]) ? $settings["template_columns_mobile"] : 2; ?>
                                    <select name="template_columns_mobile" id="template_columns_mobile" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_columns_mobile"] == '1') { ?> selected="selected"<?php } ?>>
    <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_columns_mobile"] == '2') { ?> selected="selected"<?php } ?>>
    <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_columns_mobile"] == '3') { ?> selected="selected"<?php } ?>>
    <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_columns_mobile"] == '4') { ?> selected="selected"<?php } ?>>
    <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>
                            <li class="blog-templatecolor-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Blog Posts Template Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select post template color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_color" id="template_color" value="<?php echo esc_attr(isset($settings['template_color'])) ? esc_attr($settings['template_color']) : ''; ?>"/>
                                </div>
                            </li>

                            <li class="hoverbackcolor-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                        <?php _e('Blog Posts hover Background Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select post background color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="grid_hoverback_color" id="grid_hoverback_color" value="<?php echo esc_attr(( isset($settings['grid_hoverback_color'])) ) ? esc_attr($settings['grid_hoverback_color']) : ''; ?>"/>
                                </div>
                            </li>
                            <li class="blog-template-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Background Color for Blog Posts', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select post background color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_bgcolor" id="template_bgcolor" value="<?php echo esc_attr(( isset($settings['template_bgcolor'])) ) ? esc_attr($settings['template_bgcolor']) : ''; ?>"/>
                                </div>
                            </li>
                            <li class="blog-template-tr alternative-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                    <?php _e('Alternative Background Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Display alternative background color', 'blog-manager-wp'); ?></span></span>
    <?php $pbsm_alter = get_option('template_alternativebackground'); ?>
                                   <div class="switch"> 
                                        <input class="switch-input" id="template_alternativebackground_0" name="template_alternativebackground" type="radio" value="0" <?php echo checked(0, esc_attr($pbsm_alter)); ?>/>
                                        <label class="switch-label switch-label-off" for="template_alternativebackground_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                        <input class="switch-input" id="template_alternativebackground_1" name="template_alternativebackground" type="radio" value="1" <?php echo checked(1, esc_attr($pbsm_alter)); ?> />
                                        <label class="switch-label switch-label-on" for="template_alternativebackground_1"><?php _e('No', 'blog-manager-wp'); ?></label>
										<span class="switch-selection"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="alternative-color-tr">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Choose Alternative Background Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select alternative background color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_alterbgcolor" id="template_alterbgcolor" value="<?php echo esc_attr(( isset($settings['template_alterbgcolor'])) ) ? esc_attr($settings['template_alterbgcolor']) : ''; ?>"/>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Choose Link Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select link color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_ftcolor" id="template_ftcolor" value="<?php echo esc_attr(( isset($settings['template_ftcolor'])) ) ? esc_attr($settings['template_ftcolor']) : ''; ?>"/>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Choose Link Hover Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select link hover color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_fthovercolor" id="template_fthovercolor" value="<?php echo esc_attr(( isset($settings['template_fthovercolor'])) ) ? esc_attr($settings['template_fthovercolor']) : ''; ?>" data-default-color="<?php echo esc_attr(( isset($settings['template_fthovercolor'])) ) ? esc_attr($settings['template_fthovercolor']) : ''; ?>"/>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div id="bdptitle" class="postbox postbox-with-fw-options" style="<?php echo esc_attr($pbsmptitle_class_show);?>">
                        <ul class="pbsm-settings">
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Post Title Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select post title color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_titlecolor" id="template_titlecolor" value="<?php echo esc_attr(( isset($settings['template_titlecolor'])) ) ? esc_attr($settings['template_titlecolor']) : ''; ?>"/>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                        <?php _e('Post Title Link Hover Color', 'blog-manager-wp'); ?>                                                                                       
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select post title link hover color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_titlehovercolor" id="template_titlehovercolor" value="<?php echo esc_attr(( isset($settings['template_titlehovercolor'])) ) ? esc_attr($settings['template_titlehovercolor']) : ''; ?>"/>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">                                                                                                                                                                                                                                                                                 
                                    <span class="pbsm-key-title">
                                        <?php _e('Post Title Background Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select post title background color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_titlebackcolor" id="template_titlebackcolor" value="<?php echo esc_attr(( isset($settings['template_titlebackcolor'])) ) ? esc_attr($settings['template_titlebackcolor']) : ''; ?>"/>
                                </div>
                            </li>
                            <li>
                                <h3 class="pbsm-table-title"><?php _e('Typography Settings', 'blog-manager-wp'); ?></h3>

                                <div class="pbsm-typography-wrapper pbsm-typography-options">

                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Font Size (px)', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select post title font size', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="grid_col_space range_slider_fontsize" id="template_postTitlefontsizeInput" data-value="<?php echo get_option('template_titlefontsize'); ?>"></div>
                                            <div class="slide_val">
                                                <span></span>
                                                <input class="grid_col_space_val range-slider__value" name="template_titlefontsize" id="template_titlefontsize" value="<?php echo get_option('template_titlefontsize'); ?>" onkeypress="return isNumberKey(event)" />
                                            </div>
 
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Line Height (px)', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter line height', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="quantity">
                                                <input type="number" name="template_titleLineHeight" id="template_titleLineHeight" step="0.1" min="0" value="<?php echo get_option('template_titleLineHeight'); ?>" onkeypress="return isNumberKey(event)">
                                                <div class="quantity-nav">
                                                    <div class="quantity-button quantity-up">+</div>
                                                    <div class="quantity-button quantity-down">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Letter Spacing (px)', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter letter spacing', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="quantity">
                                                <input type="number" name="template_titleLetterSpacing" id="template_titleLetterSpacing" step="1" min="0" value="<?php echo get_option('template_titleLetterSpacing'); ?>" onkeypress="return isNumberKey(event)">
                                                <div class="quantity-nav">
                                                    <div class="quantity-button quantity-up">+</div>
                                                    <div class="quantity-button quantity-down">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div id="bdpcontent" class="postbox postbox-with-fw-options" style="<?php echo esc_attr($pbsmpcontent_class_show); ?>">
                        <ul class="pbsm-settings">
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
                                    <?php _e('For each Article in a Feed, Show ', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('To display full text for each post, select full text option, otherwise select the summary option.', 'blog-manager-wp'); ?></span></span>
    <?php
    $rss_use_excerpt = get_option('rss_use_excerpt');
    ?>
                                    <div class="switch switch-big"> 
                                        <input class="switch-input" id="rss_use_excerpt_0" name="rss_use_excerpt" type="radio" value="0" <?php echo checked(0, esc_attr($rss_use_excerpt)); ?> />
                                        <label class="switch-label switch-label-big switch-label-off"  for="rss_use_excerpt_0"><?php _e('Full Text', 'blog-manager-wp'); ?></label>
                                        <input class="switch-input" id="rss_use_excerpt_1" name="rss_use_excerpt" type="radio" value="1" <?php echo checked(1, esc_attr($rss_use_excerpt)); ?> />
                                        <label class="switch-label switch-label-big switch-label-on"  for="rss_use_excerpt_1"><?php _e('Summary', 'blog-manager-wp'); ?></label>
										<span class="switch-selection switch-selection-big"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="excerpt_length">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Post Content Length (words)', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter number of words for post content length', 'blog-manager-wp'); ?></span></span>
                                    <div class="quantity">
                                        <input type="number" id="txtExcerptlength" name="txtExcerptlength" value="<?php echo get_option('excerpt_length'); ?>" min="0" step="1" class="small-text" onkeypress="return isNumberKey(event)">
                                        <div class="quantity-nav">
                                            <div class="quantity-button quantity-up">+</div>
                                            <div class="quantity-button quantity-down">-</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="excerpt_length">
    <?php $display_html_tags = get_option('display_html_tags', 0); ?>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Display HTML tags with Summary', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show HTML tags with summary', 'blog-manager-wp'); ?></span></span>
                                    <div class="switch"> 
                                        <input class="switch-input" id="display_html_tags_1" name="display_html_tags" type="radio" value="1" <?php echo checked(1, esc_attr($display_html_tags)); ?>/>
                                        <label class="switch-label switch-label-off" for="display_html_tags_1"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                        <input class="switch-input" id="display_html_tags_0" name="display_html_tags" type="radio" value="0" <?php echo checked(0, esc_attr($display_html_tags)); ?> />
                                        <label class="switch-label switch-label-on" for="display_html_tags_0"><?php _e('No', 'blog-manager-wp'); ?></label>
										<span class="switch-selection"></span>
                                   </div>
                                </div>
                            </li>
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Post Content Color', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon pbsm-tooltips-icon-color"><span class="pbsm-tooltips"><?php _e('Select post content color', 'blog-manager-wp'); ?></span></span>
                                    <input type="text" name="template_contentcolor" id="template_contentcolor" value="<?php echo esc_attr($settings['template_contentcolor']); ?>"/>
                                </div>
                            </li>

                            <li class="read_more_on">
                                <h3 class="pbsm-table-title"><?php _e('Read More Settings', 'blog-manager-wp'); ?></h3>

                                <div style="margin-bottom: 15px;">
                                    <div class="pbsm-left">
                                        <span class="pbsm-key-title">
                                        <?php _e('Display Read More On', 'blog-manager-wp'); ?>
                                        </span>
                                    </div>
                                    <div class="pbsm-right">
                                        <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select option for display read more button where to display', 'blog-manager-wp'); ?></span></span>
                                        <?php
                                        $read_more_on = get_option('read_more_on');
                                        $read_more_on = ( $read_more_on != '' ) ? $read_more_on : 2;
                                        ?>
                                        <div class="switch-toggle switch-3 switch-candy">
                                            <input id="readmore_on_1" name="readmore_on" type="radio" value="1" <?php checked(1, $read_more_on); ?> />
                                            <label  id="pbsm-options-button" for="readmore_on_1" <?php checked(1, $read_more_on); ?>><?php _e('Same Line', 'blog-manager-wp'); ?></label>
                                            <input  id="readmore_on_2" name="readmore_on" type="radio" value="2" <?php checked(2, $read_more_on); ?> />
                                            <label  id="pbsm-options-button" for="readmore_on_2" <?php checked(2, $read_more_on); ?>><?php _e('Next Line', 'blog-manager-wp'); ?></label>
                                            <input  id="readmore_on_0" name="readmore_on" type="radio" value="0" <?php checked(0, $read_more_on); ?>/>
                                            <label  id="pbsm-options-button" for="readmore_on_0" <?php checked(0, $read_more_on); ?>><?php _e('Disable', 'blog-manager-wp'); ?></label>										
                                        </div>
                                    </div>
                                </div>

                                <div class="pbsm-typography-wrapper pbsm-typography-options pbsm-readmore-options">
                                    <div class="pbsm-typography-cover read_more_text">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Read More Text', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter text for read more button', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <input type="text" name="txtReadmoretext" id="txtReadmoretext" value="<?php echo get_option('read_more_text'); ?>" placeholder="Enter read more text">
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover read_more_text_color">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Text Color', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select read more text color', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <input type="text" name="template_readmorecolor" id="template_readmorecolor" value="<?php echo ( esc_attr(isset($settings['template_readmorecolor'])) ) ? esc_attr($settings['template_readmorecolor']) : ''; ?>"/>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover read_more_text_background">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Background Color', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select read more text background color', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <input type="text" name="template_readmorebackcolor" id="template_readmorebackcolor" value="<?php echo esc_attr(( isset($settings['template_readmorebackcolor'])) ) ? esc_attr($settings['template_readmorebackcolor']) : ''; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <h3 class="pbsm-table-title"><?php _e('Typography Settings', 'blog-manager-wp'); ?></h3>
                                <div class="pbsm-typography-wrapper pbsm-typography-options">

                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Font Size (px)', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select font size for post content', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="grid_col_space range_slider_fontsize" id="template_postContentfontsizeInput" data-value="<?php echo get_option('content_fontsize'); ?>"></div>
                                            <div class="slide_val">
                                                <span></span>
                                                <input class="grid_col_space_val range-slider__value" name="content_fontsize" id="content_fontsize" value="<?php echo get_option('content_fontsize'); ?>" onkeypress="return isNumberKey(event)" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Line Height (px)', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter line height', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="quantity">
                                                <input type="number" name="content_LineHeight" id="content_LineHeight" step="0.1" min="0" value="<?php echo get_option('content_LineHeight'); ?>" onkeypress="return isNumberKey(event)">
                                                <div class="quantity-nav">
                                                    <div class="quantity-button quantity-up">+</div>
                                                    <div class="quantity-button quantity-down">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
                                                <?php _e('Letter Spacing (px)', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter letter spacing', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="quantity">
                                                <input type="number" name="content_LetterSpacing" id="content_LetterSpacing" step="1" min="0" value="<?php echo get_option('content_LetterSpacing'); ?>" onkeypress="return isNumberKey(event)">
                                                <div class="quantity-nav">
                                                    <div class="quantity-button quantity-up">+</div>
                                                    <div class="quantity-button quantity-down">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="bdpslider" class="postbox postbox-with-fw-options" style="<?php echo esc_attr($pbsmpslider_class_show);?>">
                        <ul class="pbsm-settings">
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                    <?php _e('Slider Effect', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select effect for slider layout', 'blog-manager-wp'); ?></span></span>
    <?php $settings["template_slider_effect"] = (isset($settings["template_slider_effect"])) ? $settings["template_slider_effect"] : ''; ?>
                                    <select name="template_slider_effect" id="template_slider_effect" class="chosen-select">
                                        <option value="slide" <?php if ($settings["template_slider_effect"] == 'slide') { ?> selected="selected"<?php } ?>>
    <?php _e('Slide', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="fade" <?php if ($settings["template_slider_effect"] == 'fade') { ?> selected="selected"<?php } ?>>
    <?php _e('Fade', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>

                            <li class="slider_columns_tr">
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
    <?php _e('Slider Columns', 'blog-manager-wp'); ?>
                                    <?php echo '<br />(<i>' . __('Desktop - Above', 'blog-manager-wp') . ' 980px</i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select column for slider', 'blog-manager-wp'); ?></span></span>
    <?php $settings["template_slider_columns"] = (isset($settings["template_slider_columns"])) ? $settings["template_slider_columns"] : 1; ?>
                                    <select name="template_slider_columns" id="template_slider_columns" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_slider_columns"] == '1') { ?> selected="selected"<?php } ?>>
    <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_slider_columns"] == '2') { ?> selected="selected"<?php } ?>>
    <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_slider_columns"] == '3') { ?> selected="selected"<?php } ?>>
    <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_slider_columns"] == '4') { ?> selected="selected"<?php } ?>>
    <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="5" <?php if ($settings["template_slider_columns"] == '5') { ?> selected="selected"<?php } ?>>
    <?php _e('5 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="6" <?php if ($settings["template_slider_columns"] == '6') { ?> selected="selected"<?php } ?>>
    <?php _e('6 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>

                            <li class="slider_columns_tr">
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                        <?php _e('Slider Columns', 'blog-manager-wp'); ?>
                                    <?php echo '<br />(<i>' . __('iPad', 'blog-manager-wp') . ' - 720px - 980px</i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select column for slider', 'blog-manager-wp'); ?></span></span>
                                            <?php $settings["template_slider_columns_ipad"] = (isset($settings["template_slider_columns_ipad"])) ? $settings["template_slider_columns_ipad"] : 1; ?>
                                    <select name="template_slider_columns_ipad" id="template_slider_columns_ipad" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_slider_columns_ipad"] == '1') { ?> selected="selected"<?php } ?>>
                                            <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_slider_columns_ipad"] == '2') { ?> selected="selected"<?php } ?>>
                                            <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_slider_columns_ipad"] == '3') { ?> selected="selected"<?php } ?>>
                                            <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_slider_columns_ipad"] == '4') { ?> selected="selected"<?php } ?>>
                                            <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="5" <?php if ($settings["template_slider_columns_ipad"] == '5') { ?> selected="selected"<?php } ?>>
                                            <?php _e('5 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="6" <?php if ($settings["template_slider_columns_ipad"] == '6') { ?> selected="selected"<?php } ?>>
                                            <?php _e('6 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>

                            <li class="slider_columns_tr">
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                        <?php _e('Slider Columns', 'blog-manager-wp'); ?>
                                    <?php echo '<br />(<i>' . __('Tablet', 'blog-manager-wp') . ' - 480px - 720px</i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select column for slider', 'blog-manager-wp'); ?></span></span>
                                        <?php $settings["template_slider_columns_tablet"] = (isset($settings["template_slider_columns_tablet"])) ? $settings["template_slider_columns_tablet"] : 1; ?>
                                    <select name="template_slider_columns_tablet" id="template_slider_columns_tablet" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_slider_columns_tablet"] == '1') { ?> selected="selected"<?php } ?>>
                                            <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_slider_columns_tablet"] == '2') { ?> selected="selected"<?php } ?>>
                                            <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_slider_columns_tablet"] == '3') { ?> selected="selected"<?php } ?>>
                                            <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_slider_columns_tablet"] == '4') { ?> selected="selected"<?php } ?>>
                                            <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="5" <?php if ($settings["template_slider_columns_tablet"] == '5') { ?> selected="selected"<?php } ?>>
                                            <?php _e('5 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="6" <?php if ($settings["template_slider_columns_tablet"] == '6') { ?> selected="selected"<?php } ?>>
                                            <?php _e('6 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>

                            <li class="slider_columns_tr">
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                        <?php _e('Slider Columns', 'blog-manager-wp'); ?>
                                        <?php echo '<br />(<i>' . __('Mobile - Smaller Than', 'blog-manager-wp') . ' 480px </i>)'; ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select column for slider', 'blog-manager-wp'); ?></span></span>

                                        <?php $settings["template_slider_columns_mobile"] = (isset($settings["template_slider_columns_mobile"])) ? $settings["template_slider_columns_mobile"] : 1; ?>
                                    <select name="template_slider_columns_mobile" id="template_slider_columns_mobile" class="chosen-select">
                                        <option value="1" <?php if ($settings["template_slider_columns_mobile"] == '1') { ?> selected="selected"<?php } ?>>
                                            <?php _e('1 Column', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="2" <?php if ($settings["template_slider_columns_mobile"] == '2') { ?> selected="selected"<?php } ?>>
                                            <?php _e('2 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="3" <?php if ($settings["template_slider_columns_mobile"] == '3') { ?> selected="selected"<?php } ?>>
                                            <?php _e('3 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="4" <?php if ($settings["template_slider_columns_mobile"] == '4') { ?> selected="selected"<?php } ?>>
                                            <?php _e('4 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="5" <?php if ($settings["template_slider_columns_mobile"] == '5') { ?> selected="selected"<?php } ?>>
                                            <?php _e('5 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                        <option value="6" <?php if ($settings["template_slider_columns_mobile"] == '6') { ?> selected="selected"<?php } ?>>
                                            <?php _e('6 Columns', 'blog-manager-wp'); ?>
                                        </option>
                                    </select>
                                </div>
                            </li>


                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                    <?php _e('Display Slider Controls', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show slider control', 'blog-manager-wp'); ?></span></span>
    <?php $display_slider_controls = isset($settings['display_slider_controls']) ? $settings['display_slider_controls'] : '1'; ?>
                                    <div class="switch">  
                                        <input class="switch-input" id="display_slider_controls_1" name="display_slider_controls" type="radio" value="1" <?php checked(1, $display_slider_controls); ?> />
                                        <label class="switch-label switch-label-off" for="display_slider_controls_1" <?php checked(1, $display_slider_controls); ?>><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                        <input class="switch-input" id="display_slider_controls_0" name="display_slider_controls" type="radio" value="0" <?php checked(0, $display_slider_controls); ?> />
                                        <label class="switch-label switch-label-on" for="display_slider_controls_0" <?php checked(0, $display_slider_controls); ?>><?php _e('No', 'blog-manager-wp'); ?></label>
										<span class="switch-selection"></span>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                    <?php _e('Slider Autoplay', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Show slider autoplay', 'blog-manager-wp'); ?></span></span>
                                        <?php $slider_autoplay = isset($settings['slider_autoplay']) ? $settings['slider_autoplay'] : '1'; ?>
                                    <div class="switch"> 
                                        <input class="switch-input" id="slider_autoplay_1" name="slider_autoplay" type="radio" value="1" <?php checked(1, $slider_autoplay); ?> />
                                        <label class="switch-label switch-label-off" for="slider_autoplay_1" <?php checked(1, $slider_autoplay); ?>><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                        <input class="switch-input" id="slider_autoplay_0" name="slider_autoplay" type="radio" value="0" <?php checked(0, $slider_autoplay); ?> />
                                        <label class="switch-label switch-label-on" for="slider_autoplay_0" <?php checked(0, $slider_autoplay); ?>><?php _e('No', 'blog-manager-wp'); ?></label>
										<span class="switch-selection"></span>
                                    </div>
                                </div>
                            </li>

                            <li class="slider_autoplay_tr">
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                    <?php _e('Enter slider autoplay intervals (ms)', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter slider autoplay intervals', 'blog-manager-wp'); ?></span></span>
                                        <?php $slider_autoplay_intervals = isset($settings['slider_autoplay_intervals']) ? $settings['slider_autoplay_intervals'] : '1'; ?>
                                    <input type="number" id="slider_autoplay_intervals" name="slider_autoplay_intervals" step="1" min="0" value="<?php echo esc_attr(isset($settings['slider_autoplay_intervals'])) ? esc_attr($settings['slider_autoplay_intervals']) : '3000'; ?>" placeholder="<?php esc_attr_e('Enter slider intervals', 'blog-manager-wp'); ?>" onkeypress="return isNumberKey(event)">
                                </div>
                            </li>

                            <li class="slider_autoplay_tr">
                                <div class="pbsm-left">
                                    <span class="pbsmp-key-title">
                                    <?php _e('Slider Speed (ms)', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enter slider speed', 'blog-manager-wp'); ?></span></span>
    <?php $slider_speed = isset($settings['slider_speed']) ? $settings['slider_speed'] : '300'; ?>
                                    <input type="number" id="slider_speed" name="slider_speed" step="1" min="0" value="<?php echo esc_attr(isset($settings['slider_speed'])) ? esc_attr($settings['slider_speed']) : '300'; ?>" placeholder="<?php esc_attr_e('Enter slider intervals', 'blog-manager-wp'); ?>" onkeypress="return isNumberKey(event)">
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div id="bdpsocial" class="postbox postbox-with-fw-options" style="<?php echo esc_attr($pbsmpsocial_class_show); ?>">
                        <ul class="pbsm-settings">
                            <li>
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Social Share', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Enable/Disable social share link', 'blog-manager-wp'); ?></span></span>
                                    <div class="switch switch-big"> 
                                        <input class="switch-input" id="social_share_1" name="social_share" type="radio" value="1" <?php echo checked(1, get_option('social_share')); ?>/>
                                        <label class="switch-label switch-label-big switch-label-off" id="social_share_1" for="social_share_1" <?php checked(1, get_option('social_share')); ?>><?php _e('Enable', 'blog-manager-wp'); ?></label>
                                        <input class="switch-input" id="social_share_0" name="social_share" type="radio" value="0" <?php echo checked(0, get_option('social_share')); ?> />
                                        <label class="switch-label switch-label-big switch-label-on" id="social_share_0" for="social_share_0" <?php checked(0, get_option('social_share')); ?>><?php _e('Disable', 'blog-manager-wp'); ?></label>
                                    <span class="switch-selection switch-selection-big"></span>
								</div>
                                </div>
                            </li>
                                 <li class="pbsm-social-share-options">
                                <div class="pbsm-left">
                                    <span class="pbsm-key-title">
    <?php _e('Shape of Social Icon', 'blog-manager-wp'); ?>
                                    </span>
                                </div>
                                <div class="pbsm-right">
                                    <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Select shape of social icon', 'blog-manager-wp'); ?></span></span>
                                   <div class="switch switch-big">
                                        <input class="switch-input" id="social_icon_style_0" name="social_icon_style" type="radio" value="0" <?php echo checked(0, get_option('social_icon_style')); ?>/>
                                        <label class="switch-label switch-label-big switch-label-off" for="social_icon_style_0"><?php _e('Circle', 'blog-manager-wp'); ?></label>
                                        <input class="switch-input" id="social_icon_style_1" name="social_icon_style" type="radio" value="1" <?php echo checked(1, get_option('social_icon_style')); ?> />
                                        <label class="switch-label switch-label-big switch-label-on" for="social_icon_style_1"><?php _e('Square', 'blog-manager-wp'); ?></label>
										<span class="switch-selection switch-selection-big"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="pbsm-display-settings pbsm-social-share-options">
                                <h3 class="pbsm-table-title"><?php _e('Social Share Links Settings', 'blog-manager-wp'); ?></h3>
                                <div class="pbsm-typography-wrapper">
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Facebook Share Link', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Display facebook share link', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="switch"> 
                                                <input class="switch-input" id="facebook_link_0" name="facebook_link" type="radio" value="0" <?php echo checked(0, get_option('facebook_link')); ?>/>
                                                <label class="switch-label switch-label-off" for="facebook_link_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="facebook_link_1" name="facebook_link" type="radio" value="1" <?php echo checked(1, get_option('facebook_link')); ?> />
                                                <label class="switch-label switch-label-on" for="facebook_link_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Linkedin Share Link', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Display linkedin share link', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="switch"> 
                                                <input class="switch-input" id="linkedin_link_0" name="linkedin_link" type="radio" value="0" <?php echo checked(0, get_option('linkedin_link')); ?>/>
                                                <label class="switch-label switch-label-off" for="linkedin_link_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="linkedin_link_1" name="linkedin_link" type="radio" value="1" <?php echo checked(1, get_option('linkedin_link')); ?> />
                                                <label class="switch-label switch-label-on" for="linkedin_link_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Pinterest Share link', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Display Pinterest share link', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                            <div class="switch"> 
                                                <input class="switch-input" id="pinterest_link_0" name="pinterest_link" type="radio" value="0" <?php echo checked(0, get_option('pinterest_link')); ?>/>
                                                <label class="switch-label switch-label-off" for="pinterest_link_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="pinterest_link_1" name="pinterest_link" type="radio" value="1" <?php echo checked(1, get_option('pinterest_link')); ?> />
                                                <label class="switch-label switch-label-on" for="pinterest_link_1"><?php _e('No', 'blog-manager-wp'); ?></label>
												<span class="switch-selection"></span>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="pbsm-typography-cover">
                                        <div class="pbsmp-typography-label">
                                            <span class="pbsm-key-title">
    <?php _e('Twitter Share Link', 'blog-manager-wp'); ?>
                                            </span>
                                            <span class="fas fa-question-circle pbsm-tooltips-icon"><span class="pbsm-tooltips"><?php _e('Display twitter share link', 'blog-manager-wp'); ?></span></span>
                                        </div>
                                        <div class="pbsm-typography-content">
                                           <div class="switch"> 
                                                <input class="switch-input" id="twitter_link_0" name="twitter_link" type="radio" value="0" <?php echo checked(0, get_option('twitter_link')); ?>/>
                                                <label class="switch-label switch-label-off" for="twitter_link_0"><?php _e('Yes', 'blog-manager-wp'); ?></label>
                                                <input class="switch-input" id="twitter_link_1" name="twitter_link" type="radio" value="1" <?php echo checked(1, get_option('twitter_link')); ?> />
                                                <label class="switch-label switch-label-on" for="twitter_link_1"><?php _e('No', 'blog-manager-wp'); ?></label>			
												<span class="switch-selection"></span>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="inner">
    <?php wp_nonce_field('blog_nonce_ac', 'blog_nonce'); ?>
                <input type="submit" style="display: none;" class="save_blogdesign" value="<?php _e('Save Changes', 'blog-manager-wp'); ?>" />
                <p class="wl-saving-warning"></p>
                <div class="clear"></div>
            </div>
        </form>
        <div class="pbsm-admin-sidebar hidden">
            <div class="pbsm-help">
                <h2><?php _e('Help to improve this plugin!', 'blog-manager-wp'); ?></h2>
                <div class="help-wrapper">
                    <span><?php _e('Enjoyed this plugin?', 'blog-manager-wp'); ?>&nbsp;</span>
                    <span><?php _e('You can help by', 'blog-manager-wp'); ?>
                    </span>
                    <div class="pbsm-total-download">
                        <?php _e('Downloads:', 'blog-manager-wp'); ?><?php pbsm_get_total_downloads(); ?>
                    </div>
                </div>
            </div>
            <div class="useful_plugins">
                <h2>
    <?php _e('Blog Manager PRO', 'blog-manager-wp'); ?>
                </h2>
                <div class="help-wrapper">
                    <div class="pro-content">
                        <ul class="advertisementContent">
                            <li><?php _e('50 Beautiful Blog Templates', 'blog-manager-wp'); ?></li>
                            <li><?php _e('5+ Unique Timeline Templates', 'blog-manager-wp'); ?></li>
                            <li><?php _e('10 Unique Grid Templates', 'blog-manager-wp'); ?></li>
                            <li><?php _e('3 Unique Slider Templates', 'blog-manager-wp'); ?></li>
                            <li><?php _e('200+ Blog Layout Variations', 'blog-manager-wp'); ?></li>
                            <li><?php _e('Multiple Single Post Layout options', 'blog-manager-wp'); ?></li>
                            <li><?php _e('Category, Tag, Author & Date Layouts', 'blog-manager-wp'); ?></li>
                            <li><?php _e('Post Type & Taxonomy Filter', 'blog-manager-wp'); ?></li>
                            <li><?php _e('800+ Google Font Support', 'blog-manager-wp'); ?></li>
                            <li><?php _e('600+ Font Awesome Icons Support', 'blog-manager-wp'); ?></li>
                        </ul>
                        <p class="pricing_change"><?php _e('Now only at', 'blog-manager-wp'); ?> <ins>39</ins></p>
                    </div>
                </div>
            </div>
            <div class="pbsm-support">
                <h3><?php _e('Need Support?', 'blog-manager-wp'); ?></h3>
            </div>
            <div class="pbsm-support">
                <h3><?php _e('Share & Follow Us', 'blog-manager-wp'); ?></h3>
                <!-- Twitter -->
                <div class="help-wrapper">
                    <div style='display:block;margin-bottom:8px;'>
                        <a href="<?php echo esc_url('https://twitter.com/wpdiscover'); ?>" class="twitter-follow-button" data-show-count="false" data-show-screen-name="true" data-dnt="true">Follow @wpdiscover</a>
                        <script>!function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + '://platform.twitter.com/widgets.js';
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, 'script', 'twitter-wjs');</script>
                    </div>
                    <!-- Facebook -->
                    <div style='display:block;margin-bottom:10px;'>
                        <div id="fb-root"></div>
                        <script>(function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                        
                    </div>
                    <div style='display:block;margin-bottom:8px;'>
                        <script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
                    </div>
                </div>
            </div>
        </div>
        <div id="pbsm_popupdiv" class="pbsm-template-popupdiv" style="display: none;">
            <?php
            $tempate_list = pbsm_template_list();

            foreach ($tempate_list as $key => $value) {
                $classes = explode(' ', $value['class']);
                foreach ($classes as $class) {
                    $all_class[] = $class;
                }
            }
            $count = array_count_values($all_class);
            ?>
            <ul class="pbsm_template_tab">
                <div class="pbsm-template-search-cover">
                    <input type="text" class="pbsm-template-search" id="pbsm-template-search" placeholder="<?php _e('Search Template', 'blog-manager-wp'); ?>" />
                    <span class="pbsm-template-search-clear"></span>
                </div>
            </ul>

            <?php
            echo '<div class="pbsm-template-cover">';
            foreach ($tempate_list as $key => $value) {
                if ($key == 'grid-layout' || $key == 'default_slider' || $key == 'default_layout' || $key == 'center_top' || $key == 'timeline' || $key == 'news_feed') {
                    $class = 'pbsm-lite';
                } else {
                    $class = 'bp-pro';
                }
                ?>
                <div class="pbsm-template-thumbnail <?php echo esc_attr($value['class'] . ' ' . $class); ?>">
                    <div class="pbsm-template-thumbnail-inner">
                        <img src="<?php echo esc_url(PBSM_URL . 'assets/images/layouts/' . $value['image_name']); ?>" data-value="<?php echo esc_attr($key); ?>" alt="<?php echo esc_attr($value['template_name']); ?>" title="<?php echo esc_attr($value['template_name']); ?>">
        <?php if ($class == 'pbsm-lite') { ?>
                            <div class="pbsm-hover_overlay">
                                <div class="pbsm-popup-template-name">
                                    <div class="pbsm-popum-select"><a href="#"><?php _e('Select Template', 'blog-manager-wp'); ?></a></div>
                                </div>
                            </div>
        <?php } else { ?>
                            <div class="pbsm_overlay"></div>
                            <div class="pbsm-img-hover_overlay">
                                <img src="<?php echo esc_url(PBSM_URL . 'assets/images/pro-tag.png'); ?>" alt="Available in Pro" />
                            </div>
                            <div class="pbsm-hover_overlay">
                                <div class="pbsm-popup-template-name">
                                    <div class="pbsm-popup-view"><a href="<?php echo esc_attr( $value['demo_link'] ); ?>" target="_blank"><?php esc_html_e( 'Live Demo', 'blog-manager-wp' ); ?></a></div>
                                </div>
                            </div>
                <?php } ?>
            </div>
                    <span class="pbsm-span-template-name"><?php echo esc_html($value['template_name']); ?></span>
                </div>
                <?php
            }
            echo '</div>';
            echo '<h3 class="no-template" style="display: none;">' . __('No template found. Please try again', 'blog-manager-wp') . '</h3>';
            ?>

        </div>
    </div>
    <?php
}

/*
 * Display Optin form
 */

function pbsm_welcome_function() {
    global $wpdb;
    $pbsm_admin_email = get_option('admin_email');
    ?>
    <div class='pbsm_header_wizard'>
        <p><?php echo esc_attr(__('Hi there!', 'blog-manager-wp')); ?></p>
        <p><?php echo esc_attr(__("Don't ever miss an opportunity to opt in for Email Notifications / Announcements about exciting New Features and Update Releases.", 'blog-manager-wp')); ?></p>
        <p><?php echo esc_attr(__('Contribute in helping us making our plugin compatible with most plugins and themes by allowing to share non-sensitive information about your website.', 'blog-manager-wp')); ?></p>
        <p><b><?php echo esc_attr(__('Email Address for Notifications', 'blog-manager-wp')); ?> :</b></p>
        <p><input type='email' value='<?php echo esc_attr($pbsm_admin_email); ?>' id='pbsm_admin_email' /></p>
        <p><?php echo esc_attr(__("If you're not ready to Opt-In, that's ok too!", 'blog-manager-wp')); ?></p>
        <p><b><?php echo esc_attr(__('Blog Manager will still work fine.', 'blog-manager-wp')); ?> :</b></p>
        <p onclick="pbsm_show_hide_permission()" class='pbsm_permission'><b><?php echo esc_attr(__('What permissions are being granted?', 'blog-manager-wp')); ?></b></p>
        <div class='pbsm_permission_cover' style='display:none'>
            <div class='pbsm_permission_row'>
                <div class='pbsm_50'>
                    <i class='dashicons dashicons-admin-users gb-dashicons-admin-users'></i>
                    <div class='pbsm_50_inner'>
                        <label><?php echo esc_attr(__('User Details', 'blog-manager-wp')); ?></label>
                        <label><?php echo esc_attr(__('Name and Email Address', 'blog-manager-wp')); ?></label>
                    </div>
                </div>
                <div class='pbsm_50'>
                    <i class='dashicons dashicons-admin-plugins gb-dashicons-admin-plugins'></i>
                    <div class='pbsm_50_inner'>
                        <label><?php echo esc_attr(__('Current Plugin Status', 'blog-manager-wp')); ?></label>
                        <label><?php echo esc_attr(__('Activation, Deactivation and Uninstall', 'blog-manager-wp')); ?></label>
                    </div>
                </div>
            </div>
            <div class='pbsm_permission_row'>
                <div class='pbsm_50'>
                    <i class='dashicons dashicons-testimonial gb-dashicons-testimonial'></i>
                    <div class='pbsm_50_inner'>
                        <label><?php echo esc_attr(__('Notifications', 'blog-manager-wp')); ?></label>
                        <label><?php echo esc_attr(__('Updates & Announcements', 'blog-manager-wp')); ?></label>
                    </div>
                </div>
                <div class='pbsm_50'>
                    <i class='dashicons dashicons-welcome-view-site gb-dashicons-welcome-view-site'></i>
                    <div class='pbsm_50_inner'>
                        <label><?php echo esc_attr(__('Website Overview', 'blog-manager-wp')); ?></label>
                        <label><?php echo esc_attr(__('Site URL, WP Version, PHP Info, Plugins & Themes Info', 'blog-manager-wp')); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <p>
            <input type='checkbox' class='pbsm_agree' id='pbsm_agree_gdpr' value='1' />
            <label for='pbsm_agree_gdpr' class='pbsm_agree_gdpr_lbl'><?php echo esc_attr(__('By clicking this button, you agree with the storage and handling of your data as mentioned above by this website. (GDPR Compliance)', 'blog-manager-wp')); ?></label>
        </p>
        <p class='pbsm_buttons'>
            <a href="javascript:void(0)" class='button button-secondary' onclick="pbsm_submit_optin('cancel')">
                <?php
                echo esc_attr(__('Skip', 'blog-manager-wp'));
                echo ' &amp; ';
                echo esc_attr(__('Continue', 'blog-manager-wp'));
                ?>
            </a>
            <a href="javascript:void(0)" class='button button-primary' onclick="pbsm_submit_optin('submit')">
                <?php
                echo esc_attr(__('Opt-In', 'blog-manager-wp'));
                echo ' &amp; ';
                echo esc_attr(__('Continue', 'blog-manager-wp'));
                ?>
            </a>
        </p>
    </div>
    <?php
}

/**
 * Display Pagination
 */
function pbsm_pagination($args = array()) {
    // Don't print empty markup if there's only one page.
    if ($GLOBALS['wp_query']->max_num_pages < 2) {
        return;
    }
    $navigation = '';
    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $query_args = array();
    $url_parts = explode('?', $pagenum_link);

    if (isset($url_parts[1])) {
        wp_parse_str($url_parts[1], $query_args);
    }

    $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
    $pagenum_link = trailingslashit($pagenum_link) . '%_%';

    $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links(
            array(
                'base' => $pagenum_link,
                'format' => $format,
                'total' => $GLOBALS['wp_query']->max_num_pages,
                'current' => $paged,
                'mid_size' => 1,
                'add_args' => array_map('urlencode', $query_args),
                'prev_text' => '&larr; ' . __('Previous', 'blog-manager-wp'),
                'next_text' => __('Next', 'blog-manager-wp') . ' &rarr;',
                'type' => 'list',
            )
    );

    if ($links) :
        $navigation .= '<nav class="navigation paging-navigation" role="navigation">';
        $navigation .= $links;
        $navigation .= '</nav>';
    endif;
    return $navigation;
}

/**
 * Return page
 */
function pbsm_paged() {
    if (strstr($_SERVER['REQUEST_URI'], 'paged') || strstr($_SERVER['REQUEST_URI'], 'page')) {
        if (isset($_REQUEST['paged'])) {
            $paged = intval($_REQUEST['paged']);
        } else {
            $uri = explode('/', $_SERVER['REQUEST_URI']);
            $uri = array_reverse($uri);
            $paged = $uri[1];
        }
    } else {
        $paged = 1;
    }
    /* Pagination issue on home page */
    if (is_front_page()) {
        $paged = get_query_var('page') ? intval(get_query_var('page')) : 1;
    } else {
        $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    }

    return $paged;
}

/**
 * Start session if not
 */
function pbsm_session_start() {
    if (version_compare(phpversion(), '7.0.0') != -1) {
        if (session_status() == PHP_SESSION_DISABLED) {
            session_start(['read_and_close'  => true]);
        }
    } elseif (version_compare(phpversion(), '5.4.0') != -1) {
        if (session_status() == PHP_SESSION_DISABLED) {
            session_start();
        }
    } else {
        if (session_id() == '') {
            session_start();
        }
    }
}

/**
 * Remove read more
 */
function pbsm_remove_continue_reading($more) {
    return '';
}

/**
 * Display links
 */
function pbsm_plugin_links($links) {
    $pbsm_is_optin = get_option('pbsm_is_optin');
    if ($pbsm_is_optin == 'yes' || $pbsm_is_optin == 'no') {
        $start_page = 'pbsm_settings';
    } else {
        $start_page = 'pbsm_welcome_page';
    }
    $action_links = array(
        'settings' => '<a href="' . admin_url("admin.php?page=$start_page") . '" title="' . __('View Blog Manager Settings', 'blog-manager-wp') . '">' . __('Settings', 'blog-manager-wp') . '</a>',
    );
    $links = array_merge($action_links, $links);
    $links['documents'] = '';
    $links['upgrade'] = '';
    return $links;
}


/**
 * Fusion page builder support shortcode
 */
add_shortcode('pbsm_blog_managerWP', 'pbsm_bgm_shortcode');

function pbsm_bgm_shortcode($atts, $content) {
    ob_start();
    ?>
    <div class="bgm-bdp <?php echo bgm_style_params_class(esc_attr($atts)); ?>">
    <?php echo do_shortcode('[wp_pbsm]'); ?>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}

/**
 * Template search
 */
function pbsm_template_search_result() {
    $template_name = sanitize_text_field($_POST['temlate_name']);

    $tempate_list = pbsm_template_list();
    foreach ($tempate_list as $key => $value) {
        if ($template_name == '') {
            if ($key == 'grid-layout' || $key == 'default_slider' || $key == 'default_layout' || $key == 'center_top' || $key == 'timeline' || $key == 'news_feed') {
                $class = 'pbsm-lite';
            } else {
                $class = 'bp-pro';
            }
            ?>
            <div class="pbsm-template-thumbnail <?php echo esc_attr($value['class']) . ' ' . esc_attr($class); ?>">
                <div class="pbsm-template-thumbnail-inner">
                    <img src="<?php echo esc_url(PBSM_URL . 'assets/images/layouts/' . $value['image_name']); ?>" data-value="<?php echo esc_attr ($key); ?>" alt="<?php echo esc_attr($value['template_name']); ?>" title="<?php echo esc_attr($value['template_name']); ?>">
            <?php if ($class == 'pbsm-lite') { ?>
                        <div class="pbsm-hover_overlay">
                            <div class="pbsm-popup-template-name">
                                <div class="pbsm-popum-select"><a href="#"><?php _e('Select Template', 'blog-manager-wp'); ?></a></div>
                            </div>
                        </div>
            <?php } else { ?>
                        <div class="pbsm_overlay"></div>
                        <div class="pbsm-img-hover_overlay">
                            <img src="<?php echo esc_url(PBSM_URL . 'assets/images/pro-tag.png');?>" alt="Available in Pro" />
                        </div>
                        <div class="pbsm-hover_overlay">
                            <div class="pbsm-popup-template-name">
                            </div>
                        </div>
            <?php } ?>
                </div>
                <span class="pbsm-span-template-name"><?php echo esc_attr($value['template_name']); ?></span>
            </div>
            <?php
        } elseif (preg_match('/' . trim($template_name) . '/', $key)) {
            if ($key == 'grid-layout' || $key == 'default_slider' || $key == 'default_layout' || $key == 'center_top' || $key == 'timeline' || $key == 'news_feed') {
                $class = 'pbsm-lite';
            } else {
                $class = 'bp-pro';
            }
            ?>
            <div class="pbsm-template-thumbnail <?php echo esc_attr($value['class'] . ' ' . $class); ?>">
                <div class="pbsm-template-thumbnail-inner">
                    <img src="<?php echo esc_url(PBSM_URL . 'assets/images/layouts/' . $value['image_name']); ?>" data-value="<?php echo esc_attr ($key); ?>" alt="<?php echo esc_attr($value['template_name']); ?>" title="<?php echo esc_attr($value['template_name']); ?>">
            <?php if ($class == 'pbsm-lite') { ?>
                        <div class="pbsm-hover_overlay">
                            <div class="pbsm-popup-template-name">
                                <div class="pbsm-popum-select"><a href="#"><?php _e('Select Template', 'blog-manager-wp'); ?></a></div>
                            </div>
                        </div>
            <?php } else { ?>
                        <div class="pbsm_overlay"></div>
                        <div class="pbsm-img-hover_overlay">
                            <img src="<?php echo esc_url(PBSM_URL . 'assets/images/pro-tag.png'); ?>" alt="Available in Pro" />
                        </div>
                        <div class="pbsm-hover_overlay">
                            <div class="pbsm-popup-template-name">
                            </div>
                        </div>
            <?php } ?>
                </div>
                <span class="pbsm-span-template-name"><?php echo esc_attr($value['template_name']); ?></span>
            </div>
            <?php
        }
    }
    exit();
}

/**
 * Get content in posts
 */
function pbsm_get_content($postid) {
    global $post;
    $content = '';
    $excerpt_length = get_option('excerpt_length');
    $display_html_tags = get_option('display_html_tags', true);
    if (get_option('rss_use_excerpt') == 0) {
        $content = apply_filters('the_content', get_the_content($postid));
    } elseif (get_option('excerpt_length') > 0) {

        if ($display_html_tags == 1) {
            $text = get_the_content($postid);
            if (strpos(_x('words', 'Word count type. Do not translate!', 'blog-manager-wp'), 'characters') === 0 && preg_match('/^utf\-?8$/i', get_option('blog_charset'))) {
                $text = trim(preg_replace("/[\n\r\t ]+/", ' ', $text), ' ');
                preg_match_all('/./u', $text, $words_array);
                $words_array = array_slice($words_array[0], 0, $excerpt_length + 1);
                $sep = '';
            } else {
                $words_array = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
                $sep = ' ';
            }
            if (count($words_array) > $excerpt_length) {
                array_pop($words_array);
                $text = implode($sep, $words_array);
                $bp_excerpt_data = $text;
            } else {
                $bp_excerpt_data = implode($sep, $words_array);
            }
            $first_letter = $bp_excerpt_data;
            if (preg_match('#(>|]|^)(([A-Z]|[a-z]|[0-9]|[\p{L}])(.*\R)*(\R)*.*)#m', $first_letter, $matches)) {
                $top_content = str_replace($matches[2], '', $first_letter);
                $content_change = ltrim($matches[2]);
                $bp_content_first_letter = mb_substr($content_change, 0, 1);
                if (mb_substr($content_change, 1, 1) === ' ') {
                    $bp_remaining_letter = ' ' . mb_substr($content_change, 2);
                } else {
                    $bp_remaining_letter = mb_substr($content_change, 1);
                }
                $spanned_first_letter = '<span class="bp-first-letter">' . $bp_content_first_letter . '</span>';
                $bottom_content = $spanned_first_letter . $bp_remaining_letter;
                $bp_excerpt_data = $top_content . $bottom_content;
                $bp_excerpt_data = pbsm_close_tags($bp_excerpt_data);
            }
            $content = apply_filters('the_content', $bp_excerpt_data);
        } else {
            $text = $post->post_content;
            $text = str_replace('<!--more-->', '', $text);
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]&gt;', $text);
            $bp_excerpt_data = wp_trim_words($text, $excerpt_length, '');
            $bp_excerpt_data = apply_filters('wp_pbsm_excerpt_change', $bp_excerpt_data, $postid);
            $content = $bp_excerpt_data;
        }
    }
    return $content;
}

/**
 * Get html close tag
 */
function pbsm_close_tags($html = '') {
    if ($html == '') {
        return;
    }
    // put all opened tags into an array
    preg_match_all('#<([a-z]+)( .*)?(?!/)>#iU', $html, $result);
    $openedtags = $result[1];
    // put all closed tags into an array
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    // all tags are closed
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    // close tags
    for ($i = 0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            $html .= '</' . $openedtags[$i] . '>';
        } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
}

/**
 * Create sample layout of blog
 */
function pbsm_create_sample_layout() {
    $page_id = '';
    $blog_page_id = wp_insert_post(
            array(
                'post_title' => __('Test Blog Page', 'blog-manager-wp'),
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_content' => '[wp_pbsm]',
            )
    );
    if ($blog_page_id) {
        $page_id = $blog_page_id;
    }
    update_option('blog_page_display', $page_id);
    $post_link = get_permalink($page_id);
    echo esc_html($post_link);
    exit;
}

/**
 * Submit optin data
 */
add_action('wp_ajax_pbsm_submit_optin', 'pbsm_submit_optin');

function pbsm_submit_optin() {
    global $wpdb, $wp_version;
    $pbsm_submit_type = '';
    if (isset($_POST['email'])) {
        $pbsm_email = sanitize_email($_POST['email']);
    } else {
        $pbsm_email = get_option('admin_url');
    }
    if (isset($_POST['type'])) {
        $pbsm_submit_type = sanitize_text_field($_POST['type']);
    }
    if ($pbsm_submit_type == 'submit') {
        $status_type = get_option('pbsm_is_optin');
        $theme_details = array();
        if ($wp_version >= 3.4) {
            $active_theme = wp_get_theme();
            $theme_details['theme_name'] = strip_tags($active_theme->name);
            $theme_details['theme_version'] = strip_tags($active_theme->version);
            $theme_details['author_url'] = strip_tags($active_theme->{'Author URI'});
        }
        $active_plugins = (array) get_option('active_plugins', array());
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        $plugins = array();
        if (count($active_plugins) > 0) {
            $get_plugins = array();
            foreach ($active_plugins as $plugin) {
                $plugin_data = @get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);

                $get_plugins['plugin_name'] = strip_tags($plugin_data['Name']);
                $get_plugins['plugin_author'] = strip_tags($plugin_data['Author']);
                $get_plugins['plugin_version'] = strip_tags($plugin_data['Version']);
                array_push($plugins, $get_plugins);
            }
        }

        $plugin_data = get_plugin_data(PBSM_DIR . 'blog-manager.php', $markup = true, $translate = true);
        $current_version = $plugin_data['Version'];

        $plugin_data = array();
        $plugin_data['plugin_name'] = 'Blog Manager';
        $plugin_data['plugin_slug'] = 'blog-manager-wp';
        $plugin_data['plugin_version'] = $current_version;
        $plugin_data['plugin_status'] = $status_type;
        $plugin_data['site_url'] = home_url();
        $plugin_data['site_language'] = defined('WPLANG') && WPLANG ? WPLANG : get_locale();
        $current_user = wp_get_current_user();
        $f_name = $current_user->user_firstname;
        $l_name = $current_user->user_lastname;
        $plugin_data['site_user_name'] = esc_attr($f_name) . ' ' . esc_attr($l_name);
        $plugin_data['site_email'] = false !== $pbsm_email ? $pbsm_email : get_option('admin_email');
        $plugin_data['site_wordpress_version'] = $wp_version;
        $plugin_data['site_php_version'] = esc_attr(phpversion());
        $plugin_data['site_mysql_version'] = $wpdb->db_version();
        $plugin_data['site_max_input_vars'] = ini_get('max_input_vars');
        $plugin_data['site_php_memory_limit'] = ini_get('max_input_vars');
        $plugin_data['site_operating_system'] = ini_get('memory_limit') ? ini_get('memory_limit') : 'N/A';
        $plugin_data['site_extensions'] = get_loaded_extensions();
        $plugin_data['site_activated_plugins'] = $plugins;
        $plugin_data['site_activated_theme'] = $theme_details;
        $url = '#';
        $response = wp_safe_remote_post(
                $url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array(
                'data' => maybe_serialize($plugin_data),
                'action' => 'plugin_analysis_data',
            ),
                )
        );
        update_option('pbsm_is_optin', 'yes');
    } elseif ($pbsm_submit_type == 'cancel') {
        update_option('pbsm_is_optin', 'no');
    } elseif ($pbsm_submit_type == 'deactivate') {
        $status_type = get_option('pbsm_is_optin');
        $theme_details = array();
        if ($wp_version >= 3.4) {
            $active_theme = wp_get_theme();
            $theme_details['theme_name'] = strip_tags($active_theme->name);
            $theme_details['theme_version'] = strip_tags($active_theme->version);
            $theme_details['author_url'] = strip_tags($active_theme->{'Author URI'});
        }
        $active_plugins = (array) get_option('active_plugins', array());
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        $plugins = array();
        if (count($active_plugins) > 0) {
            $get_plugins = array();
            foreach ($active_plugins as $plugin) {
                $plugin_data = @get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
                $get_plugins['plugin_name'] = strip_tags($plugin_data['Name']);
                $get_plugins['plugin_author'] = strip_tags($plugin_data['Author']);
                $get_plugins['plugin_version'] = strip_tags($plugin_data['Version']);
                array_push($plugins, $get_plugins);
            }
        }

        $plugin_data = get_plugin_data(PBSM_DIR . 'blog-manager.php', $markup = true, $translate = true);
        $current_version = $plugin_data['Version'];

        $plugin_data = array();
        $plugin_data['plugin_name'] = 'Blog Manager';
        $plugin_data['plugin_slug'] = 'blog-manager-wp';
        $reason_id = sanitize_text_field($_POST['selected_option_de']);
        $plugin_data['deactivation_option'] = $reason_id;
        $plugin_data['deactivation_option_text'] = sanitize_text_field($_POST['selected_option_de_text']);
        if ($reason_id == 9) {
            $plugin_data['deactivation_option_text'] = sanitize_text_field($_POST['selected_option_de_other']);
        }
        $plugin_data['plugin_version'] = $current_version;
        $plugin_data['plugin_status'] = $status_type;
        $plugin_data['site_url'] = home_url();
        $plugin_data['site_language'] = defined('WPLANG') && WPLANG ? WPLANG : get_locale();
        $current_user = wp_get_current_user();
        $f_name = $current_user->user_firstname;
        $l_name = $current_user->user_lastname;
        $plugin_data['site_user_name'] = esc_attr($f_name) . ' ' . esc_attr($l_name);
        $plugin_data['site_email'] = false !== $pbsm_email ? $pbsm_email : get_option('admin_email');
        $plugin_data['site_wordpress_version'] = $wp_version;
        $plugin_data['site_php_version'] = esc_attr(phpversion());
        $plugin_data['site_mysql_version'] = $wpdb->db_version();
        $plugin_data['site_max_input_vars'] = ini_get('max_input_vars');
        $plugin_data['site_php_memory_limit'] = ini_get('max_input_vars');
        $plugin_data['site_operating_system'] = ini_get('memory_limit') ? ini_get('memory_limit') : 'N/A';
        $plugin_data['site_extensions'] = get_loaded_extensions();
        $plugin_data['site_activated_plugins'] = $plugins;
        $plugin_data['site_activated_theme'] = $theme_details;
        $url = '#';
        $response = wp_safe_remote_post(
                $url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array(
                'data' => maybe_serialize($plugin_data),
                'action' => 'plugin_analysis_data_deactivate',
            ),
                )
        );
        update_option('pbsm_is_optin', '');
    }
    exit();
}
?>
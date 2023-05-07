<?php

add_action('admin_enqueue_scripts', 'pbsm_admin_stylesheet', 7);
add_action('wp_enqueue_scripts', 'pbsm_front_stylesheet');
add_action('admin_enqueue_scripts', 'pbsm_enqueue_color_picker', 9);


/**
 * Enqueue admin panel required css
 */
function pbsm_admin_stylesheet() {
    $screen = get_current_screen();
    $plugin_data = get_plugin_data(PBSM_DIR . 'blog-manager.php', $markup = true, $translate = true);
    $current_version = $plugin_data['Version'];
    $old_version = get_option('pbsm_version');
    if ($old_version != $current_version) {
        update_option('is_user_subscribed_cancled', '');
        update_option('pbsm_version', $current_version);
    }
    if (( get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes' ) || ( $screen->base == 'plugins' )) {
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
    }
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-slider');

    wp_register_style('wp-pbsm-admin-support-stylesheets', PBSM_URL . 'assets/css/blog_manager_wp_editor_support.css');
    wp_enqueue_style('wp-pbsm-admin-support-stylesheets');
	wp_enqueue_style('wp-pbsm-switcher',PBSM_URL.'assets/css/switcher.css',false,'');

    if (( isset($_GET['page']) && ( $_GET['page'] == 'pbsm_settings' || $_GET['page'] == 'pbsm_getting_started' || $_GET['page'] == 'pbsm_welcome_page' ) ) || $screen->id == 'dashboard' || $screen->id == 'plugins') {

        $adminstylesheetURL = PBSM_URL . 'assets/css/admin.css';
        $adminrtlstylesheetURL = PBSM_URL . 'assets/css/admin-rtl.css';
        $adminstylesheet = PBSM_DIR . 'assets/css/admin.css';
        if (file_exists($adminstylesheet)) {
            wp_register_style('wp-pbsm-admin-stylesheets', $adminstylesheetURL);
            wp_enqueue_style('wp-pbsm-admin-stylesheets');
        }

        if (is_rtl()) {
            wp_register_style('wp-pbsm-admin-rtl-stylesheets', $adminrtlstylesheetURL);
            wp_enqueue_style('wp-pbsm-admin-rtl-stylesheets');
        }

        $adminstylechosenURL = PBSM_URL . 'assets/css/chosen.min.css';
        $adminstylechosen = PBSM_DIR . 'assets/css/chosen.min.css';
        if (file_exists($adminstylechosen)) {
            wp_register_style('wp-pbsm-chosen-stylesheets', $adminstylechosenURL);
            wp_enqueue_style('wp-pbsm-chosen-stylesheets');
        }

        if (isset($_GET['page']) && $_GET['page'] == 'pbsm_settings') {
            $adminstylearistoURL = PBSM_URL . 'assets/css/aristo.css';
            $adminstylearisto = PBSM_DIR . 'assets/css/aristo.css';
            if (file_exists($adminstylearisto)) {
                wp_register_style('wp-pbsm-aristo-stylesheets', $adminstylearistoURL);
                wp_enqueue_style('wp-pbsm-aristo-stylesheets');
            }
        }

        $fontawesomeiconURL = PBSM_URL . 'assets/css/fontawesome-all.min.css';
        $fontawesomeicon = PBSM_DIR . 'assets/css/fontawesome-all.min.css';
        if (file_exists($fontawesomeicon)) {
            wp_register_style('wp-pbsm-fontawesome-stylesheets', $fontawesomeiconURL);
            wp_enqueue_style('wp-pbsm-fontawesome-stylesheets');
        }
    }
}

/**
 * Enqueue front side required css
 */
function pbsm_front_stylesheet() {
    $fontawesomeiconURL = PBSM_URL . 'assets/css/fontawesome-all.min.css';
    $fontawesomeicon = PBSM_DIR . 'assets/css/fontawesome-all.min.css';
    
    if (file_exists($fontawesomeicon)) {
        wp_register_style('wp-pbsm-fontawesome-stylesheets', $fontawesomeiconURL);
        wp_enqueue_style('wp-pbsm-fontawesome-stylesheets');
    }
    $pbsm_layouts_cssURL = PBSM_URL . 'assets/css/pbsm_layouts_css.css';
    $designerrtl_cssURL = PBSM_URL . 'assets/css/designerrtl_css.css';
    $pbsm_layouts_css = PBSM_DIR . 'assets/css/pbsm_layouts_css.css';
    if (file_exists($pbsm_layouts_css)) {
        wp_register_style('wp-pbsm-css-stylesheets', $pbsm_layouts_cssURL);
        wp_enqueue_style('wp-pbsm-css-stylesheets');
    }
    if (is_rtl()) {
        wp_register_style('wp-pbsm-rtl-css-stylesheets', $designerrtl_cssURL);
        wp_enqueue_style('wp-pbsm-rtl-css-stylesheets');
    }
    wp_enqueue_script('jquery');
    wp_enqueue_script('wp-pbsm-script', PBSM_URL . 'assets/js/designer.js', '', false, true);
    $settings = get_option('wp_blog_pbsm_settings');
    if (isset($settings['template_name']) && $settings['template_name'] == 'default_slider') {
        $pbsm_gallery_sliderURL = PBSM_URL . 'assets/css/flexslider.css';
        $pbsm_gallery_slider = PBSM_DIR . '/assets/css/flexslider.css';
        if (file_exists($pbsm_gallery_slider)) {
            wp_enqueue_style('pbsm-galleryslider-stylesheets', $pbsm_gallery_sliderURL);
        }
        wp_enqueue_script('pbsm-galleryimage-script', PBSM_URL . 'assets/js/jquery.flexslider-min.js', '', false, true);
    }
}

/**
 * Enqueue colorpicket and chosen
 */
function pbsm_enqueue_color_picker($hook_suffix) {
    // first check that $hook_suffix is appropriate for your admin page
    if (isset($_GET['page']) && ( $_GET['page'] == 'pbsm_settings' || $_GET['page'] == 'pbsm_getting_started' || $_GET['page'] == 'pbsm_welcome_page' ) || $hook_suffix == 'plugins.php') {
        global $wp_version;
        wp_enqueue_style(array('wp-color-picker', 'wp-jquery-ui-dialog'));
        if (function_exists('wp_enqueue_code_editor')) {
            wp_enqueue_code_editor(array('type' => 'text/css'));
        }
        wp_enqueue_script('my-script-handle', PBSM_URL . 'assets/js/admin_script.js', array('wp-color-picker', 'jquery-ui-core', 'jquery-ui-dialog'), false, true);
        wp_localize_script(
                'my-script-handle', 'bdlite_js', array(
                    'wp_version' => $wp_version,
                    'nothing_found' => __('Oops, nothing found!', 'blog-manager-wp'),
                    'reset_data' => __('Do you want to reset data?', 'blog-manager-wp'),
                    'choose_blog_template' => __('Select the blog Layout you like', 'blog-manager-wp'),
                    'close' => __('Close', 'blog-manager-wp'),
                    'set_blog_template' => __('Set Blog Template', 'blog-manager-wp'),
                    'default_style_template' => __('Apply default style of this selected template', 'blog-manager-wp'),
                    'no_template_exist' => __('No template exist for selection', 'blog-manager-wp'),
                )
        );
        wp_enqueue_script('my-chosen-handle', PBSM_URL . 'assets/js/chosen.jquery.js');
    }
}
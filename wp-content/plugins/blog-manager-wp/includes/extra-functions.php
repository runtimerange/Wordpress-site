<?php

add_action('vc_before_init', 'pbsm_add_vc_support');

add_action('init', 'pbsm_bgm_block', 12);


/**
 * Gutenberg block for PBSM shortcode
 */
if (function_exists('register_block_type')) {
    require_once PBSM_DIR . 'includes/pbsm_block/index.php';
}


/**
 * Add support for visual composer
 */
function pbsm_add_vc_support() {
    vc_map(
            array(
                'name' => esc_html__('Blog Manager', 'blog-manager-wp'),
                'base' => 'wp_pbsm',
                'class' => 'blog_manager_section',
                'show_settings_on_create' => false,
                'category' => esc_html__('Content'),
                'icon' => 'blog_manager_icon',
                'description' => __('Custom Blog Layout', 'blog-manager-wp'),
            )
    );
}

/**
 * Fusion page builder support
 */
function pbsm_bgm_block() {
    if (function_exists('bgm_map')) {
        bgm_map(
                array(
                    'name' => __('Blog Manager', 'blog-manager-wp'),
                    'shortcode_tag' => 'pbsm_blog_managerWP',
                    'description' => __('To make your blog design more pretty, attractive and colorful.', 'blog-manager-wp'),
                    'icon' => 'bgm_blog',
                )
        );
    }
}


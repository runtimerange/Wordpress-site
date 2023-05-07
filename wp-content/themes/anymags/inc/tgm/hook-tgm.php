<?php
/**
 * Recommended plugins
 *
 * @package Anymags
 */

if ( ! function_exists( 'anymags_recommended_plugins' ) ) :

    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function anymags_recommended_plugins() {

        $plugins = array(
			array(
                'name'     => esc_html__( 'Blog Manager', 'anymags' ),
                'slug'     => 'blog-manager-wp',
                'required' => false,
            ),
			array(
                'name'     => esc_html__( 'News Gallery', 'anymags' ),
                'slug'     => 'photo-gallery-builder',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Accordion Slider Gallery', 'anymags' ),
                'slug'     => 'accordion-slider-gallery',
                'required' => false,
            ),
			array(
                'name'     => esc_html__( 'Timeline', 'anymags' ),
                'slug'     => 'timeline-event-history',
                'required' => false,
            ),
        );

        tgmpa( $plugins );

    }

endif;

add_action( 'tgmpa_register', 'anymags_recommended_plugins' );
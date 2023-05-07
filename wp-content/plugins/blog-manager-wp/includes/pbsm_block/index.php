<?php

function pbsm_callback() {
	return do_shortcode( '[wp_pbsm]' );
}

add_action( 'init', 'pbsm_register_block' );

function pbsm_register_block() {
	wp_register_script(
		'pbsm_block_js',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
	);
	register_block_type(
		'post-blog-showcase-manager/post-blog-showcase-manager-block',
		array(
			'editor_script'   => 'pbsm_block_js',
			'render_callback' => 'pbsm_callback',
		)
	);
}

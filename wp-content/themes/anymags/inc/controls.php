<?php

/**
 * excerpt lenth.
 */
function anymags_custom_excerpt_length(){

	$length=get_theme_mod('anymags_excerpt_length','55');
	if ( is_admin() ){
		$length =get_theme_mod('anymags_excerpt_length','55');
	} 
	return $length;
}
add_filter( 'excerpt_length', 'anymags_custom_excerpt_length');

function anymags_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function anymags_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}
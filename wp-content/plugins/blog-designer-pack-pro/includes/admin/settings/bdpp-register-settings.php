<?php
/**
 * Register Settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Plugin register settings
 * Handles to register plugin settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_register_settings() {
	register_setting( 'bdpp_settings', 'bdpp_opts', 'bdpp_validate_settings' );
}

// Action to register settings
add_action( 'admin_init', 'bdpp_register_settings' );

/**
 * Handles to validate plugin settings before updation
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_validate_settings( $input ) {
	
	global $bdpp_options;
	
	if ( empty( $_POST['_wp_http_referer'] ) ) {
		return $input;
	}
	
	$input = $input ? $input : array();
	
	parse_str( $_POST['_wp_http_referer'], $referrer );
	$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';
	
	// Sanitize filter according to tab
	if( $tab ) {
		$input = apply_filters( 'bdpp_validate_settings_' . $tab, $input );
	}
	
	// General sanitize filter
	$input = apply_filters( 'bdpp_validate_settings', $input );
	
	// Merge our new settings with the existing
	$output = array_merge( $bdpp_options, $input );

	do_action( 'bdpp_validate_settings', $input, $tab );
	do_action( 'bdpp_validate_common_settings', $input, $tab, 'bdpp' );

	return $output;
}

/**
 * Plugin Settings Tab array
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_settings_tab() {
	
	$result_arr = array();

	$settings_arr = apply_filters('bdpp_settings_tab', array(
							'general'	=> __('General', 'blog-designer-pack'),
							'trending'	=> __('Trending Post', 'blog-designer-pack'),
							'taxonomy'	=> __('Taxonomy', 'blog-designer-pack'),
							'sharing'	=> __('Sharing', 'blog-designer-pack'),
							'css'		=> __('CSS', 'blog-designer-pack'),
							'misc'		=> __('Misc', 'blog-designer-pack'),
						));

	foreach ($settings_arr as $sett_key => $sett_val) {
		if( !empty($sett_key) && !empty($sett_val) ) {
			$result_arr[trim($sett_key)] = trim($sett_val);
		}
	}

	return $result_arr;
}

/**
 * Plugin Setup (On First Time Activation)
 *
 * Does the initial setup when plugin is going to activate first time,
 * stest default values for the plugin options.
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_default_settings() {
	
	global $bdpp_options;
	
	$bdpp_options = array(
					'post_types'			=> array(0 => 'post'),
					'trend_post_types'		=> array(),
					'sharing_enable'		=> 0,
					'sharing'				=> array(),
					'sharing_lbl'			=> esc_html__('Share this', 'blog-designer-pack'),
					'sharing_design'		=> 'design-1',
					'sharing_post_types'	=> array(),
					'disable_font_awsm_css'	=> 0,
					'disable_owl_css'		=> 0,
					'custom_css'			=> '',
				);

	$default_options = apply_filters('bdpp_default_options_values', $bdpp_options );

	// Update default options
	update_option( 'bdpp_opts', $default_options );
	
	// Overwrite global variable when option is update
	$bdpp_options = bdpp_get_settings();
}

/**
 * Get Settings From Option Page
 * 
 * Handles to return all settings value
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_settings() {
	
	$options = get_option('bdpp_opts');
	
	$settings = (is_array($options)) ? $options : array();
	
	return $settings;
}

/**
 * Get an option
 *
 * Looks to see if the specified setting exists, returns default if not
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_option( $key = '', $default = false ) {
	global $bdpp_options;
	
	$value = !empty($bdpp_options[$key]) ? $bdpp_options[ $key ] : $default;
	$value = apply_filters( 'bdpp_get_option', $value, $key, $default );
	
	return apply_filters( 'bdpp_option_' . $key, $value, $key, $default );
}

/**
 * Handles to validate General tab settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_validate_general_settings( $input ) {

	$input['post_types'] = isset( $input['post_types'] ) ? bdpp_clean( $input['post_types'] ) : array();

	// check default post type
	if( ! in_array('post', $input['post_types']) ) {
		$input['post_types'][] = 'post';
	}

	return $input;
}
add_filter( 'bdpp_validate_settings_general', 'bdpp_validate_general_settings', 9, 1 );

/**
 * Handles to validate Trending tab settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_validate_trending_settings( $input ) {

	$input['trend_post_types'] = isset( $input['trend_post_types'] ) ? bdpp_clean( $input['trend_post_types'] ) : array();

	return $input;
}
add_filter( 'bdpp_validate_settings_trending', 'bdpp_validate_trending_settings', 9, 1 );

/**
 * Handles to validate Taxonomy tab settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_validate_taxonomy_settings( $input ) {

	$input['taxonomy'] = isset( $input['taxonomy'] ) ? bdpp_clean( $input['taxonomy'] ) : array();

	return $input;
}
add_filter( 'bdpp_validate_settings_taxonomy', 'bdpp_validate_taxonomy_settings', 9, 1 );

/**
 * Handles to validate Sharing tab settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_validate_sharing_settings( $input ) {

	// Taking some default value
	$sharing_service = array();

	// Validate Sharing Services
	if( !empty( $input['sharing'] ) ) {
		foreach ($input['sharing'] as $sharing_key => $sharing_val) {
			if( !empty( $sharing_val ) ) {
				$sharing_service[] = $sharing_val;
			}
		}
	}
	$input['sharing']				= array_unique( $sharing_service );
	$input['sharing_enable'] 		= !empty( $input['sharing_enable'] ) ? 1 : 0;
	$input['sharing_post_types']	= isset( $input['sharing_post_types'] ) ? bdpp_clean( $input['sharing_post_types'] ) : array();

	return $input;
}
add_filter( 'bdpp_validate_settings_sharing', 'bdpp_validate_sharing_settings', 9, 1 );

/**
 * Handles to validate CSS tab settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_validate_css_settings( $input ) {

	$input['custom_css'] = isset($input['custom_css']) ? sanitize_textarea_field( $input['custom_css'] ) : '';

	return $input;
}
add_filter( 'bdpp_validate_settings_css', 'bdpp_validate_css_settings', 9, 1 );

/**
 * Handles to validate Misc tab settings
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_validate_misc_settings( $input ) {

	$input['disable_font_awsm_css'] = !empty($input['disable_font_awsm_css']) 	? 1 : 0;
	$input['disable_owl_css'] 		= !empty($input['disable_owl_css']) 		? 1 : 0;

	return $input;
}
add_filter( 'bdpp_validate_settings_misc', 'bdpp_validate_misc_settings', 9, 1 );
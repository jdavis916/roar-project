<?php
/**
 * Templates Functions
 *
 * Handles to manage templates of plugin
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 *
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Returns the path to the Deals templates directory
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_templates_dir() {
	return apply_filters( 'bdpp_template_dir', BDPP_DIR . '/templates/' );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 * 
 */
function bdpp_locate_template( $template_name, $template_path = '', $default_path = '', $default_template = '' ) {
	
	if ( ! $template_path ) $template_path = BDPP_BASENAME . '/';
	if ( ! $default_path ) $default_path = bdpp_get_templates_dir();
	
	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name
		)
	);
	
	// Get default plugin folder template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// If file not exist then take passed default template
	if( !file_exists($template) && !empty($default_template) ) {
		$template = $default_path . $default_template;
	}

	// Return what we found
	return apply_filters('bdpp_locate_template', $template, $template_name, $template_path);
}

/**
 * Get other templates (e.g. deals attributes) passing attributes and including the file.
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 * 
 */
function bdpp_get_template( $template_name, $template_args = array(), $default_template = '', $template_path = '', $default_path = '' ) {

	if ( $template_args && is_array($template_args) ) {
		extract( $template_args );
	}
	
	$located = bdpp_locate_template( $template_name, $template_path, $default_path, $default_template );
	
	do_action( 'bdpp_before_template_part', $template_name, $template_path, $located, $template_args );
	
	include( $located );
	
	do_action( 'bdpp_after_template_part', $template_name, $template_path, $located, $template_args );
}

/**
 * Function to return templates html
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 * 
 */
function bdpp_get_template_html( $template_name, $template_args = array(), $template_path = '', $default_path = '', $default_template = '' ) {
	
	ob_start();
	bdpp_get_template( $template_name, $template_args, $template_path, $default_path, $default_template );
	$html = ob_get_clean();
	
	return $html;
}

/**
 * Display social sharing on single pages
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_sharing_display( $content ) {
	global $post;

	if ( empty( $post ) ) {
		return $content;
	}

	if ( ( is_preview() || is_admin() || ! bdpp_sharing_enabled() ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		return $content;
	}

	// Taking some variables
	$gen_post_types		= bdpp_get_option( 'post_types', array() );
	$sharing_post_types = bdpp_get_option( 'sharing_post_types', array() );

	if ( is_singular() && is_main_query() && in_array( $post->post_type, $sharing_post_types ) && in_array( $post->post_type, $gen_post_types ) ) {
		$template_args = array(
								'sharing'		=> bdpp_get_option( 'sharing_design' ),
								'sharing_label'	=> bdpp_get_option( 'sharing_lbl' ),
							);

		$content .= bdpp_get_template_html( 'sharing.php', $template_args );
	}

	return $content;
}
add_filter( 'the_content', 'bdpp_sharing_display', 20 );
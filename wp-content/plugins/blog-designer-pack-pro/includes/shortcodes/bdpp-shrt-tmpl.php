<?php
/**
 * Shortcode Template Generator
 * `bdpp_tmpl` Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_shortcode_template( $atts, $content = null ) {

	global $bdpp_shortcode_tmpl;

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'id' => '',
	), $atts, 'bdpp_tmpl');

	$template_id = bdpp_clean_number( $atts['id'] );

	// Taking some variables
	$bdpp_shortcode_tmpl	= empty( $bdpp_shortcode_tmpl ) ? get_option( 'bdpp_shrt_tmpl' ) : $bdpp_shortcode_tmpl;
	$template_data			= ! empty( $bdpp_shortcode_tmpl[ $template_id ] ) ? $bdpp_shortcode_tmpl[ $template_id ] : false;

	ob_start();

	// If template exist
	if( $template_data ) {

		// If template is in live mode
		if( ! empty( $template_data['enable'] ) && ! empty( $template_data['shortcode'] ) ) {
			echo do_shortcode( $template_data['shortcode'] );
		}

	} else {
		esc_html_e( 'Sorry, Template does not exist.', 'blog-designer-pack' );
	}

	$content .= ob_get_clean();
	return $content;
}

// Shortcode Template Shortcode
add_shortcode('bdpp_tmpl', 'bdpp_render_shortcode_template');
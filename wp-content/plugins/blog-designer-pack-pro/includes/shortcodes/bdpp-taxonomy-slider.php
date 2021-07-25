<?php
/**
 * 'bdp_cat_slider' Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_taxonomy_slider( $atts, $content = null ) {

	// Shortcode Parameter
	$atts = shortcode_atts(array(
			'taxonomy'				=> 'category',
			'limit'					=> 12,
			'design'				=> 'design-1',
			'media_size'			=> 'bdpp-medium',
			'link'					=> 'true',
			'link_target'			=> 'self',
			'parent'				=> '',
			'child_of'				=> 0,
			'orderby'				=> 'name',
			'order'					=> 'ASC',
			'hide_empty'			=> 'true',
			'show_title'			=> 'true',
			'show_count'			=> 'true',
			'show_desc'				=> 'true',
			'include_cat'			=> array(),
			'exclude_cat'			=> array(),
			'offset'				=> null,
			
			'loop'					=> 'true',
			'slide_show'			=> 3,
			'slide_scroll'			=> 1,
			'slide_margin'			=> 20,
			'start_position'		=> 0,
			'stage_padding'			=> 0,
			'arrows'				=> 'true',
			'dots'					=> 'true',
			'lazyload'				=> 'false',
			'autoplay'				=> 'true',
			'autoplay_interval'		=> 5000,
			'speed'					=> 'false',
			'autoplay_hover_pause'	=> 'true',
			'url_hash_listener'		=> 'false',
			'prev_text'				=> "&#x2039;",
			'next_text'				=> "&#x203a;",
			'center'				=> 'false',
			'auto_height'			=> 'false',
			'style_id'				=> '',
			'css_class'				=> '',
			'custom_param_1'		=> '',	// Custom Param Passed Just for Developer
			'custom_param_2'		=> '',
	), $atts, 'bdp_cat_slider' );

	$taxonomy_designs 				= bdpp_taxonomy_designs();
	$atts['unique']					= bdpp_get_unique();
	$atts['shortcode']				= 'bdp_cat_slider';
	$atts['media_size']				= !empty( $atts['media_size'] ) 				? $atts['media_size']  					: 'bdpp-medium';
	$atts['taxonomy']				= !empty( $atts['taxonomy'] )					? trim( $atts['taxonomy'] )				: 'category';
	$atts['include_cat']			= !empty( $atts['include_cat'] ) 				? explode(',', $atts['include_cat']) 	: array();
	$atts['exclude_cat']			= !empty( $atts['exclude_cat'] )				? explode(',', $atts['exclude_cat'])	: array();
	$atts['order'] 					= ( strtolower($atts['order']) == 'asc' ) 		? 'ASC' 								: 'DESC';
	$atts['show_title']				= ( $atts['show_title'] == 'false' ) 			? false 								: true;
	$atts['show_count']				= ( $atts['show_count'] == 'false' ) 			? false 								: true;
	$atts['show_desc']				= ( $atts['show_desc'] == 'false' ) 			? false 								: true;
	$atts['hide_empty']				= ( $atts['hide_empty'] == 'false' ) 			? false 								: true;
	$atts['link']					= ( $atts['link'] == 'false' ) 					? false 								: true;
	$atts['link_target']			= ( $atts['link_target'] == 'blank' ) 			? '_blank' 								: '_self';
	$atts['design']					= ( $atts['design'] && (array_key_exists(trim($atts['design']), $taxonomy_designs)) ) ? trim($atts['design']) : 'design-1';
	$atts['limit']					= bdpp_clean_number( $atts['limit'], 0 );

	$atts['loop']					= ( $atts['loop'] == 'false' ) 					? false 					: true;
	$atts['arrows']					= ( $atts['arrows'] == 'false' ) 				? false 					: true;
	$atts['dots']					= ( $atts['dots'] == 'false' ) 					? false 					: true;
	$atts['autoplay']				= ( $atts['autoplay'] == 'false' ) 				? false 					: true;	
	$atts['center']					= ( $atts['center'] == 'true' ) 				? true 						: false;
	$atts['speed']					= ( $atts['speed'] == 'false' ) 				? false 					: bdpp_clean_number( $atts['speed'], 0 );
	$atts['lazyload']				= ( $atts['lazyload'] == 'true' ) 				? true 						: false;
	$atts['auto_height']			= ( $atts['auto_height'] == 'true' ) 			? true 						: false;
	$atts['url_hash_listener']		= ( $atts['url_hash_listener'] == 'true' ) 		? true 						: false;
	$atts['autoplay_hover_pause']	= ( $atts['autoplay_hover_pause'] == 'false' ) 	? false 					: true;
	$atts['nav_text']				= array( $atts['prev_text'], $atts['next_text'] );
	$atts['lazy_cls']				= ( $atts['lazyload'] ) ? "owl-lazy" : '';
	$atts['slide_show']				= bdpp_clean_number( $atts['slide_show'], 3 );
	$atts['slide_scroll']			= bdpp_clean_number( $atts['slide_scroll'], 1 );
	$atts['autoplay_interval']		= bdpp_clean_number( $atts['autoplay_interval'], 5000 );
	$atts['slide_margin']			= bdpp_clean_number( $atts['slide_margin'], 5 );
	$atts['start_position']			= bdpp_clean_number( $atts['start_position'], 0 );
	$atts['stage_padding']			= bdpp_clean_number( $atts['stage_padding'], 0 );
	$atts['css_class']				.= ! empty( $atts['style_id'] ) ? " bdpp-style-mngr-{$atts['style_id']}" : '';	
	$atts['css_class']				.= ( $atts['arrows'] ) ? ' bdpp-has-arrows' : '';
	$atts['css_class']				= bdpp_sanitize_html_classes( $atts['css_class'] );

	extract( $atts );

	// Taking some variables
	$prefix 			= BDPP_META_PREFIX;
	$atts['count'] 		= 0;
	$general_post_types = bdpp_get_option( 'post_types', array() );
	$allowed_taxonomy	= bdpp_get_option( 'taxonomy', array() );
	$taxonomy_post		= isset( $allowed_taxonomy[ $taxonomy ] ) ? $allowed_taxonomy[ $taxonomy ] : '';

	// If category is not enabled from setting
	if( ! in_array( $taxonomy_post, $general_post_types) ) {
		return $content;
	}

	// Little tweak when offset is present and limit is set to show all then override limit with big number
	// To make offset work
	if( $offset && $limit == 0 ) {
		$limit = 9999;
	}

	// Enqueue required scripts
	wp_enqueue_script( 'jquery-owl-carousel' );
	wp_enqueue_script( 'bdpp-public-script' );
	bdpp_enqueue_script();

	// Taxonomy Arguments
	$cat_args = array(			
				'taxonomy'		=> $taxonomy,
				'number'		=> $limit,
				'orderby'		=> $orderby,
				'order'			=> $order,
				'include'		=> $include_cat,
				'exclude'		=> $exclude_cat,
				'hide_empty'	=> $hide_empty,
				'parent'		=> $parent,
				'child_of'		=> $child_of,
				'offset'		=> $offset,
				'hierarchical'	=> ( ! $child_of && '' === $parent ) ? false : true,
		);
	$cat_args = apply_filters( 'bdpp_cat_slider_query_args', $cat_args, $atts );
	$cat_args = apply_filters( 'bdpp_cat_query_args', $cat_args, $atts );

	$query_taxonomy = get_terms( $cat_args );

	ob_start();

	if ( ! is_wp_error( $query_taxonomy ) && ! empty( $query_taxonomy ) ) {

		// Some slider calculation
		$found_taxonomy = count( $query_taxonomy );
		$loop			= ( $loop && $slide_show > $found_taxonomy ) ? false : $loop;

		// Slider configuration
		$atts['slider_conf'] = compact('slide_show', 'loop', 'slide_margin', 'start_position', 'arrows', 'dots', 'autoplay', 'autoplay_interval', 'speed', 'autoplay_hover_pause', 'nav_text', 'lazyload', 'url_hash_listener', 'stage_padding', 'center', 'slide_scroll', 'auto_height');

		bdpp_generate_style( $style_id, 'shortcode', 'slider', 'bdp_cat_slider', $atts );

		bdpp_get_template( 'taxonomy/slider/loop-start.php', $atts );

			foreach ( $query_taxonomy as $taxonomy_key => $taxonomy_data ) {

				$atts['count'] 			= ( $atts['count'] + 1 );
				$atts['term_data']		= $taxonomy_data;
				$atts['term_img_id']	= get_term_meta( $taxonomy_data->term_id, $prefix.'term_img_id', true );
				$atts['term_icon']		= get_term_meta( $taxonomy_data->term_id, $prefix.'term_icon', true );
				$atts['term_bg_clr']	= get_term_meta( $taxonomy_data->term_id, $prefix.'term_bg_clr', true );
				$atts['term_link']		= bdpp_get_term_link( $taxonomy_data );
				$atts['term_image']		= bdpp_get_image_url( $atts['term_img_id'], $media_size );
				$atts['hash_listener']	= ( $url_hash_listener ) ? "data-hash={$atts['count']}-{$unique}" : '';

				$atts['wrp_cls']		= "bdpp-term-slider bdpp-term-slide-{$slide_show} bdpp-cat-{$taxonomy_data->term_id}";
				$atts['wrp_cls']		.= empty( $atts['term_image'] ) ? ' bdpp-no-thumb' : '';

				// Creating image style
				if( $atts['term_image'] && ! $lazyload ) {
					$atts['image_style'] = 'style="background-image:url('.esc_url( $atts['term_image'] ).');"';
				} else if( $atts['term_image'] && $lazyload ) {
					$atts['image_style'] = 'data-src="'.$atts['term_image'].'"';
				} else {
					$atts['image_style'] = '';
				}
				
				// Creating image overlaycolor or bg color
				if( $atts['term_bg_clr'] &&  $atts['term_image'] ) {
					$atts['bg_color'] = 'background-color: rgba('.bdpp_hex2rgb($atts['term_bg_clr'] ).',0.5);';
				} else if( $atts['term_bg_clr']) {
					$atts['bg_color'] = 'background-color: rgb('.bdpp_hex2rgb($atts['term_bg_clr'] ).');';
				} else {
					$atts['bg_color'] = '';
				}

				// Include Dsign File
				bdpp_get_template( "taxonomy/slider/{$design}.php", $atts );
			}

		bdpp_get_template( 'taxonomy/slider/loop-end.php', $atts );
	}

	$content .= ob_get_clean();
	return $content;
}

// Taxonomy Slider Shortcode
add_shortcode( 'bdp_cat_slider', 'bdpp_render_taxonomy_slider' );
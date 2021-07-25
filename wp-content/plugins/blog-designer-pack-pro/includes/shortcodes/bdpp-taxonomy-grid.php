<?php
/**
 * 'bdp_cat_grid' Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_taxonomy_grid( $atts, $content = null ) {

	// Shortcode Parameter
	$atts = shortcode_atts(array(
			'taxonomy'			=> 'category',
			'limit'				=> 12,
			'grid'				=> 3,
			'design'			=> 'design-1',
			'media_size'		=> 'bdpp-medium',
			'link'				=> 'true',
			'link_target'		=> 'self',
			'parent'			=> '',
			'child_of'			=> 0,
			'orderby'			=> 'name',
			'order'				=> 'ASC',
			'hide_empty'		=> 'true',
			'show_title'		=> 'true',
			'show_count'		=> 'true',
			'show_desc'			=> 'true',
			'include_cat'		=> array(),
			'exclude_cat'		=> array(),
			'offset'			=> null,
			'pagination'		=> 'true',
			'pagination_type' 	=> 'numeric',
			'prev_text'			=> "&laquo; " . esc_html__('Previous', 'blog-designer-pack'),
			'next_text'			=> esc_html__('Next', 'blog-designer-pack') . " &raquo;",
			'style_id'			=> '',
			'css_class'			=> '',
			'custom_param_1'	=> '',	// Custom Param Passed Just for Developer
			'custom_param_2'	=> '',
	), $atts, 'bdp_cat_grid');

	$taxonomy_designs			= bdpp_taxonomy_designs();
	$atts['shortcode']			= 'bdp_cat_grid';
	$atts['limit']				= bdpp_clean_number( $atts['limit'], 0 );
	$atts['grid']				= bdpp_clean_number( $atts['grid'], 3 );
	$atts['grid']				= ( $atts['grid'] <= 12 ) ? $atts['grid'] : 3;
	$atts['taxonomy']			= !empty( $atts['taxonomy'] )					? trim( $atts['taxonomy'] )				: 'category';
	$atts['media_size']			= !empty( $atts['media_size'] ) 				? $atts['media_size']  					: 'bdpp-medium';
	$atts['include_cat']		= !empty( $atts['include_cat'] ) 				? explode(',', $atts['include_cat']) 	: array();
	$atts['exclude_cat']		= !empty( $atts['exclude_cat'] )				? explode(',', $atts['exclude_cat'])	: array();
	$atts['order'] 				= ( strtolower($atts['order']) == 'asc' ) 		? 'ASC' 								: 'DESC';
	$atts['show_title']			= ( $atts['show_title'] == 'false' ) 			? false 								: true;
	$atts['show_count']			= ( $atts['show_count'] == 'false' ) 			? false 								: true;
	$atts['show_desc']			= ( $atts['show_desc'] == 'false' ) 			? false 								: true;
	$atts['hide_empty']			= ( $atts['hide_empty'] == 'false' ) 			? false 								: true;
	$atts['pagination'] 		= ($atts['pagination'] == 'false')				? false									: true;
	$atts['link']				= ( $atts['link'] == 'false' ) 					? false 								: true;
	$atts['link_target']		= ( $atts['link_target'] == 'blank' ) 			? '_blank' 								: '_self';
	$atts['design']				= ( $atts['design'] && (array_key_exists(trim($atts['design']), $taxonomy_designs)) ) ? trim($atts['design']) : 'design-1';
	$atts['paged']				= !empty( $_GET['bdpp-term-page'] ) ? bdpp_clean_number( $_GET['bdpp-term-page'], 1 ) : 1;
	$atts['css_class']			.= ! empty( $atts['style_id'] ) ? " bdpp-style-mngr-{$atts['style_id']}" : '';
	$atts['css_class']			= bdpp_sanitize_html_classes( $atts['css_class'] );
	$atts['term_total']			= 0;

	extract( $atts );

	// Taking some variables
	$prefix				= BDPP_META_PREFIX;
	$count				= 0;
	$general_post_types = bdpp_get_option( 'post_types', array() );
	$allowed_taxonomy	= bdpp_get_option( 'taxonomy', array() );
	$taxonomy_post		= isset( $allowed_taxonomy[ $taxonomy ] ) ? $allowed_taxonomy[ $taxonomy ] : '';

	// If category is not enabled from setting
	if( ! in_array( $taxonomy_post, $general_post_types) ) {
		return $content;
	}

	// Enqueue required scripts
	if( $pagination_type == 'load-more' || $pagination_type == 'prev-next-ajax' || $pagination_type == 'infinite' ) {
		wp_enqueue_script( 'bdpp-public-script' );
	}
	bdpp_enqueue_script();

	// Little tweak when offset is present and limit is set to show all then override limit with big number
	// To make offset work
	if( $offset && $limit == 0 ) {
		$limit = 9999;
	}

	// Taking care of query offset with pagination
	if( $pagination && $paged > 1 ) {
		$offset = $offset + ( ($paged - 1) * $limit );
	}

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
	$cat_args = apply_filters( 'bdpp_cat_grid_query_args', $cat_args, $atts );
	$cat_args = apply_filters( 'bdpp_cat_query_args', $cat_args, $atts );

	$query_taxonomy = get_terms( $cat_args );

	ob_start();

	if ( ! is_wp_error( $query_taxonomy ) && ! empty( $query_taxonomy ) ) {

		// If pagination is there then take count of all match terms
		if( $pagination && $limit > 0 && $limit != 9999 ) {
			$cat_args['number']	= 0;
			$cat_args['fields'] = !empty( $child_of ) ? 'ids' : 'count';
			$pagi_cats			= get_terms( $cat_args );
			
			$atts['term_total']	= ! is_array( $pagi_cats ) ? $pagi_cats : count( $pagi_cats );
		}

		bdpp_generate_style( $style_id, 'shortcode', 'grid', 'bdp_cat_grid', $atts );

		bdpp_get_template( 'taxonomy/grid/loop-start.php', $atts );

		foreach ( $query_taxonomy as $taxonomy_key => $taxonomy_data ) {

			$count++;
			$atts['count']			= $count;
			$atts['term_data']		= $taxonomy_data;
			$atts['term_img_id']	= get_term_meta( $taxonomy_data->term_id, $prefix.'term_img_id', true );
			$atts['term_icon']		= get_term_meta( $taxonomy_data->term_id, $prefix.'term_icon', true );
			$atts['term_bg_clr']	= get_term_meta( $taxonomy_data->term_id, $prefix.'term_bg_clr', true );
			$atts['term_link']		= bdpp_get_term_link( $taxonomy_data );
			$atts['term_image']		= bdpp_get_image_url( $atts['term_img_id'], $media_size );

			$atts['wrp_cls']		= "bdpp-term-grid bdpp-col-{$grid} bdpp-columns bdpp-cat-{$taxonomy_data->term_id}";
			$atts['wrp_cls']		.= ( $count % $grid == 1 ) ? ' bdpp-first' : '';
			$atts['wrp_cls']		.= empty( $atts['term_image'] ) ? ' bdpp-no-thumb' : '';

			// Creating image style
			if( $atts['term_image'] ) {
				$atts['image_style'] = 'style="background-image:url('.esc_url( $atts['term_image'] ).');"';
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

			// Design Template
			bdpp_get_template( "taxonomy/grid/{$design}.php", $atts );
		}

		// Unset some unnecessary data (Not required at outside of loop)
		unset( $atts['term_data'] );

		bdpp_get_template( 'taxonomy/grid/loop-end.php', $atts );
	}

	$content .= ob_get_clean();
	return $content;
}

// Taxonomy Grid Shortcode
add_shortcode( 'bdp_cat_grid', 'bdpp_render_taxonomy_grid' );
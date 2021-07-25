<?php
/**
 * `bdp_ticker` Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_post_ticker( $atts, $content = null ) {

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'post_type'				=> BDPP_POST_TYPE,
		'taxonomy'				=> BDPP_CAT,
		'type'					=> '',
		'limit' 				=> 20,
		'ticker_title'			=> esc_html__('Latest Post', 'blog-designer-pack'),
		'theme_color'			=> '#2096cd',
		'heading_font_color'	=> '#fff',
		'font_color'			=> '#2096cd',
		'ctrl_bg_color'			=> '#f6f6f6',
		'ctrl_bgh_color'		=> '#eeeeee',
		'ctrl_txt_color'		=> '#999999',		
		'ctrl_txth_color'		=> '#999999',
		'font_style'			=> 'normal',
		'ticker_effect'			=> 'slide-up', // slide-left, slide-down, slide-up, slide-right, scroll, typography, fade,
		'arrows'				=> 'true',
		'pause_button'			=> 'true',
		'autoplay'				=> 'true',
		'speed'					=> 3000,
		'scroll_speed'          => 2,
		'height'                => 40,
		'position'              => 'auto', //fixed-bottom, fixed-top
		'hover_stop'            => 'true',
		'show_title_in_mobile'  => 'true',
		'hide_ctrl_in_mobile'   => 'true',
		'link_behaviour'		=> 'self',
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'category' 				=> array(),
		'exclude_cat'			=> array(),
		'category_operator'		=> 'IN',
		'include_cat_child'		=> 'true',
		'posts'					=> array(),
		'hide_post'        		=> array(),
		'author' 				=> array(),
		'exclude_author'		=> array(),
		'sticky_posts'			=> 'false',
		'query_offset'			=> '',
		'css_class'				=> '',
		'custom_param_1'		=> '',	// Custom Param Passed Just for Developer
		'custom_param_2'		=> '',
	), $atts, 'bdp_ticker');

	$allowed_post_types			= ( $atts['type'] == 'trending' ) ? bdpp_get_option( 'trend_post_types', array() ) : bdpp_get_option( 'post_types', array() );
	$atts['shortcode']			= 'bdp_ticker';
	$atts['post_type']			= !empty( $atts['post_type'] )				? explode( ',', $atts['post_type'] )	: array( BDPP_POST_TYPE );
	$atts['theme_color']		= !empty( $atts['theme_color'] )			? $atts['theme_color']					: '#2096cd';
	$atts['font_color']			= !empty( $atts['font_color'] )				? $atts['font_color']					: '#2096cd';
	$atts['heading_font_color']	= !empty( $atts['heading_font_color'] )		? $atts['heading_font_color']			: '#fff';
	$atts['ctrl_bg_color']		= !empty( $atts['ctrl_bg_color'] )			? $atts['ctrl_bg_color']				: '#f6f6f6';
	$atts['ctrl_bgh_color']		= !empty( $atts['ctrl_bgh_color'] )			? $atts['ctrl_bgh_color']				: '#eeeeee';
	$atts['ctrl_txt_color']		= !empty( $atts['ctrl_txt_color'] )			? $atts['ctrl_txt_color']				: '#999999';
	$atts['ctrl_txth_color']	= !empty( $atts['ctrl_txth_color'] )		? $atts['ctrl_txth_color']				: '#999999';
	$atts['ticker_effect']		= !empty( $atts['ticker_effect'] )			? $atts['ticker_effect']				: 'slide-up';
	$atts['link_behaviour']		= ( $atts['link_behaviour'] == 'new' )		? '_blank'								: '_self';	
	$atts['position']			= !empty( $atts['position'] )				? $atts['position']						: 'auto';
	$atts['autoplay']			= ( $atts['autoplay'] == 'false' ) 			? false 								: true;
	$atts['hover_stop']			= ( $atts['hover_stop'] == 'false' ) 		? false 								: true;
	$atts['arrows']				= ( $atts['arrows'] == 'false' ) 			? false 								: true;
	$atts['pause_button']		= ( $atts['pause_button'] == 'false' ) 		? false 								: true;
	$atts['height']				= bdpp_clean_number( $atts['height'], 40 );
	$atts['speed']				= bdpp_clean_number( $atts['speed'], 3000 );
	$atts['scroll_speed']		= bdpp_clean_number( $atts['scroll_speed'], 2 );
	$atts['show_title_in_mobile'] = ( $atts['show_title_in_mobile'] == 'false' ) 		? false 					: true;
	$atts['hide_ctrl_in_mobile']  = ( $atts['hide_ctrl_in_mobile'] == 'false' ) 		? false 					: true;

	$atts['limit'] 				= bdpp_clean_number( $atts['limit'], 20, 'number' );
	$atts['order'] 				= ( strtolower($atts['order']) == 'asc' ) 	? 'ASC' 								: 'DESC';
	$atts['orderby'] 			= !empty( $atts['orderby'] )				? $atts['orderby'] 						: 'date';
	$atts['category'] 			= !empty( $atts['category'] )				? explode(',', $atts['category']) 		: array();
	$atts['exclude_cat']		= !empty( $atts['exclude_cat'] )			? explode(',', $atts['exclude_cat'])	: array();
	$atts['include_cat_child']	= ( $atts['include_cat_child'] == 'false' )	? false 								: true;
	$atts['posts']				= !empty( $atts['posts'] )					? explode(',', $atts['posts']) 			: array();
	$atts['hide_post']			= !empty( $atts['hide_post'] )				? explode(',', $atts['hide_post']) 		: array();
	$atts['author']				= !empty( $atts['author'] )					? explode(',', $atts['author']) 		: array();
	$atts['exclude_author']		= !empty( $atts['exclude_author'] )			? explode(',', $atts['exclude_author']) : array();
	$atts['sticky_posts'] 		= ($atts['sticky_posts'] == 'false')		? true									: false;
	$atts['query_offset']		= !empty( $atts['query_offset'] )			? $atts['query_offset'] 				: null;
	$atts['css_class']			= bdpp_sanitize_html_classes( $atts['css_class'] );
	$atts['unique'] 			= bdpp_get_unique();

	extract( $atts );

	// Taking some globals
	global $post;

	// Enqueue required scripts
	wp_enqueue_script( 'bdpp-ticker-script' );
	wp_enqueue_script( 'bdpp-public-script' );
	bdpp_enqueue_script();

	// Taking some variables
	$prefix 				= BDPP_META_PREFIX;
	$post_type_arr			= array();
	$atts['ticker_conf']	= compact('ticker_effect', 'autoplay', 'speed', 'hover_stop', 'position', 'height', 'scroll_speed');

	// Processing post types
	if( !empty( $post_type ) ) {
		foreach ($post_type as $post_key => $post_val) {
			
			$post_val = bdpp_clean( $post_val );
			
			if( in_array( $post_val, $allowed_post_types ) ) {
				$post_type_arr[] = $post_val;
			}
		}
		$post_type_arr		= array_unique( $post_type_arr );
		$atts['post_type']	= $post_type_arr;
	}

	// WP Query Parameters
	$args = array(
		'post_type'      		=> $post_type_arr,
		'post_status' 			=> array('publish'),
		'order'          		=> $order,
		'orderby'        		=> $orderby,
		'posts_per_page' 		=> $limit,
		'post__in'		 		=> $posts,
		'post__not_in'	 		=> $hide_post,
		'author__in'        	=> $author,
		'author__not_in' 		=> $exclude_author,		
		'offset'				=> $query_offset,
		'no_found_rows'			=> true,
		'ignore_sticky_posts'	=> $sticky_posts,
	);

	// Category Parameter
	if( $category ) {

		$args['tax_query'] = array(
								array( 
									'taxonomy' 			=> $taxonomy,
									'terms' 			=> $category,
									'operator'			=> $category_operator,
									'include_children'	=> $include_cat_child,
									'field' 			=> ( isset($category[0]) && is_numeric($category[0]) ) ? 'term_id' : 'slug',
								));

	} else if( $exclude_cat ) {
		
		$args['tax_query'] = array(
									array(
										'taxonomy' 			=> $taxonomy,
										'terms' 			=> $exclude_cat,
										'operator'			=> 'NOT IN',
										'include_children'	=> $include_cat_child,
										'field' 			=> ( isset($exclude_cat[0]) && is_numeric($exclude_cat[0]) ) ? 'term_id' : 'slug',
									));
	}

	// For featured post
	if( $type == 'featured' ) {

		$args['meta_query'] = array(
									array(
										'key'	=> $prefix.'feat_post',
										'value'	=> 1,
									),
								);

	} else if( $type == 'trending' ) {

		$args['orderby'] 	= ( $orderby == 'post_views' ) ? 'meta_value_num' : $orderby;
		$args['meta_query'] = array(
									array(
										'key'		=> $prefix.'post_views',
										'value'		=> 0,
										'compare' 	=> '>',
									),
								);
	}

	$args = apply_filters( 'bdpp_ticker_query_args', $args, $atts );
	$args = apply_filters( 'bdpp_posts_query_args', $args, $atts );

	// WP Query
	$query = new WP_Query( $args );

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {

		bdpp_get_template( 'ticker/loop-start.php', $atts );

    	while ( $query->have_posts() ) : $query->the_post();

    		$atts['format']		= bdpp_get_post_format();

    		$atts['post_link']	= bdpp_get_post_link( $post->ID );
    		$atts['wrp_cls']	= "bdpp-post-{$post->ID} bdpp-post-{$atts['format']}";
    		$atts['wrp_cls']	.= ( is_sticky( $post->ID ) ) 	? ' bdpp-sticky'	: '';

        	// Include shortcode html file
			bdpp_get_template( "ticker/design-1.php", $atts );

		endwhile;

		bdpp_get_template( 'ticker/loop-end.php', $atts );

	} // End of have_post()

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// Post Ticker Shortcode
add_shortcode('bdp_ticker', 'bdpp_render_post_ticker');
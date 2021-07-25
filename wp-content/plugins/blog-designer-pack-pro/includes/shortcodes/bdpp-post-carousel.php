<?php
/**
 * 'bdp_post_carousel' Post Grid Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `bdp_post_carousel` shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_render_post_carousel( $atts, $content = null )  {

    // Shortcode Parameters
	$atts = shortcode_atts(array(
		'post_type'				=> BDPP_POST_TYPE,
		'taxonomy'				=> BDPP_CAT,
		'cat_taxonomy'			=> '',
		'tag_taxonomy'			=> 'post_tag',
		'type'					=> '',
		'limit' 				=> 20,
		'design' 				=> 'design-1',
		'show_author' 			=> 'true',
		'show_tags'				=> 'false',
		'show_comments'			=> 'true',
		'show_category' 		=> 'true',
		'show_content' 			=> 'false',
		'show_date' 			=> 'true',
		'media_size' 			=> 'bdpp-medium',
		'content_words_limit' 	=> 20,
		'show_read_more' 		=> 'true',
		'read_more_text'		=> '',
		'link_behaviour'		=> 'self',
		'sharing'				=> '',
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

		'loop'					=> 'true',
		'slide_show'            => 3,
		'slide_scroll'			=> 1,
		'slide_margin'			=> 20,
		'start_position'		=> 0,
		'stage_padding'			=> 0,
		'arrows'				=> 'true',
		'dots' 					=> 'true',
		'lazyload'				=> 'false',
		'autoplay'				=> 'true',
		'autoplay_interval'		=> 5000,
		'speed' 				=> 'false',
		'autoplay_hover_pause'	=> 'true',
		'url_hash_listener'		=> 'false',
		'prev_text'				=> "&#x2039;",
		'next_text'				=> "&#x203a;",
		'center'				=> 'false',
		'auto_height'			=> 'false',
		'style_id'				=> '',
		'custom_param_1'		=> '',	// Custom Param Passed Just for Developer
		'custom_param_2'		=> '',
		), $atts, 'bdp_post_carousel');

	$shortcode_designs 				= bdpp_post_carousel_designs();
	$sharing_designs				= bdpp_sharing_designs();
	$allowed_post_types				= ( $atts['type'] == 'trending' ) ? bdpp_get_option( 'trend_post_types', array() ) : bdpp_get_option( 'post_types', array() );
	$atts['shortcode']				= 'bdp_post_carousel';
	$atts['post_type']				= !empty( $atts['post_type'] ) 				? explode( ',', $atts['post_type'] ): array( BDPP_POST_TYPE );
	$atts['cat_taxonomy']			= !empty( $atts['cat_taxonomy'] )			? $atts['cat_taxonomy'] 			: $atts['taxonomy'];
	$atts['limit'] 					= bdpp_clean_number( $atts['limit'], 20, 'number' );
	$atts['show_author'] 			= ($atts['show_author'] == 'false')			? false								: true;
	$atts['show_tags'] 				= ( $atts['show_tags'] == 'false' ) 		? false								: true;
	$atts['show_comments'] 			= ( $atts['show_comments'] == 'false' ) 	? false								: true;
	$atts['show_date'] 				= ( $atts['show_date'] == 'false' ) 		? false	 							: true;
	$atts['show_category'] 			= ( $atts['show_category'] == 'false' ) 	? false 							: true;
	$atts['show_content'] 			= ( $atts['show_content'] == 'false' ) 		? false 							: true;
	$atts['media_size'] 			= (!empty($atts['media_size']))				? $atts['media_size'] 				: 'large';
	$atts['content_words_limit'] 	= !empty( $atts['content_words_limit'] ) 	? $atts['content_words_limit'] 		: 20;
	$atts['show_read_more'] 		= ( $atts['show_read_more'] == 'false' )	? false 							: true;
	$atts['read_more_text']			= !empty( $atts['read_more_text'] )			? $atts['read_more_text']			: esc_html__( 'Read More', 'blog-designer-pack' );
	$atts['order'] 					= ( strtolower($atts['order']) == 'asc' ) 	? 'ASC' 							: 'DESC';
	$atts['orderby'] 				= !empty( $atts['orderby'] )				? $atts['orderby'] 					: 'date';
	$atts['category'] 				= !empty( $atts['category'] )				? explode(',', $atts['category']) 	: array();
	$atts['exclude_cat']			= !empty( $atts['exclude_cat'] )			? explode(',', $atts['exclude_cat']): array();
	$atts['include_cat_child']		= ( $atts['include_cat_child'] == 'false' )	? false 							: true;
	$atts['posts']					= !empty( $atts['posts'] )					? explode(',', $atts['posts']) 		: array();
	$atts['hide_post']				= !empty( $atts['hide_post'] )				? explode(',', $atts['hide_post']) 	: array();
	$atts['author']					= !empty( $atts['author'] )					? explode(',', $atts['author']) 	: array();
	$atts['exclude_author']			= !empty( $atts['exclude_author'] )			? explode(',', $atts['exclude_author']) : array();
	$atts['sticky_posts'] 			= ($atts['sticky_posts'] == 'false')		? true									: false;
	$atts['query_offset']			= !empty( $atts['query_offset'] )			? $atts['query_offset'] 				: null;
	$atts['link_behaviour']			= ( $atts['link_behaviour'] == 'new' )		? '_blank'								: '_self';

	$atts['loop']					= ( $atts['loop'] == 'false' ) 					? false 	: true;
	$atts['arrows']					= ( $atts['arrows'] == 'false' ) 				? false 	: true;
	$atts['dots']					= ( $atts['dots'] == 'false' ) 					? false 	: true;
	$atts['autoplay']				= ( $atts['autoplay'] == 'false' ) 				? false 	: true;	
	$atts['center']					= ( $atts['center'] == 'true' ) 				? true 		: false;
	$atts['speed']					= ( $atts['speed'] == 'false' ) 				? false 	: bdpp_clean_number( $atts['speed'], 0 );
	$atts['lazyload']				= ( $atts['lazyload'] == 'true' ) 				? true 		: false;
	$atts['auto_height']			= ( $atts['auto_height'] == 'true' ) 			? true 		: false;
	$atts['url_hash_listener']		= ( $atts['url_hash_listener'] == 'true' ) 		? true 		: false;
	$atts['autoplay_hover_pause']	= ( $atts['autoplay_hover_pause'] == 'false' ) 	? false 	: true;
	$atts['nav_text']				= array( $atts['prev_text'], $atts['next_text'] );
	$atts['slide_show']				= bdpp_clean_number( $atts['slide_show'], 2 );
	$atts['slide_scroll']			= bdpp_clean_number( $atts['slide_scroll'], 1 );
	$atts['autoplay_interval']		= bdpp_clean_number( $atts['autoplay_interval'], 5000 );
	$atts['slide_margin']			= bdpp_clean_number( $atts['slide_margin'], 5 );
	$atts['start_position']			= bdpp_clean_number( $atts['start_position'], 0 );
	$atts['stage_padding']			= bdpp_clean_number( $atts['stage_padding'], 0 );

	$atts['design'] 				= ( $atts['design'] && (array_key_exists(trim($atts['design']), $shortcode_designs)) ) ? trim( $atts['design'] )	: 'design-1';
	$atts['sharing'] 				= ( $atts['sharing'] && (array_key_exists(trim($atts['sharing']), $sharing_designs)) ) ? trim( $atts['sharing'] )	: false;
	$atts['lazy_cls']				= ( $atts['lazyload'] ) ? "owl-lazy" : '';
	$atts['css_class']				.= ! empty( $atts['style_id'] ) ? " bdpp-style-mngr-{$atts['style_id']}" : '';
	$atts['css_class']				.= ( $atts['arrows'] ) ? ' bdpp-has-arrows' : '';
	$atts['css_class']				= bdpp_sanitize_html_classes( $atts['css_class'] );
	$atts['unique'] 				= bdpp_get_unique();

	extract( $atts );

	// Taking some variables
	$prefix 				= BDPP_META_PREFIX;
	$post_type_arr			= array();
	$atts['count'] 			= 0;
	$atts['slider_conf'] 	= compact('slide_show', 'loop', 'slide_margin', 'start_position', 'arrows', 'dots', 'autoplay', 'autoplay_interval', 'speed', 'autoplay_hover_pause', 'nav_text', 'lazyload', 'url_hash_listener', 'stage_padding', 'center', 'slide_scroll', 'auto_height');

	// Taking some globals
	global $post;

	// Enqueue required scripts
	if( $sharing ) {
		wp_enqueue_script( 'tooltipster' );
	}
	wp_enqueue_script( 'jquery-owl-carousel' );
	wp_enqueue_script( 'bdpp-public-script' );
	bdpp_enqueue_script();

	// Processing post types
	if( !empty( $post_type ) ) {
		foreach ($post_type as $post_key => $post_val) {
			
			$post_val = bdpp_clean( $post_val );
			
			if( in_array( $post_val, $allowed_post_types ) ) {
				$post_type_arr[] = $post_val;
			}
		}
		$post_type_arr = array_unique( $post_type_arr );
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

	$args = apply_filters( 'bdpp_post_carousel_query_args', $args, $atts );
	$args = apply_filters( 'bdpp_posts_query_args', $args, $atts );

	// WP Query
	$query = new WP_Query( $args );

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {

			bdpp_generate_style( $style_id, 'shortcode', 'slider', 'bdp_post_carousel', $atts );
			
			bdpp_get_template( 'carousel/loop-start.php', $atts );

			while ( $query->have_posts() ) : $query->the_post();

				$atts['count'] 			= ( $atts['count'] + 1 );
				$atts['format']			= bdpp_get_post_format();
				$atts['feat_img'] 		= bdpp_get_post_feat_image( $post->ID, $media_size, true );
				$atts['post_link'] 		= bdpp_get_post_link( $post->ID );
				$atts['cate_name'] 		= bdpp_get_post_terms( $post->ID, $cat_taxonomy );				
				$atts['tags']  		    = ($show_tags) ? bdpp_post_meta_data( array('tag' => $show_tags), array('tag_taxonomy' => $tag_taxonomy) ) : '';
				$atts['hash_listener']	= ( $url_hash_listener ) ? "data-hash={$atts['count']}-{$unique}" : '';
				
				$atts['wrp_cls']		= "bdpp-post-{$post->ID} bdpp-post-{$atts['format']}";
				$atts['wrp_cls']		.= ( is_sticky( $post->ID ) ) 	? ' bdpp-sticky'	: '';
				$atts['wrp_cls'] 		.= empty($atts['feat_img'])		? ' bdpp-no-thumb'	: ' bdpp-has-thumb';

				// Creating image style
				if( $atts['feat_img'] && ! $lazyload ) {
					$atts['image_style'] = 'style="background-image:url('.esc_url( $atts['feat_img'] ).');"';
				} else if( $atts['feat_img'] && $lazyload ) {
					$atts['image_style'] = 'data-src="'.$atts['feat_img'].'"';
				} else {
					$atts['image_style'] = '';
				}

	            // Include shortcode html file
				bdpp_get_template( "carousel/{$design}.php", $atts );

			endwhile;

			bdpp_get_template( 'carousel/loop-end.php', $atts );
		
	} // end of have_post()

	wp_reset_postdata(); // Reset WP Query

    $content .= ob_get_clean();
    return $content;
}

// Post carousel Shortcode
add_shortcode( 'bdp_post_carousel', 'bdpp_render_post_carousel' );
<?php
/**
 * Post Creative Design 1 Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `bdp_post_ctv1` shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_render_post_creative_1( $atts, $content = null )  {

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'post_type'				=> BDPP_POST_TYPE,
		'taxonomy'				=> BDPP_CAT,
		'cat_taxonomy'			=> '',
		'type'					=> '',
		'limit' 				=> 9,
		'grid' 					=> 3,
		'show_author' 			=> 'true',
		'show_comments'			=> 'true',
		'show_category' 		=> 'true',
		'show_date' 			=> 'true',
		'link_behaviour'		=> 'self',
		'sharing'				=> '',
		'media_size' 			=> 'full',
		'lazyload'				=> 'true',
		'order'					=> 'DESC',
		'orderby'				=> 'date',
		'category' 				=> array(),
		'exclude_cat'			=> array(),
		'category_operator'		=> 'IN',
		'include_cat_child'		=> 'true',
		'posts'					=> array(),
		'hide_post'				=> array(),
		'author' 				=> array(),
		'exclude_author'		=> array(),
		'sticky_posts'			=> 'false',
		'query_offset'			=> '',
		'css_class'				=> '',
		'slider_screen'			=> 640,
		'custom_param_1'		=> '',	// Custom Param Passed Just for Developer
		'custom_param_2'		=> '',
		), $atts, 'bdp_post_ctv1');

	$sharing_designs				= bdpp_sharing_designs();
	$allowed_post_types				= ( $atts['type'] == 'trending' ) ? bdpp_get_option( 'trend_post_types', array() ) : bdpp_get_option( 'post_types', array() );
	$atts['shortcode']				= 'bdp_post_ctv1';
	$atts['limit'] 					= bdpp_clean_number( $atts['limit'], 9, 'number' );
	$atts['grid']					= bdpp_clean_number( $atts['grid'], 3 );
	$atts['grid']					= ( $atts['grid'] <= 12 ) ? $atts['grid'] : 3;
	$atts['post_type']				= !empty( $atts['post_type'] )				? explode( ',', $atts['post_type'] )	: array( BDPP_POST_TYPE );
	$atts['cat_taxonomy']			= !empty( $atts['cat_taxonomy'] )			? $atts['cat_taxonomy'] 				: $atts['taxonomy'];
	$atts['show_author'] 			= ($atts['show_author'] == 'false')			? false									: true;
	$atts['show_comments'] 			= ( $atts['show_comments'] == 'false' ) 	? false									: true;
	$atts['show_date'] 				= ( $atts['show_date'] == 'false' ) 		? false	 								: true;
	$atts['show_category'] 			= ( $atts['show_category'] == 'false' ) 	? false 								: true;
	$atts['lazyload']				= ( $atts['lazyload'] == 'false' ) 			? false									: true;
	$atts['link_behaviour']			= ( $atts['link_behaviour'] == 'new' )		? '_blank'								: '_self';
	$atts['order'] 					= ( strtolower($atts['order']) == 'asc' ) 	? 'ASC' 								: 'DESC';
	$atts['orderby'] 				= !empty( $atts['orderby'] )				? $atts['orderby'] 						: 'date';
	$atts['category'] 				= !empty( $atts['category'] )				? explode(',', $atts['category']) 		: array();
	$atts['exclude_cat']			= !empty( $atts['exclude_cat'] )			? explode(',', $atts['exclude_cat'])	: array();
	$atts['include_cat_child']		= ( $atts['include_cat_child'] == 'false' )	? false 								: true;
	$atts['posts']					= !empty( $atts['posts'] )					? explode(',', $atts['posts']) 			: array();
	$atts['hide_post']				= !empty( $atts['hide_post'] )				? explode(',', $atts['hide_post']) 		: array();
	$atts['author']					= !empty( $atts['author'] )					? explode(',', $atts['author']) 		: array();
	$atts['exclude_author']			= !empty( $atts['exclude_author'] )			? explode(',', $atts['exclude_author']) : array();
	$atts['sticky_posts'] 			= ($atts['sticky_posts'] == 'false')		? true									: false;
	$atts['query_offset']			= !empty( $atts['query_offset'] )			? $atts['query_offset'] 				: null;	
	$atts['sharing'] 				= ( $atts['sharing'] && (array_key_exists(trim($atts['sharing']), $sharing_designs)) ) ? trim( $atts['sharing'] ) : false;
	$atts['slider_screen']			= bdpp_clean_number( $atts['slider_screen'], 640 );
	$atts['css_class']				= bdpp_sanitize_html_classes( $atts['css_class'] );
	$atts['unique'] 				= bdpp_get_unique();
	$atts['thumb_html']				= '';

	extract( $atts );

	// Taking some globals
	global $post;

	// Enqueue required scripts
	if( $sharing ) {
		wp_enqueue_script( 'tooltipster' );
	}
	wp_enqueue_script( 'jquery-owl-carousel' );
	wp_enqueue_script( 'bdpp-public-script' );
	bdpp_enqueue_script();

	// Taking some variables
	$count 			= 0;
	$post_type_arr	= array();
	$prefix 		= BDPP_META_PREFIX;

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

	$args = apply_filters( 'bdpp_post_ctv1_query_args', $args, $atts );
	$args = apply_filters( 'bdpp_posts_query_args', $args, $atts );

	// WP Query
	$query 					= new WP_Query( $args );
	$atts['max_num_pages'] 	= $query->max_num_pages;

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {

			bdpp_get_template( 'misc/creative-1/loop-start.php', $atts );

			while ( $query->have_posts() ) : $query->the_post();

				$count++;
				$atts['count'] 		= $count;
				$atts['format']		= bdpp_get_post_format();
				$atts['feat_img'] 	= bdpp_get_post_feat_image( $post->ID, $media_size, true );
				$atts['post_link'] 	= bdpp_get_post_link( $post->ID );
				$atts['cate_name'] 	= bdpp_get_post_terms( $post->ID, $cat_taxonomy );

				$atts['wrp_cls']	= "bdpp-col-nr-{$grid} bdpp-columns bdpp-post-{$atts['format']} bdpp-post-{$post->ID}";
				$atts['wrp_cls']	.= empty( $atts['feat_img'] )	? ' bdpp-no-thumb'	: '';
				$atts['wrp_cls']	.=	( is_sticky( $post->ID ) )	? ' bdpp-sticky'	: '';

	            // Include Dsign File
				bdpp_get_template( "misc/creative-1/creative-1.php", $atts );

				// Creating Thumb HTML
				if( $atts['feat_img'] ) {
					$thumb_active	= ( $count == 1 ) ? 'bdpp-post-ctv1-thumb-active' : '';
					$lazy_style		= ( ! $lazyload ) ? 'style="background-image:url('.$atts['feat_img'].');"' : '';
					
					if( $count == 1 ) {
						$atts['thumb_html'] .= '<div class="bdpp-post-ctv1-thumb bdpp-post-ctv1-thumb-'.$count .' '. $thumb_active.'" style="background-image:url('.$atts['feat_img'].');"></div>';
					} else {
						$atts['thumb_html'] .= '<div class="bdpp-post-ctv1-thumb bdpp-post-ctv1-thumb-'.$count .' '. $thumb_active.'" '.$lazy_style.'></div>';
					}
				}

			endwhile;

			bdpp_get_template( 'misc/creative-1/loop-end.php', $atts );

	} // end of have_post()

	wp_reset_postdata(); // Reset WP Query

	$content .= ob_get_clean();
	return $content;
}

// Creative Design 1 Shortcode
add_shortcode( 'bdp_post_ctv1', 'bdpp_render_post_creative_1' );
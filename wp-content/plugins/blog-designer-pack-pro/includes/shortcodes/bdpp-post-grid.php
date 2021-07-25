<?php
/**
 * 'bdp_post' Post Grid Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to handle the `bdp_post` shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_render_post_grid( $atts, $content = null )  {

	// Taking some globals
	global $post, $multipage;

	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'post_type'				=> BDPP_POST_TYPE,
		'taxonomy'				=> BDPP_CAT,
		'cat_taxonomy'			=> '',
		'tag_taxonomy'			=> 'post_tag',
		'type'					=> '',
		'limit' 				=> 20,
		'grid' 					=> 1,
		'design' 				=> 'design-1',
		'show_author' 			=> 'true',
		'show_tags'				=> 'true',
		'show_comments'			=> 'true',
		'show_category' 		=> 'true',
		'show_content' 			=> 'true',
		'show_date' 			=> 'true',
		'pagination' 			=> 'true',
		'pagination_type' 		=> 'numeric',
		'prev_text'				=> "&laquo; " . esc_html__('Previous', 'blog-designer-pack'),
		'next_text'				=> esc_html__('Next', 'blog-designer-pack') . " &raquo;",
		'media_size' 			=> '',
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
		'hide_post'				=> array(),
		'author' 				=> array(),
		'exclude_author'		=> array(),
		'sticky_posts'			=> 'false',
		'query_offset'			=> '',
		'css_class'				=> '',
		'style_id'				=> '',
		'custom_param_1'		=> '',	// Custom Param Passed Just for Developer
		'custom_param_2'		=> '',
		), $atts, 'bdp_post');

	$shortcode_designs 				= bdpp_post_designs();
	$sharing_designs				= bdpp_sharing_designs();
	$allowed_post_types				= ( $atts['type'] == 'trending' ) ? bdpp_get_option( 'trend_post_types', array() ) : bdpp_get_option( 'post_types', array() );
	$atts['shortcode']				= 'bdp_post';
	$atts['limit'] 					= bdpp_clean_number( $atts['limit'], 20, 'number' );
	$atts['grid']					= bdpp_clean_number( $atts['grid'], 1 );
	$atts['grid']					= ( $atts['grid'] <= 12 ) 					? $atts['grid'] 						: 1;
	$atts['post_type']				= !empty( $atts['post_type'] ) 				? explode( ',', $atts['post_type'] )	: array( BDPP_POST_TYPE );
	$atts['cat_taxonomy']			= !empty( $atts['cat_taxonomy'] )			? $atts['cat_taxonomy'] 				: $atts['taxonomy'];
	$atts['show_author'] 			= ($atts['show_author'] == 'false')			? false									: true;
	$atts['show_tags'] 				= ( $atts['show_tags'] == 'false' ) 		? false									: true;
	$atts['show_comments'] 			= ( $atts['show_comments'] == 'false' ) 	? false									: true;
	$atts['show_date'] 				= ( $atts['show_date'] == 'false' ) 		? false	 								: true;
	$atts['show_category'] 			= ( $atts['show_category'] == 'false' ) 	? false 								: true;
	$atts['show_content'] 			= ( $atts['show_content'] == 'false' ) 		? false 								: true;
	$atts['pagination'] 			= ($atts['pagination'] == 'false')			? false									: true;
	$atts['media_size'] 			= (!empty($atts['media_size']))				? $atts['media_size'] 					: '';
	$atts['media_size']				= ( $atts['grid'] > 1 && empty($atts['media_size']) ) ? 'bdpp-medium' 				: $atts['media_size'];
	$atts['content_words_limit'] 	= !empty( $atts['content_words_limit'] ) 	? $atts['content_words_limit'] 			: 20;
	$atts['show_read_more'] 		= ( $atts['show_read_more'] == 'false' )	? false 								: true;
	$atts['read_more_text']			= !empty( $atts['read_more_text'] )			? $atts['read_more_text']				: esc_html__( 'Read More', 'blog-designer-pack' );
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
	$atts['design'] 				= ($atts['design'] && (array_key_exists(trim($atts['design']), $shortcode_designs))) ? trim($atts['design']) : 'design-1';
	$atts['sharing'] 				= ( $atts['sharing'] && (array_key_exists(trim($atts['sharing']), $sharing_designs)) ) ? trim( $atts['sharing'] ) : false;
	$atts['multi_page']				= ( $multipage || is_single() ) ? 1 : 0;
	$atts['css_class']				.= ! empty( $atts['style_id'] ) ? " bdpp-style-mngr-{$atts['style_id']}" : '';
	$atts['css_class']				= bdpp_sanitize_html_classes( $atts['css_class'] );
	$atts['unique'] 				= bdpp_get_unique();

	extract( $atts );

	// Enqueue required scripts
	if( $sharing ) {
		wp_enqueue_script( 'tooltipster' );
	}
	if( $pagination_type == 'load-more' || $pagination_type == 'prev-next-ajax' || $pagination_type == 'infinite' || $pagination_type == 'numeric-ajax' || $sharing ) {
		wp_enqueue_script( 'bdpp-public-script' );
	}
	bdpp_enqueue_script();

	// Pagination parameter
	if( isset( $_GET['bdpp-page'] ) || $multi_page ) {
		$paged = isset( $_GET['bdpp-page'] ) ? $_GET['bdpp-page'] : 1;
	} elseif ( get_query_var( 'paged' ) ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}

	// Taking some variables
	$atts['paged']	= $paged;
	$count 			= 0;
	$prefix 		= BDPP_META_PREFIX;
	$post_type_arr	= array();

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

	// Taking care of query offset with pagination
	if( $query_offset && $pagination && $paged > 1 ) {
		$offset = $query_offset + ( ($paged - 1) * $limit );
	} else {
		$offset = $query_offset;
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
		'paged'          		=> ( $pagination ) ? $paged : 1,
		'offset'				=> $offset,
		'no_found_rows'			=> ( ! $pagination ) ? true : false,
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

	$args = apply_filters( 'bdpp_post_query_args', $args, $atts );
	$args = apply_filters( 'bdpp_posts_query_args', $args, $atts );

	// WP Query
	$query 					= new WP_Query( $args );
	$atts['max_num_pages'] 	= $query->max_num_pages;

	// Taking care of pagination with query offset
	if( $pagination && $query_offset ) {
		$found_posts = ( $query->found_posts - $query_offset );
		$atts['max_num_pages'] = ceil( $found_posts / $limit );
	}

	ob_start();

	// If post is there
	if ( $query->have_posts() ) {

			bdpp_generate_style( $style_id, 'shortcode', 'grid', 'bdp_post', $atts );

			bdpp_get_template( 'grid/loop-start.php', $atts );

			while ( $query->have_posts() ) : $query->the_post();

				$count++;
				$atts['count'] 		= $count;
				$atts['format']		= bdpp_get_post_format();
				$atts['feat_img'] 	= bdpp_get_post_feat_image( $post->ID, $media_size, true );
				$atts['post_link'] 	= bdpp_get_post_link( $post->ID );
				$atts['cate_name'] 	= bdpp_get_post_terms( $post->ID, $cat_taxonomy );
				$atts['tags']  		= ( $show_tags ) ? bdpp_post_meta_data( array('tag' => $show_tags), array('tag_taxonomy' => $tag_taxonomy) ) : '';

				$atts['wrp_cls'] = "bdpp-col-{$grid} bdpp-columns bdpp-post-{$post->ID} bdpp-post-{$atts['format']}";
				$atts['wrp_cls'] .=	( is_sticky( $post->ID ) )	? ' bdpp-sticky'	: '';
				$atts['wrp_cls'] .= ( $count % $grid  == 1 )	? ' bdpp-first'		: '';
				$atts['wrp_cls'] .= empty($atts['feat_img'])	? ' bdpp-no-thumb'	: ' bdpp-has-thumb';

	            // Include Dsign File
				bdpp_get_template( "grid/{$design}.php", $atts );

			endwhile;

			bdpp_get_template( 'grid/loop-end.php', $atts );

	} // end of have_post()

	wp_reset_postdata(); // Reset WP Query

    $content .= ob_get_clean();
    return $content;
}

// Post Grid Shortcode
add_shortcode( 'bdp_post', 'bdpp_render_post_grid' );
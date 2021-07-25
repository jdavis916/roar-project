<?php
/**
 * Public Class
 *
 * Handles the public side functionality of plugin
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class BDPP_Public {

	function __construct() {

		// Ajax call to update post count
		add_action( 'wp_ajax_bdpp_trending_post_count', array( $this, 'bdpp_trending_post_count') );
		add_action( 'wp_ajax_nopriv_bdpp_trending_post_count',array( $this, 'bdpp_trending_post_count') );

		// Load More Post via Ajax
		add_action( 'wp_ajax_bdpp_load_more_posts', array($this, 'bdpp_load_more_posts') );
		add_action( 'wp_ajax_nopriv_bdpp_load_more_posts', array($this, 'bdpp_load_more_posts') );

		// Load More Terms via Ajax
		add_action( 'wp_ajax_bdpp_load_more_terms', array($this, 'bdpp_load_more_terms') );
		add_action( 'wp_ajax_nopriv_bdpp_load_more_terms', array($this, 'bdpp_load_more_terms') );
	}

	/**
	 * Update trending post count
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_trending_post_count() {
		
		$prefix		= BDPP_META_PREFIX;
		$post_id 	= isset( $_POST['post_id'] ) ? bdpp_clean_number( $_POST['post_id'] ) : '';
		
		if( !empty( $post_id ) ) {
			
			// Getting existing views
			$views = get_post_meta( $post_id, $prefix.'post_views', true );
			$views = !empty( $views ) ? $views : 0;

			// Update view
			update_post_meta( $post_id, $prefix.'post_views', ($views+1) );

			$result['success'] = 1;
		} else {
			$result['success'] = 0;
		}
		wp_send_json($result);
	}

	/**
	 * Load More Posts via Ajax
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_load_more_posts() {

		// Taking the shortocde parameters
		$atts = json_decode( wp_unslash($_POST['shrt_param']), true );
		extract( $atts );

		$result = array(
					'status'	=> 0,
					'msg'		=> esc_html__( 'Sorry, Something happened wrong.', 'blog-designer-pack' ),
				);
		$prefix				= BDPP_META_PREFIX;
		$paged				= isset( $_POST['paged'] )				? bdpp_clean_number( $_POST['paged'] )	: 1;
		$href				= isset( $_POST['href'] )				? bdpp_clean_url( $_POST['href'] )		: '';
		$count				= isset( $count )						? $count					: 0;
		$count				= isset( $_POST['count'] )				? $_POST['count']			: $count;
		$pagination_type	= isset( $_POST['pagination_type'] )	? $_POST['pagination_type']	: '';
		$pagination_html	= '';
		$query_shrt			= str_replace('bdp_', 'bdpp_', $shortcode);

		// If valid data found
		if( ! empty( $atts ) ) {

			// Taking some globals
			global $post;

			// For Numeric Ajax
			if( $href && $pagination_type == 'numeric-ajax' ) {
				$href_parts	= parse_url( $href );
				parse_str( $href_parts['query'], $href_data );

				$paged = isset( $href_data['bdpp-page'] ) ? $href_data['bdpp-page'] : $paged;
			}

			// Taking care of query offset with pagination
			if( $query_offset && $paged > 1 ) {
				$offset = $query_offset + ( ($paged - 1) * $limit );
			} else {
				$offset = $query_offset;
			}

			// WP Query Parameters
			$args = array(
				'post_type'      		=> $post_type,
				'post_status' 			=> array('publish'),
				'order'					=> $order,
				'orderby'		 		=> $orderby,
				'posts_per_page' 		=> $limit,
				'post__in'		 		=> $posts,
				'post__not_in'	 		=> $hide_post,
				'author__in'			=> $author,
				'author__not_in' 		=> $exclude_author,
				'paged'					=> $paged,
				'offset'				=> $offset,
				'ignore_sticky_posts'	=> true,
			);

		    // Category Parameter
			if( $category ) {

				$args['tax_query'] = array(
										array( 
											'taxonomy' 			=> $taxonomy,
											'field' 			=> 'term_id',
											'terms' 			=> $category,
											'include_children'	=> $include_cat_child,
										));

			} else if( $exclude_cat ) {
				
				$args['tax_query'] = array(
											array(
												'taxonomy' 			=> $taxonomy,
												'field' 			=> 'term_id',
												'terms' 			=> $exclude_cat,
												'operator'			=> 'NOT IN',
												'include_children'	=> $include_cat_child,
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

			$args = apply_filters( $query_shrt.'_query_args', $args, $atts );
			$args = apply_filters( 'bdpp_posts_query_args', $args, $atts );

			// WP Query
			$query = new WP_Query( $args );

			// Taking care of pagination with offset
			if( $query_offset ) {
				$found_posts = ( $query->found_posts - $query_offset );
				$query->max_num_pages = ceil( $found_posts / $limit );
			}

			// For Numeric Ajax
			if( $pagination_type == 'numeric-ajax' ) {
				$pagination_html = bdpp_pagination( array( 'paged' => $paged, 'total' => $query->max_num_pages, 'prev_text' => $prev_text, 'next_text' => $next_text, 'multi_page' => 1, 'base_url' => $href, 'pagination_type' => $pagination_type ) );
			}

			ob_start();

			// If post is there
			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) : $query->the_post();

					$count++;
					$atts['count'] 		= $count;
					$atts['format']		= bdpp_get_post_format();
					$atts['feat_img'] 	= bdpp_get_post_feat_image( $post->ID, $media_size, true );
					$atts['post_link'] 	= bdpp_get_post_link( $post->ID );
					$atts['cate_name'] 	= bdpp_get_post_terms( $post->ID, $taxonomy );
					$atts['tags']  		= ($show_tags) ? bdpp_post_meta_data( array('tag' => $show_tags), array('tag_taxonomy' => $tag_taxonomy) ) : '';

					$atts['wrp_cls']	= "bdpp-post-{$post->ID} bdpp-post-{$atts['format']}";
					$atts['wrp_cls']	.= ( is_sticky( $post->ID ) ) 	? ' bdpp-sticky'	: '';
					$atts['wrp_cls'] 	.= empty( $atts['feat_img'] )	? ' bdpp-no-thumb'	: ' bdpp-has-thumb';

					switch ( $shortcode ) {
						case 'bdp_post':
							$tempate_loc		= 'grid';
							$atts['wrp_cls'] 	.= " bdpp-col-{$grid} bdpp-columns";
							$atts['wrp_cls'] 	.= ( $count % $grid  == 1 ) ? ' bdpp-first' : '';
							break;

						case 'bdp_post_gridbox':
							$tempate_loc 		= 'gridbox';
							break;

						case 'bdp_post_list':
							$tempate_loc 		= 'list';
							break;

						case 'bdp_timeline':
							$tempate_loc 		= 'timeline';
							break;

						case 'bdp_masonry':
							$tempate_loc		= 'masonry';
							$atts['wrp_cls']	.= " bdpp-col-{$grid} bdpp-columns";
							break;
					}

					// Include Dsign File
					bdpp_get_template( "{$tempate_loc}/{$design}.php", $atts );

				endwhile;

			} // end of have_post()

			wp_reset_postdata(); // Reset WP Query

			$content = ob_get_clean();

			$result['status']			= 1;
			$result['msg']				= esc_html__('Success', 'blog-designer-pack');
			$result['count']			= $count;
			$result['data']				= $content;
			$result['pagination_html']	= $pagination_html;
			$result['last_page']		= ( $paged >= $query->max_num_pages ) ? 1 : 0;
		}

		wp_send_json($result);
	}

	/**
	 * Load More Terms via Ajax
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_load_more_terms() {

		// Taking the shortocde parameters
		$atts = json_decode( wp_unslash($_POST['shrt_param']), true );
		extract( $atts );

		// If valid data found
		if( !empty( $atts ) ) {

			$result = array(
						'status'	=> 0,
						'msg'		=> __('Sorry, Something happened wrong.', 'blog-designer-pack'),
					);
			$prefix			= BDPP_META_PREFIX;
			$paged			= bdpp_clean_number( $_POST['paged'] );
			$count			= isset( $_POST['count'] ) ? $_POST['count'] : $atts['count'];
			$max_num_pages	= ceil( $term_total / $limit );
			$query_shrt		= str_replace('bdp_', 'bdpp_', $shortcode);

			// Taking some globals
			global $post;

			// Taking care of query offset with pagination
			if( $paged > 1 ) {
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
			$query_taxonomy = get_terms( apply_filters( $query_shrt.'_query_args', $cat_args, $atts ) );

			ob_start();

			// If taxonomy is there
			if ( ! is_wp_error( $query_taxonomy ) && ! empty( $query_taxonomy ) ) {
				foreach ( $query_taxonomy as $taxonomy_key => $taxonomy_data ) {

					$atts['term_data']		= $taxonomy_data;
					$atts['term_img_id']	= get_term_meta( $taxonomy_data->term_id, $prefix.'term_img_id', true );
					$atts['term_image']		= bdpp_get_image_url( $atts['term_img_id'], $media_size );
					$atts['term_link']		= bdpp_get_term_link( $taxonomy_data );

					// Creating image style
					if( $atts['term_image'] ) {
						$atts['image_style'] = 'style="background-image:url('.esc_url( $atts['term_image'] ).');"';
					} else {
						$atts['image_style'] = '';
					}

					switch ( $shortcode ) {
						case 'bdp_cat_grid':
							$tempate_loc		= 'grid';
							$atts['wrp_cls']	= "bdpp-term-grid bdpp-col-{$grid} bdpp-columns";
							$atts['wrp_cls']	.= ( $count % $grid == 0 ) ? ' bdpp-first' : '';
							$atts['wrp_cls']	.= empty( $atts['term_image'] ) ? ' bdpp-no-thumb' : '';
							break;
					}

					// Design Template
					bdpp_get_template( "taxonomy/{$tempate_loc}/{$design}.php", $atts );

					$count++;
				}
			}

			$content = ob_get_clean();

			$result['status']		= 1;
			$result['msg']			= __('Success', 'blog-designer-pack');
			$result['count']		= $count;
			$result['data']			= $content;
			$result['last_page']	= ( $paged >= $max_num_pages ) ? 1 : 0;
		}

		wp_send_json($result);
	}
}

$bdpp_public = new BDPP_Public();
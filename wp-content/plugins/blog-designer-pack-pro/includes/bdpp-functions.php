<?php
/**
 * Plugin generic functions file
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_esc_attr($data) {
	return esc_attr( $data );
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'bdpp_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_clean_number( $var, $fallback = null, $type = 'int' ) {

	$var = trim( $var );

	if( $type == 'int' ) {
		$data = absint( $var );
	} elseif ( $type == 'number' ) {
		$data = intval( $var );
	} else {
		$data = abs( $var );
	}

	return ( empty($data) && isset($fallback) ) ? $fallback : $data;
}

/**
 * Sanitize url
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_clean_url( $url ) {
	return esc_url_raw( trim($url) );
}

/**
 * Sanitize Hex Color
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */
function bdpp_clean_color( $color, $fallback = null ) {
	$color = sanitize_hex_color( trim( $color ) );
	return ( empty($color) && $fallback ) ? sanitize_hex_color( $fallback ) : $color;
}

/**
 * Strip Slashes From Array
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_clean_html($data = array(), $flag = false) {

	if($flag != true) {
		$data = bdpp_nohtml_kses($data);
	}
	$data = stripslashes_deep($data);
	return $data;
}

/**
 * Strip Html Tags
 * It will sanitize text input (strip html tags, and escape characters)
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_nohtml_kses($data = array()) {

	if ( is_array($data) ) {

		$data = array_map('bdpp_nohtml_kses', $data);

	} elseif ( is_string( $data ) ) {
		$data = trim( $data );
		$data = wp_filter_nohtml_kses($data);
	}

	return $data;
}

/**
 * Sanitize multiple HTML classes
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_sanitize_html_classes($classes, $sep = " ") {
	$return = "";

	if( !is_array($classes) ) {
		$classes = explode($sep, $classes);
	}

	if( !empty($classes) ) {
		foreach($classes as $class) {
			$return .= sanitize_html_class($class) . " ";
		}
		$return = trim( $return );
	}

	return $return;
}

/**
 * Function to add array after specific key
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_add_array(&$array, $value, $index, $from_last = false) {

	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count    = count($array);
			$index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
		}

		$split_arr  = array_splice($array, max(0, $index));
		$array      = array_merge( $array, $value, $split_arr);
	}
	return $array;
}

/**
 * Function to unique number value
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_unique() {
	static $unique = 0;
	$unique++;

	// For VC front end editing
	if ( ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) || 
		 ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' && isset($_POST['editor_post_id']) )
		)
	{
		return rand() .'-'. current_time( 'timestamp' );
	}

	return $unique;
}

/**
 * Convert color hex value to rgb format
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_hex2rgb( $hex = '', $format = 'string' ) {

	if( empty($hex) ) return false;

	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}

	$rgb = array($r, $g, $b);

	if( $format == 'string' ) {
		$rgb = implode(",", $rgb);
	}

	return $rgb;
}

/**
 * Function to validate that public script should be enqueue at last.
 * Call this function at last.
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_enqueue_script() {

	// Check public script is in queue
	if( wp_script_is( 'bdpp-public-script', 'enqueued' ) ) {
		
		// Dequeue Script
		wp_dequeue_script( 'bdpp-public-script' );

		// Enqueue Script
		wp_enqueue_script( 'bdpp-public-script' );
	}
}

/**
 * Function to set flag of common setting
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_common_sett() {

	global $bdpp_common_sett, $bdpp_common_sett_msg, $bdpp_common_sett_var, $bdpp_common_sett_page;

	$bdpp_common_sett = ! empty( $bdpp_common_sett ) ? ( $bdpp_common_sett + 1 ) : 1;

	// Sett Common Setting Message
	if( empty( $bdpp_common_sett_msg ) ) {

		$bdpp_common_sett_page	= 'bdpp_settings';
		$bdpp_common_sett_var	= 'bdpp_options';
		$plugin_setting_link	= add_query_arg( array('page' => 'bdpp-settings'), admin_url( 'admin.php' ) );
		$bdpp_common_sett_msg	= '<div class="bdpp-info">
			<p>'.__('It looks like that you have <strong>Blog Designer Pack Pro</strong> plugin is activated.', 'blog-designer-pack').'</p>
			<p>'.sprintf( __('This plugin uses the same settings and data from it. So please configure plugin settings from <a href="%s" target="_blank">here</a>.', 'blog-designer-pack'), $plugin_setting_link ).'</p>
		</div>';
	}
}

/**
 * Function to get post excerpt
 * Custom function so some theme filter will not affect it.
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.3
 */
function bdpp_post_excerpt( $post = null ) {

	$post = get_post( $post );
	if ( empty( $post ) ) {
		return '';
	}
 
	if ( post_password_required( $post ) ) {
		return __( 'There is no excerpt because this is a protected post.', 'blog-designer-pack' );
	}

	return apply_filters( 'bdpp_post_excerpt', $post->post_excerpt, $post );
}

/**
 * Function to get post short content either via excerpt or content.
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_post_excerpt( $post_id = null, $content = '', $word_length = '55', $more = '...' ) {

	global $post;

	$word_length = ! empty( $word_length ) ? $word_length : 55;

	// If post id is passed
	if( ! empty( $post_id ) ) {
		if( has_excerpt( $post_id ) ) {
		  $content = bdpp_post_excerpt( $post );
		} else {
		  $content = ! empty( $content ) ? $content : get_the_content();
		}
	}

	if( $content ) {
		$content = strip_shortcodes( $content ); // Strip shortcodes
		$content = wp_trim_words( $content, $word_length, $more );
	}
	return $content;
}

/**
 * Function to get post featured image
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_post_feat_image( $post_id = '', $size = 'large', $default_img = false ) {
	$size   = !empty($size) ? $size : 'large';
	$image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	if( !empty($image) ) {
		$image = isset($image[0]) ? $image[0] : '';
	}

	// Getting default image
	if( $default_img && empty($image) ) {
	}

	return $image;
}

/**
 * Function to get post external link or permalink
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_post_link( $post_id = '' ) {

	$post_link  = false;
	$prefix     = BDPP_META_PREFIX;

	if( !empty($post_id) ) {

		$post_link = get_post_meta( $post_id, $prefix.'post_link', true );

		if( empty($post_link) ) {
			$post_link = get_permalink( $post_id );
		}
	}
	return $post_link;
}

/**
 * Function to get term external link or permalink
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_term_link( $term = '' ) {
	$term_link  		= false;
	$prefix     		= BDPP_META_PREFIX;
	$term_id			= is_object( $term ) ? $term->term_id : $term;
	$allowed_taxonomy	= bdpp_get_option( 'taxonomy', array() );

	if( !empty($term) ) {

		// Get term object if term id is passed
		if( ! is_object( $term ) ) {
			$term = get_term( $term_id );
		}

		// Get taxonomy custom link if it is enabled from setting
		if( isset( $term->taxonomy ) && isset($allowed_taxonomy[$term->taxonomy]) ) {
			$term_link = get_term_meta( $term_id, $prefix.'term_link', true );
		}

		if( empty($term_link) ) {
			$term_link = get_term_link( $term );
		}
	}
	return $term_link;
}

/**
 * Function to get post categories with HTML
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_post_terms( $post_id = '', $taxonomy = BDPP_CAT, $limit = null, $join = ' ' ) {

	$cat_count  = 1;
	$cat_links  = array();
	$terms      = get_the_terms( $post_id, $taxonomy );

	if( ! is_wp_error( $terms ) && $terms ) {
		foreach ( $terms as $term ) {
			$term_link      = bdpp_get_term_link( $term );
			$cat_links[]    = '<a class="bdpp-post-cat-link bdpp-post-cat-'.$term->term_id.' bdpp-post-cat-'.$term->slug.'" href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';

			// Upto number of limits
			if( $cat_count == $limit ) {
				break;
			}

			$cat_count++;
		}
	}
	$cat_links = join( $join, $cat_links );

	return $cat_links;
}

/**
 * Function to get post meta data like author, date and etc
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_meta_data( $meta = array(), $args = array(), $join = ' &ndash; ', $output = 'html' ) {

	global $post;

	$result				= array();
	$join				= '<span class="bdpp-post-meta-sep">'. $join .'</span>';
	$meta				= is_array( $meta ) ? $meta : (array)$meta;
	$default_meta_args	= array(
								'icon'				=> true,
								'hide_empty'		=> true,
								'comment_text'		=> _n( 'Reply', 'Replies', get_comments_number(), 'blog-designer-pack' ),
								'post_id'			=> !empty( $args['post_id'] ) ? $args['post_id'] : $post->ID,
								'taxonomy'			=> BDPP_CAT,
								'tag_taxonomy'		=> '',
								'cat_limit'			=> '',
								'tag_limit'			=> '',
								'sharing'			=> '',
								'sharing_trigger'	=> 'click',
							);
	$args				= wp_parse_args( $args, $default_meta_args );

	// Loop of meta data
	if( !empty( $meta ) ) {
		foreach ($meta as $meta_key => $meta_val) {

			if( empty( $meta_key ) || empty( $meta_val ) ) {
				continue;
			}

			// Post Author
			if( $meta_key == 'author' ) {
				$icon				= ( $args['icon'] ) ? '<i class="fa fa-user"></i>' : null;
				$result[$meta_key]	= '<span class="bdpp-post-meta-data bdpp-post-author">'. $icon . ucfirst( get_the_author() ).'</span>';
			}

			// Post Date
			if( $meta_key == 'post_date' ) {
				$icon				= ( $args['icon'] ) ? '<i class="fa fa-clock-o"></i>' : null;
				$result[$meta_key]	= '<span class="bdpp-post-meta-data bdpp-post-date">'. $icon . get_the_date().'</span>';
			}

			// Post Year
			if( $meta_key == 'year' ) {
				$result[$meta_key] = '<span class="bdpp-post-meta-data bdpp-post-year">'.get_the_date('Y').'</span>';
			}

			// Post Year
			if( $meta_key == 'month' ) {
				$result[$meta_key] = '<span class="bdpp-post-meta-data bdpp-post-month">'.get_the_date('M').'</span>';
			}

			// Post Day
			if( $meta_key == 'day' ) {
				$result[$meta_key] = '<span class="bdpp-post-meta-data bdpp-post-day">'.get_the_date('d').'</span>';
			}

			// Post Date
			if( $meta_key == 'comments' ) {

				$comment_count	= get_comments_number();
				$icon			= ( $args['icon'] ) ? '<i class="fa fa-comments"></i>' : null;

				if( (! $args['hide_empty']) || ($args['hide_empty'] && $comment_count > 0) ) {
					$result[$meta_key] = '<span class="bdpp-post-meta-data bdpp-post-comments">'. $icon . $comment_count .' '. $args['comment_text'].'</span>';
				}
			}

			// Post Category
			if( $meta_key == 'category' ) {
				$icon		= ( $args['icon'] ) ? '<i class="fa fa-folder-open"></i>' : null;
				$cat_list	= bdpp_get_post_terms( $args['post_id'], $args['taxonomy'], $args['tag_limit'] );

				if( $cat_list ) {
					$result[$meta_key] = '<span class="bdpp-post-meta-data bdpp-post-cats">'. $icon . $cat_list.'</span>';
				}
			}

			// Post Category
			if( $meta_key == 'tag' ) {
				$icon		= ( $args['icon'] ) ? '<i class="fa fa fa-tags"></i>' : null;
				$tag_list	= bdpp_get_post_terms( $args['post_id'], $args['tag_taxonomy'], $args['tag_limit'], ', ' );

				if( $tag_list ) {
					$result[$meta_key] = '<span class="bdpp-post-meta-data bdpp-post-tags">'. $icon . $tag_list.'</span>';
				}
			}

			// Social Share
			if( $meta_key == 'sharing' && bdpp_sharing_enabled() ) {
				$icon				= ( $args['icon'] ) ? '<i class="fa fa-share-alt"></i>' : null;
				$sharing_trigger	= ( $args['sharing_trigger'] == 'hover' ) ? 'hover' : 'click';
				$result[$meta_key] 	= '<span class="bdpp-post-meta-data bdpp-post-share bdpp-tooltip" data-trigger="'.$sharing_trigger.'" data-tooltip-content="bdpp-post-share-'.$args['post_id'].'">'. $icon . __('Share', 'blog-designer-pack') .'</span>';
				$result[$meta_key]	.= '<div class="bdpp-hide"><div class="bdpp-tooltip-cnt bdpp-share-tooltip-wrap">'. bdpp_get_template_html( 'sharing.php', array('sharing' => $meta_val ) ) .'</div></div>';
			}
		}
	}

	// HTML Output
	if( $output == 'html' ) {
		$result = join( $join, $result );
	}

	return $result;
}

/**
 * Pagination function
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */
function bdpp_pagination($args = array(), $identifier = '') {

	$big				= 999999999; // need an unlikely integer
	$page_links_temp	= array();
	$multi_page			= ! empty( $args['multi_page'] )	? 1 : 0;
	$pagination_type	= isset( $args['pagination_type'] ) ? $args['pagination_type']	: 'numeric';
	$base_url			= isset( $args['base_url'] )		? $args['base_url']			: false;

	$paging_args = array(
					'base'      => isset( $args['base'] ) ? $args['base'] : str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => isset( $args['format'] ) ? $args['format'] : '?paged=%#%',
					'current'   => max( 1, $args['paged'] ),
					'total'     => $args['total'],
					'prev_next' => true,
					'prev_text' => empty( $args['prev_text'] ) ? "&laquo; " . __('Previous', 'blog-designer-pack') : $args['prev_text'],
					'next_text' => empty( $args['next_text'] ) ? __('Next', 'blog-designer-pack') . " &raquo;" : $args['next_text'],
				);

	// If shortcode is placed in single post and pgination type is 'prev-next'
	if( $multi_page ) {
		$paging_args['type']	= ( $pagination_type == 'prev-next' ) ? 'array' : 'plain';
		$paging_args['base']	= esc_url_raw( add_query_arg( 'bdpp-page', '%#%', $base_url ) );
		$paging_args['format']	= '?bdpp-page=%#%';
	}

	$page_links = paginate_links( apply_filters( 'bdpp_pagination', $paging_args, $identifier ) );

	// For single post shortcode we just fetch the prev-next link
	if( $multi_page && $pagination_type == 'prev-next' && $page_links && is_array( $page_links ) ) {

		foreach ($page_links as $page_link_key => $page_link) {
			if( strpos( $page_link, 'next page-numbers') !== false || strpos( $page_link, 'prev page-numbers') !== false ) {
				$page_links_temp[ $page_link_key ] = $page_link;
			}
		}
		return join( "\n", $page_links_temp );
	}

	return $page_links;
}

/**
 * Function to get registered post types
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_post_types() {     

	$post_types     = array();
	$reg_post_types = get_post_types( array('public' => true), 'name' );

	// Exclude some builin WP Post Types
	$exclude_post = array('attachment', 'revision', 'nav_menu_item');

	foreach ($reg_post_types as $post_type_key => $post_data) {
		if( !in_array( $post_type_key, $exclude_post) ) {
			$post_types[$post_type_key] = $post_data->label;
		}
	}

	return apply_filters('bdpp_get_post_types', $post_types );
}

/**
 * Function to get registered Taxonomies List based on post type
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_taxonomies( $post_type = '', $output = '' ) {
	
	// Taking some variables
	$result         = array();
	$taxonomy_list  = '';

	if( $post_type ) {

		$taxonomy_objects = get_object_taxonomies( $post_type, 'object' );

		if( ! empty($taxonomy_objects) && ! is_wp_error($taxonomy_objects) )  {
			foreach($taxonomy_objects as $object => $taxonomy) { 
				if( !empty($taxonomy->public) && 'post_format' != $object ) {					
					
					if( $output == 'list' ) {
						$result[] = $object;
					} else {
						$result[$object] = !empty( $taxonomy->label ) ? $taxonomy->label : $object;
					}
				}
			}
		}

		// If output is list
		if( $output == 'list' ) {
			$result = implode(', ', $result);
		}
	}
	return $result;
}

/**
 * Get Taxonomies 
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_taxonomy_options($objects = array(), $selected_val = '') {

	$output = '';

	if( !empty( $objects ) && !is_wp_error( $objects ) ) {
		foreach($objects as $object => $taxonomy) {
			if( 'post_format' != $object && !empty($taxonomy->public) ) {
				$output .= '<option value="'. $object .'" '.selected( $selected_val, $object, false ).'>'. $taxonomy->label . ' - ('.$taxonomy->name.')</option>';
			}
		}
	} else {
		$output .= '<option value="">'.esc_html__('No Taxonomies Found', 'blog-designer-pack').'</option>';
	}
	return $output;
}

/**
 * Check Post Social Sharing is enabled or not 
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_sharing_enabled( $post_id = '' ) {
	global $post;

	if( empty( $post_id ) ) {
		$post_id = isset( $post->ID ) ? $post->ID : false;
	}

	$sharing			= false;
	$prefix 			= BDPP_META_PREFIX;
	$social_services	= bdpp_get_option( 'sharing', array() );
	$sharing_enable		= bdpp_get_option( 'sharing_enable', 0 );
	$disable_sharing	= get_post_meta( $post_id, $prefix.'disable_sharing', true );

	if( $sharing_enable && ! $disable_sharing && $social_services ) {
		$sharing = true;
	}

	return $sharing;
}

/**
 * Get post sharing title
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_share_title( $post_id = '' ) {

	$post = get_post( $post_id );

	$title = isset( $post->post_title ) ? $post->post_title : '';
	$title = apply_filters( 'bdpp_post_sharing_title', $title, $post_id );
	return html_entity_decode( wp_kses( $title, null ) );
}

/**
 * Get post sharing url
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_share_url( $post_id = '' ) {
	return apply_filters( 'bdpp_post_sharing_url', get_permalink( $post_id ), $post_id );
}

/**
 * Get Post Format
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_post_format($post_id = '') {

	$format	= get_post_format( $post_id );
	$format	= empty( $format ) ? 'standard' : $format;

	return $format;
}

/**
 * Function to get post featured image
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_image_url( $img_id = '', $size = 'large', $default_img = false ) {
	$size   = !empty($size) ? $size : 'large';
	$image  = wp_get_attachment_image_src( $img_id, $size );

	if( !empty($image) ) {
		$image = isset($image[0]) ? $image[0] : '';
	}

	// Getting default image
	if( $default_img && empty($image) ) {
	}

	return $image;
}

/**
 * Get Post Format HTML
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_format_html( $format ) {
	$result = '';

	if($format == 'video') {
		$result = '<span class="bdpp-format-icon"><i class="bdpp-post-icon fa fa-play"></i></span>';
	} else if ($format == 'audio') {
			$result = '<span class="bdpp-format-icon"><i class="bdpp-post-icon fa fa-music"></i></span>';
	} else if ($format == 'quote') {
			$result = '<span class="bdpp-format-icon"><i class="bdpp-post-icon fa fa-quote-left"></i></span>';
	} else if ($format == 'gallery') {
			$result = '<span class="bdpp-format-icon"><i class="bdpp-post-icon fa fa-picture-o"></i></span>';
	} else if ($format == 'link') {
			$result = '<span class="bdpp-format-icon"><i class="bdpp-post-icon fa fa-link"></i></span>';
	} else {
		$result = '<span class="bdpp-format-icon"><i class="bdpp-post-icon fa fa-thumb-tack"></i></span>';
	}

	return apply_filters( 'bdpp_post_format_html', $result, $format );
}

/**
 * Function to get social sharing designs
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_sharing_services() {
	$services = array(
		'facebook'		=> esc_html__('Facebook', 'blog-designer-pack'),
		'twitter'		=> esc_html__('Twitter', 'blog-designer-pack'),
		'linkedin'		=> esc_html__('LinkedIn', 'blog-designer-pack'),
		'pinterest'		=> esc_html__('Pinterest', 'blog-designer-pack'),
		'tumblr'		=> esc_html__('Tumblr', 'blog-designer-pack'),
		'pocket'		=> esc_html__('Pocket', 'blog-designer-pack'),
		'skype'			=> esc_html__('Skype', 'blog-designer-pack'),
		'telegram'		=> esc_html__('Telegram', 'blog-designer-pack'),
		'whatsapp'		=> esc_html__('WhatsApp', 'blog-designer-pack'),
		'reddit'		=> esc_html__('Reddit', 'blog-designer-pack'),
		'digg'			=> esc_html__('Digg', 'blog-designer-pack'),
		'wordpress'		=> esc_html__('WordPress', 'blog-designer-pack'),
		'email'			=> esc_html__('Email', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_sharing_services', $services );
}

/**
 * Function to get social sharing designs
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_sharing_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Theme 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Theme 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Theme 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Theme 4', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_sharing_designs', $design_arr );
}

/**
 * Function to get post grig 'bdp_post' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
		'design-8'	=> esc_html__('Design 8', 'blog-designer-pack'),
		'design-9'	=> esc_html__('Design 9', 'blog-designer-pack'),
		'design-10'	=> esc_html__('Design 10', 'blog-designer-pack'),
		'design-11'	=> esc_html__('Design 11', 'blog-designer-pack'),
		'design-12'	=> esc_html__('Design 12', 'blog-designer-pack'),
		'design-13'	=> esc_html__('Design 13', 'blog-designer-pack'),
		'design-14'	=> esc_html__('Design 14', 'blog-designer-pack'),
		'design-15'	=> esc_html__('Design 15', 'blog-designer-pack'),
		'design-16'	=> esc_html__('Design 16', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_grid_designs', $design_arr );
}

/**
 * Function to get post carousel 'bdp_post_carousel' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_carousel_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
		'design-8'	=> esc_html__('Design 8', 'blog-designer-pack'),
		'design-9'	=> esc_html__('Design 9', 'blog-designer-pack'),
		'design-10'	=> esc_html__('Design 10', 'blog-designer-pack'),
		'design-11'	=> esc_html__('Design 11', 'blog-designer-pack'),
		'design-12'	=> esc_html__('Design 12', 'blog-designer-pack'),
		'design-13'	=> esc_html__('Design 13', 'blog-designer-pack'),
		'design-14'	=> esc_html__('Design 14', 'blog-designer-pack'),
		'design-15'	=> esc_html__('Design 15', 'blog-designer-pack'),
		'design-16'	=> esc_html__('Design 16', 'blog-designer-pack'),
		'design-17'	=> esc_html__('Design 17', 'blog-designer-pack'),
		'design-18'	=> esc_html__('Design 18', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_carousel_designs', $design_arr );
}

/**
 * Function to get post slider 'bdp_post_slider' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_slider_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
		'design-8'	=> esc_html__('Design 8', 'blog-designer-pack'),
		'design-9'	=> esc_html__('Design 9', 'blog-designer-pack'),
		'design-10'	=> esc_html__('Design 10', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_slider_designs', $design_arr );
}

/**
 * Function to get post lists 'bdp_post_list' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_list_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
		'design-8'	=> esc_html__('Design 8', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_list_designs', $design_arr );
}

/**
 * Function to get post grigbox 'bdp_post_gridbox' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_gridbox_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
		'design-8'	=> esc_html__('Design 8', 'blog-designer-pack'),
		'design-9'	=> esc_html__('Design 9', 'blog-designer-pack'),
		'design-10'	=> esc_html__('Design 10', 'blog-designer-pack'),
		'design-11'	=> esc_html__('Design 11', 'blog-designer-pack'),
		'design-12'	=> esc_html__('Design 12', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_gridbox_designs', $design_arr );
}

/**
 * Function to get post grigbox slider 'bdp_post_gridbox_slider' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_gridbox_slider_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_gridbox_slider_designs', $design_arr );
}

/**
 * Function to get post masonry 'bdp_masonry' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_masonry_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
		'design-8'	=> esc_html__('Design 8', 'blog-designer-pack'),
		'design-9'	=> esc_html__('Design 9', 'blog-designer-pack'),
		'design-10'	=> esc_html__('Design 10', 'blog-designer-pack'),
		'design-11'	=> esc_html__('Design 11', 'blog-designer-pack'),
		'design-12'	=> esc_html__('Design 12', 'blog-designer-pack'),
		'design-13'	=> esc_html__('Design 13', 'blog-designer-pack'),
		'design-14'	=> esc_html__('Design 14', 'blog-designer-pack'),
		'design-15'	=> esc_html__('Design 15', 'blog-designer-pack'),
		'design-16'	=> esc_html__('Design 16', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_masonry_designs', $design_arr );
}

/**
 * Function to get post timeline 'bdp_timeline' shortcode design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_timeline_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
		'design-8'	=> esc_html__('Design 8', 'blog-designer-pack'),
		'design-9'	=> esc_html__('Design 9', 'blog-designer-pack'),
		'design-10'	=> esc_html__('Design 10', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_timeline_designs', $design_arr );
}

/**
 * Function to get post list widgets design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_widget_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
		'design-5'	=> esc_html__('Design 5', 'blog-designer-pack'),
		'design-6'	=> esc_html__('Design 6', 'blog-designer-pack'),
		'design-7'	=> esc_html__('Design 7', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_widget_designs', $design_arr );
}

/**
 * Function to get post slider widgets design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_slider_widget_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_slider_widget_designs', $design_arr );
}

/**
 * Function to get post scrolling widgets design
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_post_scrolling_widget_designs() {
	$design_arr = array(
		'design-1'	=> esc_html__('Design 1', 'blog-designer-pack'),
		'design-2'	=> esc_html__('Design 2', 'blog-designer-pack'),
		'design-3'	=> esc_html__('Design 3', 'blog-designer-pack'),
		'design-4'	=> esc_html__('Design 4', 'blog-designer-pack'),
	);
	return apply_filters( 'bdpp_post_scrolling_widget_designs', $design_arr );
}

/**
 * Function to get taxonomy shortcode designs
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_taxonomy_designs() {
	$design_arr = array(
				'design-1'  => esc_html__('Design 1', 'blog-designer-pack'),
				'design-2'  => esc_html__('Design 2', 'blog-designer-pack'),
				'design-3'  => esc_html__('Design 3', 'blog-designer-pack'),
				'design-4'  => esc_html__('Design 4', 'blog-designer-pack'),
				'design-5'  => esc_html__('Design 5', 'blog-designer-pack'), 
				'design-6'  => esc_html__('Design 6', 'blog-designer-pack'),				
				
			);
	return apply_filters('bdpp_taxonomy_designs', $design_arr );
}

/**
 * Get plugin registered shortcodes
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_registered_shortcodes( $type = 'simplified' ) {

	$result		= array();
	$shortcodes = array(
					'general' => array(
									'name'			=> __('General', 'blog-designer-pack'),
									'shortcodes'	=> array(
															'bdp_post'					=> __('Post Grid', 'blog-designer-pack'),
															'bdp_post_slider'			=> __('Post Slider', 'blog-designer-pack'),
															'bdp_post_carousel'			=> __('Post Carousel', 'blog-designer-pack'),
															'bdp_post_gridbox'			=> __('Post GridBox', 'blog-designer-pack'),
															'bdp_post_gridbox_slider'	=> __('Post GridBox Slider', 'blog-designer-pack'),
															'bdp_post_list'				=> __('Post List', 'blog-designer-pack'),
															'bdp_masonry'				=> __('Post Masonry', 'blog-designer-pack'),
															'bdp_timeline'				=> __('Post Timeline', 'blog-designer-pack'),
															'bdp_ticker'				=> __('Post Ticker', 'blog-designer-pack'),
														)
									),
					'taxonomy' => array(
									'name'			=> __('Taxonomy', 'blog-designer-pack'),
									'shortcodes'	=> array(
															'bdp_cat_grid'		=> __('Category Grid', 'blog-designer-pack'), 
															'bdp_cat_slider'	=> __('Category Slider', 'blog-designer-pack'),
														)
									),
					'misc' => array(
									'name'			=> __('Miscellaneous', 'blog-designer-pack'),
									'shortcodes'	=> array(
															'bdp_post_ctv1'	=> __('Creative Post Design - 1', 'blog-designer-pack'),
														)
									),
					);
	$shortcodes = apply_filters('bdpp_registered_shortcodes', (array)$shortcodes );

	// For simplified result
	if( $type == 'simplified' && ! empty( $shortcodes ) ) {
		foreach ($shortcodes as $shrt_key => $shrt_val) {
			if( is_array( $shrt_val ) && ! empty( $shrt_val['shortcodes'] ) ) {
				$result = array_merge( $result, $shrt_val['shortcodes'] );
			} else {
				$result[ $shrt_key ] = $shrt_val;
			}
		}
	} else {
		$result = $shortcodes;
	}
	return $result;
}
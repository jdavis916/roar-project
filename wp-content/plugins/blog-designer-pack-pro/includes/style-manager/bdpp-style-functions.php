<?php
/**
 * Style Manager Functions
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 *
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function generate style from style ID based on type and identifier
 * 
 * @since 1.0.1
 */
function bdpp_style_mngr_tab() {

	$style_tabs = array(
						'general'	=> array(
											'title' => esc_html__('General', 'blog-designer-pack'),
											'icon'	=> 'dashicons-welcome-view-site',
										),
						'post-meta'	=> array(
											'title' => esc_html__('Post & Post Meta', 'blog-designer-pack'),
											'icon'	=> 'dashicons-admin-page',
										),
						'post-cnt'	=> array(
											'title' => esc_html__('Short Content', 'blog-designer-pack'),
											'icon'	=> 'dashicons-text-page',
										),
						'rdm-btn'	=> array(
											'title' => esc_html__('Read More Button', 'blog-designer-pack'),
											'icon'	=> 'dashicons-marker',
										),
						'slider'	=> array(
											'title' => esc_html__('Slider', 'blog-designer-pack'),
											'icon'	=> 'dashicons-slides',
										),
						'timeline'	=> array(
											'title' => esc_html__('Timeline', 'blog-designer-pack'),
											'icon'	=> 'dashicons-editor-ul',
										),
						'cat-shrt'	=> array(
											'title' => esc_html__('Category Shortcode', 'blog-designer-pack'),
											'icon'	=> 'dashicons-category',
										),
						'pagination'	=> array(
											'title' => esc_html__('Pagination', 'blog-designer-pack'),
											'icon'	=> 'dashicons-editor-ol',
										),					
					);

	return apply_filters( 'bdpp_style_mngr_tab', $style_tabs );
}

/**
 * Function to get default style data
 * We can merge when we are generting dynemic style to avoid notices
 * 
 * @since 1.0.1
 */
function bdpp_default_style_data() {

	$style_data = array(
						'title_font_size'	=> '',
						'title_lineheight'	=> '',
						'post_title_clr'	=> '',
						'post_title_hclr'	=> '',

						// Post Content Settings
						'cnt_font_size'		=> '',
						'cnt_lineheight'	=> '',
						'cnt_font_clr'		=> '',

						// Post Meta Settings
						'cat_font_size'		=> '',
						'cat_font_clr'		=> '',
						'cat_font_hclr'		=> '',
						'cat_bg_clr'		=> '',
						'cat_bg_hclr'		=> '',
						'meta_font_size'	=> '',
						'meta_font_clr'		=> '',
						'meta_icon_clr'		=> '',
						'disable_img_zoom'	=> 0,  

						// Read More Button Settings
						'rdm_font_size'		=> '',
						'rdm_font_clr'		=> '',
						'rdm_font_hclr'		=> '',
						'rdm_bg_clr'		=> '',
						'rdm_bg_hclr'		=> '',
						'rdm_border_clr'	=> '',
						'rdm_border_hclr'	=> '',
						
						// Slider Settings
						'slider_arw_clr'	=> '',
						'slider_arw_hclr'	=> '',
						'slider_arw_bg_clr'	=> '',
						'slider_arw_bg_hclr'=> '',
						'slider_dots_clr'	=> '',
						'slider_dots_aclr'	=> '',
						
						// Timeline Settings
						'tmnl_theme_clr'	=> '',
						'tmnl_icon_clr'		=> '',
						'tmnl_pbg_clr'		=> '',
						
						// Category Shortcode Settings
						'cat_shrt_fsize'		=> '',
						'cat_shrt_title_clr'	=> '',
						'cat_shrt_title_bclr'	=> '',
						'cat_shrt_count_fsize'	=> '',
						'cat_shrt_count_clr'	=> '',
						'cat_shrt_count_bclr'	=> '',
						
						// Pegination Settings
						'pagi_theme_clr'	=> '',
						'pagi_theme_h_clr'	=> '',
						'pagi_themef_clr'	=> '',
						'pagi_themef_h_clr'	=> '',
						'pagi_active_clr'	=> '',
						'pagi_activef_clr'	=> '',
						'pagi_font_size'	=> '',
					);

	return apply_filters( 'bdpp_default_style_data', $style_data );
}

/**
 * Function to get style manager data
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */
function bdpp_get_style_data( $type = '' ) {

	global $bdpp_styles_data, $bdpp_styles_simplified_data;

	if( empty( $bdpp_styles_data ) ) {
		$bdpp_styles_data = get_option( 'bdpp_styles_data' );
	}

	// Simplified data (Key -> Name)
	if( $type == 'simplified' ) {

		$simplified_data[''] = esc_html__('Choose Style', 'blog-designer-pack');

		if( ! empty( $bdpp_styles_data ) && empty( $bdpp_styles_simplified_data ) ) {
			foreach ( $bdpp_styles_data as $style_key => $style_val ) {
				$simplified_data[ $style_key ] = $style_val['title'] .' - #'. $style_key;			
			}
		}
		$bdpp_styles_simplified_data = ! empty( $bdpp_styles_simplified_data ) ? $bdpp_styles_simplified_data : $simplified_data;

		return $bdpp_styles_simplified_data;
	}

	return $bdpp_styles_data;
}

/**
 * Function to add, update and delete process of style manager
 * 
 * @since 1.0.1
 */
function bdpp_process_style_manager() {

	// Style Manager Save Process
	if( ! empty( $_POST['bdpp_style_mngr_sett_submit'] ) && ! empty( $_POST['bdpp_styles'] ) && isset( $_POST['bdpp_style_nonce'] ) && wp_verify_nonce( $_POST['bdpp_style_nonce'], 'bdpp_style_nonce' ) ) {

		$post_data		= $_POST['bdpp_styles'];
		$styles_data	= bdpp_get_style_data();
		$styles_data	= ( ! empty( $styles_data ) && is_array( $styles_data ) ) ? $styles_data : array();

		// Getting style key
		if( ! empty( $_GET['style_id'] ) ) {
			$style_id = bdpp_clean_number( $_GET['style_id'] );
		} else {
			$style_id = ! empty( $styles_data ) ? (max( array_keys($styles_data) ) + 1) : 1;
		}

		/*** Sanitize Data ***/
		// General Settings
		$post_data['id']				= $style_id;
		$post_data['title']				= ! empty( $post_data['title'] )			? bdpp_clean( $post_data['title'] )							: esc_html__('Style', 'blog-designer-pack');
		$post_data['title_font_size']	= ! empty( $post_data['title_font_size'] )	? bdpp_clean_number( $post_data['title_font_size'], '' )	: '';
		$post_data['title_lineheight']	= ! empty( $post_data['title_lineheight'] )	? bdpp_clean_number( $post_data['title_lineheight'], '' )	: '';
		$post_data['post_title_clr']	= isset( $post_data['post_title_clr'] )		? bdpp_clean_color( $post_data['post_title_clr'] )			: '';
		$post_data['post_title_hclr']	= isset( $post_data['post_title_hclr'] )	? bdpp_clean_color( $post_data['post_title_hclr'] )			: '';

		// Post Content Settings
		$post_data['cnt_font_size']		= isset( $post_data['cnt_font_size'] )		? bdpp_clean_number( $post_data['cnt_font_size'], '' )		: '';
		$post_data['cnt_lineheight']	= isset( $post_data['cnt_lineheight'] )		? bdpp_clean_number( $post_data['cnt_lineheight'], '' )		: '';
		$post_data['cnt_font_clr']		= isset( $post_data['cnt_font_clr'] )		? bdpp_clean_color( $post_data['cnt_font_clr'] )			: '';

		// Post Meta Settings
		$post_data['cat_font_size']		= isset( $post_data['cat_font_size'] )		? bdpp_clean_number( $post_data['cat_font_size'], '' )		: '';
		$post_data['cat_font_clr']		= isset( $post_data['cat_font_clr'] )		? bdpp_clean_color( $post_data['cat_font_clr'] )			: '';
		$post_data['cat_font_hclr']		= isset( $post_data['cat_font_hclr'] )		? bdpp_clean_color( $post_data['cat_font_hclr'] )			: '';
		$post_data['cat_bg_clr']		= isset( $post_data['cat_bg_clr'] )			? bdpp_clean_color( $post_data['cat_bg_clr'] )				: '';
		$post_data['cat_bg_hclr']		= isset( $post_data['cat_bg_hclr'] )		? bdpp_clean_color( $post_data['cat_bg_hclr'] )				: '';
		$post_data['meta_font_size']	= isset( $post_data['meta_font_size'] )		? bdpp_clean_number( $post_data['meta_font_size'], '' )		: '';
		$post_data['meta_font_clr']		= isset( $post_data['meta_font_clr'] )		? bdpp_clean_color( $post_data['meta_font_clr'] )			: '';
		$post_data['meta_icon_clr']		= isset( $post_data['meta_icon_clr'] )		? bdpp_clean_color( $post_data['meta_icon_clr'] )			: '';
		$post_data['disable_img_zoom']	= ! empty( $post_data['disable_img_zoom'] )	? 1	: 0;

		// Read More Button Settings
		$post_data['rdm_font_size']		= isset( $post_data['rdm_font_size'] )		? bdpp_clean_number( $post_data['rdm_font_size'], '' )		: '';
		$post_data['rdm_font_clr']		= isset( $post_data['rdm_font_clr'] )		? bdpp_clean_color( $post_data['rdm_font_clr'] )			: '';
		$post_data['rdm_font_hclr']		= isset( $post_data['rdm_font_hclr'] )		? bdpp_clean_color( $post_data['rdm_font_hclr'] )			: '';
		$post_data['rdm_bg_clr']		= isset( $post_data['rdm_bg_clr'] )			? bdpp_clean_color( $post_data['rdm_bg_clr'] )				: '';
		$post_data['rdm_bg_hclr']		= isset( $post_data['rdm_bg_hclr'] )		? bdpp_clean_color( $post_data['rdm_bg_hclr'] )				: '';
		$post_data['rdm_border_clr']	= isset( $post_data['rdm_border_clr'] )		? bdpp_clean_color( $post_data['rdm_border_clr'] )			: '';
		$post_data['rdm_border_hclr']	= isset( $post_data['rdm_border_hclr'] )	? bdpp_clean_color( $post_data['rdm_border_hclr'] )			: '';
		
		// Slider Settings
		$post_data['slider_arw_clr']	= isset( $post_data['slider_arw_clr'] )		? bdpp_clean_color( $post_data['slider_arw_clr'] )			: '';
		$post_data['slider_arw_hclr']	= isset( $post_data['slider_arw_hclr'] )	? bdpp_clean_color( $post_data['slider_arw_hclr'] )			: '';
		$post_data['slider_arw_bg_clr']	= isset( $post_data['slider_arw_bg_clr'] )	? bdpp_clean_color( $post_data['slider_arw_bg_clr'] )		: '';
		$post_data['slider_arw_bg_hclr']= isset( $post_data['slider_arw_bg_hclr'] )	? bdpp_clean_color( $post_data['slider_arw_bg_hclr'] )		: '';
		$post_data['slider_dots_clr']	= isset( $post_data['slider_dots_clr'] )	? bdpp_clean_color( $post_data['slider_dots_clr'] )			: '';
		$post_data['slider_dots_aclr']	= isset( $post_data['slider_dots_aclr'] )	? bdpp_clean_color( $post_data['slider_dots_aclr'] )		: '';
		
		// Timeline Settings
		$post_data['tmnl_theme_clr']	= isset( $post_data['tmnl_theme_clr'] )	? bdpp_clean_color( $post_data['tmnl_theme_clr'] )		: '';
		$post_data['tmnl_icon_clr']		= isset( $post_data['tmnl_icon_clr'] )	? bdpp_clean_color( $post_data['tmnl_icon_clr'] )		: '';
		$post_data['tmnl_pbg_clr']		= isset( $post_data['tmnl_pbg_clr'] )	? bdpp_clean_color( $post_data['tmnl_pbg_clr'] )		: '';
		
		// Category Shortcode Settings
		$post_data['cat_shrt_fsize']		= isset( $post_data['cat_shrt_fsize'] )			? bdpp_clean_number( $post_data['cat_shrt_fsize'], '' )			: '';
		$post_data['cat_shrt_title_clr']	= isset( $post_data['cat_shrt_title_clr'] )		? bdpp_clean_color( $post_data['cat_shrt_title_clr'] )			: '';
		$post_data['cat_shrt_title_bclr']	= isset( $post_data['cat_shrt_title_bclr'] )	? bdpp_clean_color( $post_data['cat_shrt_title_bclr'] )			: '';
		$post_data['cat_shrt_count_fsize']	= isset( $post_data['cat_shrt_count_fsize'] )	? bdpp_clean_number( $post_data['cat_shrt_count_fsize'], '' )	: '';
		$post_data['cat_shrt_count_clr']	= isset( $post_data['cat_shrt_count_clr'] )		? bdpp_clean_color( $post_data['cat_shrt_count_clr'] )			: '';
		$post_data['cat_shrt_count_bclr']	= isset( $post_data['cat_shrt_count_bclr'] )	? bdpp_clean_color( $post_data['cat_shrt_count_bclr'] )			: '';

		// Pegination Settings
		$post_data['pagi_theme_clr']		= isset( $post_data['pagi_theme_clr'] )			? bdpp_clean_color( $post_data['pagi_theme_clr'] )				: '';
		$post_data['pagi_theme_h_clr']		= isset( $post_data['pagi_theme_h_clr'] )		? bdpp_clean_color( $post_data['pagi_theme_h_clr'] )			: '';
		$post_data['pagi_themef_clr']		= isset( $post_data['pagi_themef_clr'] )		? bdpp_clean_color( $post_data['pagi_themef_clr'] )				: '';
		$post_data['pagi_themef_h_clr']		= isset( $post_data['pagi_themef_h_clr'] )		? bdpp_clean_color( $post_data['pagi_themef_h_clr'] )			: '';
		$post_data['pagi_active_clr']		= isset( $post_data['pagi_active_clr'] )		? bdpp_clean_color( $post_data['pagi_active_clr'] )				: '';
		$post_data['pagi_activef_clr']		= isset( $post_data['pagi_activef_clr'] )		? bdpp_clean_color( $post_data['pagi_activef_clr'] )			: '';
		$post_data['pagi_font_size']		= isset( $post_data['pagi_font_size'] )			? bdpp_clean_number( $post_data['pagi_font_size'], '' )			: '';
		
		
		$styles_data[ $style_id ] = apply_filters( 'bdpp_style_mngr_validate_style', $post_data, $style_id, $styles_data );

		update_option( 'bdpp_styles_data', $styles_data, false );

		$redirect_url = add_query_arg( array( 'page' => 'bdpp-styles', 'action' => 'edit', 'style_id' => $style_id, 'message' => '1' ), admin_url( 'admin.php' ) );
		wp_redirect( $redirect_url );
		exit;
	}

	// Style Manager Process
	if( isset( $_GET['page'] ) && $_GET['page'] == 'bdpp-styles' && ! empty( $_GET['bdpp-style'] ) ) {

		// Delete Style
		if( ((isset( $_GET['action'] ) && $_GET['action'] == 'delete') || (isset( $_GET['action2'] ) && $_GET['action2'] == 'delete')) && !empty( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'bulk-bdpp-styles' ) ) {

			// Get bulk array from $_GET
			$style_ids		= $_GET['bdpp-style'];
			$styles_data	= bdpp_get_style_data();

			// Check if we do not get array of IDs
			if( ! is_array( $style_ids ) ) {
				$style_ids = array( $style_ids );
			}

			// Loop to delete style
			foreach ( $style_ids as $style_id ) {
				unset( $styles_data[ $style_id ] );
			}

			update_option( 'bdpp_styles_data', $styles_data, false );

			$redirect_url = add_query_arg( array( 'page' => 'bdpp-styles', 'message' => '1' ), admin_url( 'admin.php' ) );
			wp_redirect( $redirect_url );
			exit;
		}

		// Duplicate Style
		if( isset( $_GET['action'] ) && $_GET['action'] == 'duplicate' && ! empty( $_GET['bdpp-style'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'bdpp-duplicate-style' ) ) {

			$clone_id		= $_GET['bdpp-style'];
			$styles_data	= bdpp_get_style_data();
			$clone_data		= isset( $styles_data[ $clone_id ] ) ? $styles_data[ $clone_id ] : false;

			// Check if clone id entry is there or not
			if( $clone_data ) {
				
				$style_id 			= ( max( array_keys($styles_data) ) + 1 );
				$clone_data['id']	= $style_id;

				$styles_data[ $style_id ] = $clone_data;
				update_option( 'bdpp_styles_data', $styles_data, false );

				$redirect_url = add_query_arg( array( 'page' => 'bdpp-styles', 'message' => '2' ), admin_url( 'admin.php' ) );
				wp_redirect( $redirect_url );
				exit;
			}
		}
	}
}

// Process Style Manager
add_action( 'admin_init', 'bdpp_process_style_manager' );

/**
 * Function generate style from style ID based on type and identifier
 * 
 * @since 1.0.1
 */
function bdpp_generate_style( $style_id = 0, $type = '', $identifier_type = '', $identifier = '', $atts = array(), $echo = true ) {
	
	if( empty( $style_id ) ) {
		return false;
	}

	// Taking some data
	$bdpp_styles_data = bdpp_get_style_data();

	if( ! isset( $bdpp_styles_data[ $style_id ] ) ) {
		return false;
	}

	// Taking some variables
	$style				= '';
	$default_style_data = bdpp_default_style_data();
	$style_data			= $bdpp_styles_data[ $style_id ];
	$style_data			= wp_parse_args( $style_data, $default_style_data );

	// General Style
	if( $style_data['title_font_size'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-title {font-size: {$style_data['title_font_size']}px !important;}";
	}
	if( $style_data['title_lineheight'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-title {line-height: {$style_data['title_lineheight']}px !important;}";
	}
	if( $style_data['post_title_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-title a,
				   .bdpp-style-mngr-{$style_id} .bdpp-post-title a:visited, bdpp-style-mngr-{$style_id} .bdpp-post-title a:focus
				   {color: {$style_data['post_title_clr']} !important;}";
	}
	if( $style_data['post_title_hclr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-title a:hover {color: {$style_data['post_title_hclr']} !important;}";
	}

	// Post Content Style	
	if( $style_data['cnt_font_size'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-desc, .bdpp-style-mngr-{$style_id} .bdpp-term-description{font-size: {$style_data['cnt_font_size']}px;}";
	}
	if( $style_data['cnt_lineheight'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-desc, .bdpp-style-mngr-{$style_id} .bdpp-term-description {line-height: {$style_data['cnt_lineheight']}px;}";
	}
	if( $style_data['cnt_font_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-desc, .bdpp-style-mngr-{$style_id} .bdpp-term-description {color: {$style_data['cnt_font_clr']} !important;}";
	}

	// Post Meta Styles
	if( $style_data['cat_font_size'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-cats a{font-size: {$style_data['cat_font_size']}px !important;}";
	}
	if( $style_data['cat_font_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-cat-link{color: {$style_data['cat_font_clr']} !important; padding:3px 5px !important;}";
	}
	if( $style_data['cat_font_hclr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-cat-link:hover, .bdpp-style-mngr-{$style_id} .bdpp-post-cat-link:focus, .bdpp-style-mngr-{$style_id} .bdpp-post-cat-link:active{color: {$style_data['cat_font_hclr']} !important;}";
	}
	if( $style_data['cat_bg_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-cat-link{background: {$style_data['cat_bg_clr']} !important; border:0px;}";
	}
	if( $style_data['cat_bg_hclr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-cat-link:hover, .bdpp-style-mngr-{$style_id} .bdpp-post-cat-link:focus, .bdpp-style-mngr-{$style_id} .bdpp-post-cat-link:active{background: {$style_data['cat_bg_hclr']} !important;  border:0px;}";
	}
	if( $style_data['meta_font_size'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-meta span  {font-size: {$style_data['meta_font_size']}px !important;}";
	}
	if( $style_data['meta_font_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-meta span, .bdpp-style-mngr-{$style_id} .bdpp-post-meta, .bdpp-style-mngr-{$style_id} .bdpp-post-meta .bdpp-post-tags a.bdpp-post-cat-link {color: {$style_data['meta_font_clr']} !important;}";
	}
	if( $style_data['meta_icon_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-meta i.fa{color: {$style_data['meta_icon_clr']};}";
	}
	if( $style_data['disable_img_zoom'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-post-img-bg:hover img {-webkit-transform: none;transform: none;}";
	}

	// Read More Style
	if( $style_data['rdm_font_size'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn {font-size: {$style_data['rdm_font_size']}px;}";
	}
	if( $style_data['rdm_font_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn {color: {$style_data['rdm_font_clr']} !important;}";
	}
	if( $style_data['rdm_font_hclr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:hover, .bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:focus, .bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:active {color: {$style_data['rdm_font_hclr']} !important;}";
	}
	if( $style_data['rdm_bg_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn {background-color: {$style_data['rdm_bg_clr']} !important;}";
	}
	if( $style_data['rdm_bg_hclr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:hover, .bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:focus, .bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:active  {background-color: {$style_data['rdm_bg_hclr']} !important;}";
	}
	if( $style_data['rdm_border_clr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn {border-color: {$style_data['rdm_border_clr']} !important;}";
	}
	if( $style_data['rdm_border_hclr'] ) {
		$style .= ".bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:hover, .bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:focus, .bdpp-style-mngr-{$style_id} .bdpp-rdmr-btn:active  {border-color: {$style_data['rdm_border_hclr']} !important;}";
	}

	// Slider Style
	if( $identifier_type == 'slider' ) {
		if( $style_data['slider_arw_clr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .owl-nav .owl-prev, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next, .bdpp-style-mngr-{$style_id} .post-vticker-up, .bdpp-style-mngr-{$style_id} .post-vticker-down{color: {$style_data['slider_arw_clr']};}";
		}
		if( $style_data['slider_arw_hclr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:hover, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:hover, .bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:focus, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:focus, .bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:active, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:active, .bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:focus, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:focus, .bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:active, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:active, .bdpp-style-mngr-{$style_id} .post-vticker-up:hover, .bdpp-style-mngr-{$style_id} .post-vticker-down:hover, .bdpp-style-mngr-{$style_id} .post-vticker-up:focus, .bdpp-style-mngr-{$style_id} .post-vticker-down:focus, .bdpp-style-mngr-{$style_id} .post-vticker-up:active, .bdpp-style-mngr-{$style_id} .post-vticker-down:active{color: {$style_data['slider_arw_hclr']};}";
		}
		if( $style_data['slider_arw_bg_clr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .owl-nav .owl-prev, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next, .bdpp-style-mngr-{$style_id} .post-vticker-up, .bdpp-style-mngr-{$style_id} .post-vticker-down{background-color: {$style_data['slider_arw_bg_clr']};}";
		}
		if( $style_data['slider_arw_bg_hclr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:hover, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:hover, .bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:focus, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:focus, .bdpp-style-mngr-{$style_id} .owl-nav .owl-prev:active, .bdpp-style-mngr-{$style_id} .owl-nav .owl-next:active, .bdpp-style-mngr-{$style_id} .post-vticker-up:hover, .bdpp-style-mngr-{$style_id} .post-vticker-down:hover, .bdpp-style-mngr-{$style_id} .post-vticker-up:focus, .bdpp-style-mngr-{$style_id} .post-vticker-down:focus, .bdpp-style-mngr-{$style_id} .post-vticker-up:active, .bdpp-style-mngr-{$style_id} .post-vticker-down:active{background-color: {$style_data['slider_arw_bg_hclr']};}";
		}
		if( $style_data['slider_dots_clr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .owl-dots .owl-dot{background: {$style_data['slider_dots_clr']};}";
		}
		if( $style_data['slider_dots_aclr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .owl-dots .owl-dot.active{background: {$style_data['slider_dots_aclr']};}";
		}
		
	}

	// Timeline Style
	if( $type = 'shortcode' && $identifier == 'bdp_timeline' ) {

		if( $style_data['tmnl_theme_clr'] ) {
			$style .= ".bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-tmln-inr-wrap::before, .bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-timeline::before, .bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-timeline::after, .bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-timeline:first-child:before, .bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-timeline:last-child:before{background: {$style_data['tmnl_theme_clr']};}";
			$style .= ".bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-tmln-icon, 
					   .bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-tmln-content{border-color: {$style_data['tmnl_theme_clr']};}
					   .bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-timeline::after{color: {$style_data['tmnl_theme_clr']};}";

			if( $atts['design'] == 'design-1' ) {
				$style .= ".bdpp-design-1.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::after, 
						   .bdpp-design-1.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::before{border-color: {$style_data['tmnl_theme_clr']};}";
			}

			if( $atts['design'] == 'design-2' ) {
				$style .= ".bdpp-design-2.bdpp-style-mngr-{$style_id} .bdpp-timeline{border-color: {$style_data['tmnl_theme_clr']} !important; }";
			}

			if( $atts['design'] == 'design-6' ) {
				$style .= ".bdpp-design-6.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::after, 
						   .bdpp-design-6.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::before{border-color: {$style_data['tmnl_theme_clr']};}";
			}

			if( $atts['design'] == 'design-8' ) {
				$style .= ".bdpp-design-8.bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-timeline:first-child .bdpp-tmln-icon, .bdpp-design-8.bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-timeline:last-child .bdpp-tmln-icon{background: {$style_data['tmnl_theme_clr']}; box-shadow: 0 0 0 2px {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-8.bdpp-style-mngr-{$style_id} .bdpp-tmln-icon{background: {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-8.bdpp-style-mngr-{$style_id} .bdpp-border{border-color: {$style_data['tmnl_theme_clr']} !important; }";
			}

			if( $atts['design'] == 'design-7' ) {
				$style .= ".bdpp-design-7.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::after, 
						   .bdpp-design-7.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::before{border-color: {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-7.bdpp-style-mngr-{$style_id} .bdpp-timeline:hover .bdpp-tmln-icon::before{background: {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-7.bdpp-style-mngr-{$style_id} .bdpp-timeline:hover .bdpp-tmln-content::before{background: {$style_data['tmnl_theme_clr']}; border-color: {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-7.bdpp-style-mngr-{$style_id} .bdpp-timeline:first-child:before, .bdpp-design-7.bdpp-style-mngr-{$style_id} .bdpp-timeline:last-child:before, .bdpp-design-9.bdpp-style-mngr-{$style_id} .bdpp-timeline:first-child:before, .bdpp-design-9.bdpp-style-mngr-{$style_id} .bdpp-timeline:last-child:before {box-shadow: 0 0 0 2px {$style_data['tmnl_theme_clr']};}";
			}

			if( $atts['design'] == 'design-9' ) {
				$style .= ".bdpp-design-9.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::after, 
						   .bdpp-design-9.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::before{border-color: {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-9.bdpp-style-mngr-{$style_id} .bdpp-timeline:hover .bdpp-tmln-icon::before{background: {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-9.bdpp-style-mngr-{$style_id} .bdpp-timeline:hover .bdpp-tmln-content::before{background: {$style_data['tmnl_theme_clr']}; border-color: {$style_data['tmnl_theme_clr']};}
						   .bdpp-design-9.bdpp-style-mngr-{$style_id} .bdpp-tmln-content:after{background: {$style_data['tmnl_theme_clr']}; }";
			}
		}

		if( $style_data['tmnl_pbg_clr'] ) {
			$style .= ".bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-tmln-content{background: {$style_data['tmnl_pbg_clr']} !important;}";
			$style .= ".bdpp-design-2.bdpp-style-mngr-{$style_id} .bdpp-tmln-icon{background: {$style_data['tmnl_pbg_clr']} !important; border:0px !important;}
					   .bdpp-design-2.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::after, .bdpp-design-2.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::before{background: {$style_data['tmnl_pbg_clr']} !important;}";
			$style .= ".bdpp-design-3.bdpp-style-mngr-{$style_id} .bdpp-tmln-content::after{border-top-color: {$style_data['tmnl_pbg_clr']} !important;}";
			$style .= ".bdpp-design-5.bdpp-style-mngr-{$style_id} .bdpp-tmln-content{background: none !important;}
					   .bdpp-design-5.bdpp-style-mngr-{$style_id} .bdpp-tmln-content .bdpp-tmln-bottom-content{padding:15px;background:{$style_data['tmnl_pbg_clr']} !important;}";
			$style .= ".bdpp-design-8.bdpp-style-mngr-{$style_id} .bdpp-tmln-content-inner{padding:15px;}";					   
		}

		if( $style_data['tmnl_icon_clr'] ) {
			$style .= ".bdpp-tmln-wrap.bdpp-style-mngr-{$style_id} .bdpp-post-icon{color: {$style_data['tmnl_icon_clr']};}";
		}
	}

	// Category Shortcode Style
	if( $type = 'shortcode' && ( $identifier == 'bdp_cat_grid' || $identifier == 'bdp_cat_slider' ) ) {
		if( $style_data['cat_shrt_fsize'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-title a{font-size: {$style_data['cat_shrt_fsize']}px;}";
		}
		if( $style_data['cat_shrt_title_clr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-title a{color: {$style_data['cat_shrt_title_clr']};}";
		}
		if( $style_data['cat_shrt_title_bclr'] ) {
			$style .= ".bdpp-design-1.bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-title, .bdpp-design-2.bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-title, .bdpp-design-3.bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-title, .bdpp-design-4.bdpp-style-mngr-{$style_id} .bdpp-term-inner .term-heading-main {background: {$style_data['cat_shrt_title_bclr']};}";
		}
		if( $style_data['cat_shrt_count_fsize'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-count{font-size: {$style_data['cat_shrt_count_fsize']}px !important;}";
		}
		if( $style_data['cat_shrt_count_clr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-count{color: {$style_data['cat_shrt_count_clr']} !important;}";
		}
		if( $style_data['cat_shrt_count_bclr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-term-inner .bdpp-term-count{background: {$style_data['cat_shrt_count_bclr']};}";
		}
	}

	// Pagination Style
	if( ! empty( $atts['pagination'] ) ) {

		if( $style_data['pagi_theme_clr']) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-paging a{background-color: {$style_data['pagi_theme_clr']}; border-color: {$style_data['pagi_theme_clr']};}
					   .bdpp-style-mngr-{$style_id} .bdpp-paging .page-numbers.current{border-color: {$style_data['pagi_theme_clr']};}
					   .bdpp-style-mngr-{$style_id} .bdpp-paging .page-numbers.dots{color: {$style_data['pagi_theme_clr']};}";
		}
		if( $style_data['pagi_theme_h_clr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-paging a:hover, .bdpp-style-mngr-{$style_id} .bdpp-paging a:focus{background: {$style_data['pagi_theme_h_clr']}; border-color: {$style_data['pagi_theme_h_clr']}}";
		}
		if( $style_data['pagi_themef_clr']) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-paging a{color: {$style_data['pagi_themef_clr']} !important;}";
		}
		if( $style_data['pagi_themef_h_clr'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-paging a:hover, .bdpp-style-mngr-{$style_id} .bdpp-paging a:focus{color: {$style_data['pagi_themef_h_clr']} !important;}";
		}
		if( $style_data['pagi_active_clr']) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-paging .page-numbers.current{background-color: {$style_data['pagi_active_clr']}; border-color: {$style_data['pagi_active_clr']};}";
		}
		if( $style_data['pagi_activef_clr']) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-paging .page-numbers.current{color: {$style_data['pagi_activef_clr']};}";
		}
		if( $style_data['pagi_font_size'] ) {
			$style .= ".bdpp-style-mngr-{$style_id} .bdpp-paging a, .bdpp-style-mngr-{$style_id} .bdpp-paging .page-numbers{font-size: {$style_data['pagi_font_size']}px;}";
		}

		if( isset( $atts['pagination_type'] ) && ( $atts['pagination_type'] == 'load-more' || $atts['pagination_type'] == 'prev-next-ajax' ) ) {
			if( $style_data['pagi_theme_clr']) {
				$style .= ".bdpp-style-mngr-{$style_id} .bdpp-ajax-btn-style{background-color: {$style_data['pagi_theme_clr']}; border-color: {$style_data['pagi_theme_clr']};}";
			}
			if( $style_data['pagi_theme_h_clr'] ) {
				$style .= ".bdpp-style-mngr-{$style_id} .bdpp-ajax-btn-style:hover, .bdpp-style-mngr-{$style_id} .bdpp-ajax-btn-style:focus{background: {$style_data['pagi_theme_h_clr']}; border-color: {$style_data['pagi_theme_h_clr']}}";
			}
			if( $style_data['pagi_themef_clr']) {
				$style .= ".bdpp-style-mngr-{$style_id} .bdpp-ajax-btn-style{color: {$style_data['pagi_themef_clr']} !important;}";
			}
			if( $style_data['pagi_themef_h_clr'] ) {
				$style .= ".bdpp-style-mngr-{$style_id} .bdpp-ajax-btn-style:hover, .bdpp-style-mngr-{$style_id} .bdpp-ajax-btn-style:focus{color: {$style_data['pagi_themef_h_clr']} !important;}";
			}
			if( $style_data['pagi_font_size'] ) {
				$style .= ".bdpp-style-mngr-{$style_id} .bdpp-ajax-btn-style{font-size: {$style_data['pagi_font_size']}px;}";
			}
		}
	}	

	// Start Style
	$style_css = '<style type="text/css">';
	$style_css .= apply_filters( 'bdpp_style_mngr_css', $style, $style_id, $style_data, $type, $identifier, $atts );
	$style_css .= '</style>';

	if( $echo ) {
		echo $style_css;
	} else {
		return $style_css;
	}
}
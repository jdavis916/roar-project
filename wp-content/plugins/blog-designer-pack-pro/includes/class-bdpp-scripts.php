<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BDPP_Scripts {

	function __construct() {

		// Action for admin scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'bdpp_admin_script_style' ) );
		
		// Action for public styles
		add_action( 'wp_enqueue_scripts', array( $this, 'bdpp_public_styles' ) );
		
		// Action for public scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'bdpp_public_scripts' ) );

		// Action to add custom css in head
		add_action( 'wp_head', array($this, 'bdpp_render_custom_css'), 20 );

		// Action to add admin script and style when edit with elementor at front side
		add_action( 'elementor/editor/after_enqueue_scripts', array($this, 'bdpp_admin_elementor_script_style') );
	}

	/**
	 * Registring and enqueing admin sctipts and styles
	 *
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	public function  bdpp_admin_script_style( $hook_suffix ) {
		
		global $wp_query, $current_user, $post_type, $post, $taxonomy;

		$post_sorting		= 0;
		$bdpp_taxonomy		= is_string( $taxonomy ) ? $taxonomy : false;
		$general_post_types = bdpp_get_option( 'post_types', array() );
		$trend_post_types 	= bdpp_get_option( 'trend_post_types', array() );
		$allowed_post_types = array_merge( $general_post_types, $trend_post_types );
		$allowed_post_types = array_unique( $allowed_post_types );
		$allowed_taxonomy	= bdpp_get_option( 'taxonomy', array() );

		// Post Sorting Flag
		if ( $post_type == BDPP_POST_TYPE && isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) {
			$post_sorting = 1;
		}

		$pages_arr = array( 'toplevel_page_bdpp-settings', BDPP_SCREEN_ID.'_page_bdpp-templates', BDPP_SCREEN_ID.'_page_bdpp-styles' );

		// Styles
		wp_register_style( 'bdpp-admin-style', BDPP_URL . 'assets/css/bdpp-admin.css', array(), BDPP_VERSION );

		// Scripts
		wp_register_script( 'bdpp-shrt-generator', BDPP_URL . 'assets/js/bdpp-shortcode-generator.js', array( 'jquery' ), BDPP_VERSION, true );
		wp_localize_script( 'bdpp-shrt-generator', 'Bdpp_Shrt_Generator', array(
																'shortcode_err' => esc_html__('Sorry, Something happened wrong. Kindly please be sure that you have choosen relevant shortcode from the dropdown.', 'blog-designer-pack'),
															));

		wp_register_script( 'bdpp-admin-script', BDPP_URL . 'assets/js/bdpp-admin.js', array( 'jquery' ), BDPP_VERSION, true );
		wp_localize_script( 'bdpp-admin-script', 'BdppAdmin', array(
																	'post_sorting'			=> $post_sorting,
																	'syntax_highlighting'	=> $current_user->syntax_highlighting,
																	'post_id'				=> isset( $post->ID ) ? $post->ID : 0,
																	'confirm_msg'			=> esc_html__('Are you sure you want to do this?', 'blog-designer-pack'),
																	'reset_msg'				=> esc_html__('Click OK to reset all options. All settings will be lost!', 'blog-designer-pack'),
																	'reset_post_view_msg'	=> esc_html__('Click OK to reset post view count. This process can not be undone!', 'blog-designer-pack'),
																	'wait_msg'				=> esc_html__('Please Wait...', 'blog-designer-pack'),
																));

		// Post Sorting
		if ( $post_sorting ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		// Allowed Taxonomy Screen OR widget screen when elementor is installed
		if ( (defined('ELEMENTOR_PLUGIN_BASE') && $hook_suffix == 'widgets.php') || isset( $allowed_taxonomy[$bdpp_taxonomy] ) || $hook_suffix == BDPP_SCREEN_ID.'_page_bdpp-styles' ) {
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
		}

		// Post Screen, Taxonomy Screen and Widget Screen
		if( ($hook_suffix == 'widgets.php') || (isset( $allowed_taxonomy[$bdpp_taxonomy] )) || (in_array( $post_type, $allowed_post_types ) && ( $hook_suffix == 'edit.php' || $hook_suffix == 'post.php' || $hook_suffix == 'post-new.php' )) ) {
			wp_enqueue_style( 'bdpp-admin-style' ); 	// Admin Styles
			wp_enqueue_script( 'bdpp-admin-script' );	// Admin Script
			wp_enqueue_media();
		}

		if( in_array( $hook_suffix, $pages_arr ) ) {

			// Admin Styles
			wp_enqueue_style( 'bdpp-admin-style' );

			/* --------------------------------- */

			// Admin Scripts
			if( ! empty( $_GET['tab'] ) && $_GET['tab'] == 'css' ) {
				wp_enqueue_code_editor( array(
					'type' 			=> 'text/css',
					'codemirror' 	=> array(
						'indentUnit' 	=> 2,
						'tabSize'		=> 2,
					),
				) );
			}

			wp_enqueue_script( 'postbox' );
			wp_enqueue_script( 'bdpp-admin-script' );
			wp_enqueue_media();
		}

		// Shortcode Builder
		if( $hook_suffix == BDPP_SCREEN_ID.'_page_bdpp-shrt-generator' ) {
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style( 'bdpp-admin-style' );

			wp_enqueue_script('shortcode');
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script( 'bdpp-shrt-generator' );
		}

		// For VC Front End Page Editing
		if( function_exists('vc_is_frontend_editor') && vc_is_frontend_editor() ) {
			wp_register_script( 'bdpp-vc-frontend', BDPP_URL . 'assets/js/vc/bdpp-vc-frontend.js', array(), BDPP_VERSION, true );
			wp_enqueue_script( 'bdpp-vc-frontend' );
		}
	}

	/**
	 * Registring and enqueing public styles
	 *
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	public function bdpp_public_styles() {

		// Registring and enqueing slick slider css
		if( ! wp_style_is( 'owl-carousel', 'registered' ) && bdpp_get_option('disable_owl_css') == 0 ) {
			wp_register_style( 'owl-carousel', BDPP_URL.'assets/css/owl.carousel.min.css', array(), BDPP_VERSION );
			wp_enqueue_style( 'owl-carousel' );
		}
		
		// Registring slick slider script
		if( ! wp_script_is( 'jquery-vticker', 'registered' ) ) {
			wp_register_script( 'jquery-vticker', BDPP_URL. 'assets/js/post-vticker.min.js', array('jquery'), BDPP_VERSION, true);
		}

		// Registring and enqueing font awesome css
		if( bdpp_get_option('disable_font_awsm_css') == 0 ) {
			wp_register_style( 'font-awesome', BDPP_URL . 'assets/css/font-awesome.min.css', array(), BDPP_VERSION );
			wp_enqueue_style( 'font-awesome' );
		}

		// Registring and enqueing public script
		wp_register_style( 'bdpp-public-style', BDPP_URL . 'assets/css/bdpp-public.css', array(), BDPP_VERSION );
		wp_enqueue_style( 'bdpp-public-style' );
	}

	/**
	 * Registring and enqueing public scripts
	 *
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	public  function bdpp_public_scripts() {

		global $post;

		$trend_post_types = bdpp_get_option( 'trend_post_types', array() );

		// Taking post id to update post view count
		$post_id 	= isset($post->ID) ? $post->ID : '';
		$trend_post	= 0;

		// If post type is allowed for trending
		if( ! empty( $post_id ) && !empty($trend_post_types) && is_singular($trend_post_types) && !is_preview() && !is_front_page() && !is_home() && !is_feed() && !is_robots() ) {
			$trend_post = $post_id;
		}

		// Registring slick slider script
		if( ! wp_script_is( 'jquery-owl-carousel', 'registered' ) ) {
			wp_register_script( 'jquery-owl-carousel', BDPP_URL. 'assets/js/owl.carousel.min.js', array('jquery'), BDPP_VERSION, true);
		}

		// Registring tooltip script
		if( ! wp_script_is( 'tooltipster', 'registered' ) ) {
			wp_register_script( 'tooltipster', BDPP_URL. 'assets/js/tooltipster.min.js', array('jquery'), BDPP_VERSION, true);
		}

		// Registring ticker script
		if( ! wp_script_is( 'bdpp-ticker-script', 'registered' ) ) {
			wp_register_script( 'bdpp-ticker-script', BDPP_URL . 'assets/js/bdpp-ticker.js', array('jquery'), BDPP_VERSION, true );
		}

		// Admin Script (Do not forgot to update for elementor script action also)
		wp_register_script( 'bdpp-public-script', BDPP_URL . 'assets/js/bdpp-public.js', array( 'jquery' ), BDPP_VERSION, true );
		wp_localize_script( 'bdpp-public-script', 'Bdpp', array( 
																'ajax_url' 			=> admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
																'is_mobile'			=> wp_is_mobile(),
																'is_rtl' 			=> ( is_rtl() ) ? 1 : 0,
																'trend_post'		=> $trend_post,
																'no_post_found_msg'	=> esc_html__('No more post to display.', 'blog-designer-pack'),
																'no_term_found_msg'	=> esc_html__('No more categories to display.', 'blog-designer-pack'),
																'vc_page_edit'		=> ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) ? 1 : 0,
															));

		// If trending post is enabled for post type
		if( $trend_post ) {
			wp_enqueue_script( 'bdpp-public-script' );
		}

		/*===== Page Builder Scripts =====*/
		// VC Front End Page Editing
		if ( function_exists('vc_is_page_editable') && vc_is_page_editable() ) {
			wp_enqueue_script('masonry');
			wp_enqueue_script( 'tooltipster' );
			wp_enqueue_script( 'jquery-owl-carousel' );
			wp_enqueue_script( 'bdpp-ticker-script' );
			wp_enqueue_script( 'bdpp-public-script' );
		}

		// Elementor Frontend Editing
		if ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_GET['elementor-preview'] ) && $post_id == (int) $_GET['elementor-preview'] ) {
			wp_register_script( 'bdpp-elementor-script', BDPP_URL . 'assets/js/elementor/bdpp-elementor.js', array(), BDPP_VERSION, true );

			wp_enqueue_script('masonry');
			wp_enqueue_script( 'tooltipster' );
			wp_enqueue_script( 'jquery-owl-carousel' );
			wp_enqueue_script( 'bdpp-ticker-script' );
			wp_enqueue_script( 'bdpp-public-script' );
			wp_enqueue_script( 'bdpp-elementor-script' );
		}
	}

	/**
	 * Add custom css to head
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_render_custom_css() {

		// Custom CSS
		$custom_css = bdpp_get_option('custom_css');

		if( !empty($custom_css) ) {
			$css  = '<style type="text/css">' . "\n";
			$css .= $custom_css;
			$css .= "\n" . '</style>' . "\n";
			
			echo $css;
		}
	}

	/**
	 * Add admin script and style when edit with elementor at front side
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_admin_elementor_script_style() {

		global $current_user, $post;

		// Admin Style
		wp_register_style( 'bdpp-admin-style', BDPP_URL . 'assets/css/bdpp-admin.css', array(), BDPP_VERSION );

		// Admin Script
		wp_register_script( 'bdpp-admin-script', BDPP_URL . 'assets/js/bdpp-admin.js', array( 'jquery' ), BDPP_VERSION, true );
		wp_localize_script( 'bdpp-admin-script', 'BdppAdmin', array(
																	'post_id'				=> isset( $post->ID ) ? $post->ID : 0,
																	'syntax_highlighting'	=> $current_user->syntax_highlighting,
																	'elementor'				=> 1,
																	'confirm_msg'			=> esc_html__('Are you sure you want to do this?', 'blog-designer-pack'),
																	'reset_msg'				=> esc_html__('Click OK to reset all options. All settings will be lost!', 'blog-designer-pack'),
																	'reset_post_view_msg'	=> esc_html__('Click OK to reset post view count. This process can not be undone!', 'blog-designer-pack'),
																	'wait_msg'				=> esc_html__('Please Wait...', 'blog-designer-pack'),
																));

		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style( 'bdpp-admin-style' ); 	// Admin Styles
		
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script( 'bdpp-admin-script' );	// Admin Script
	}
}
<?php
/**
 * Admin Class
 *
 * Handles the admin side functionality of plugin
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BDPP_Admin {
	
	function __construct() {

		// Allowed Post Types
		$allowed_post_types = bdpp_get_option( 'post_types', array() );

		// Action to register admin menu
		add_action( 'admin_menu', array( $this, 'bdpp_register_menu' ) );

		// Shortcode Preview
		add_action( 'current_screen', array($this, 'bdpp_generate_preview_screen') );

		// Admin prior processes
		add_action( 'admin_init', array( $this, 'bdpp_admin_init_process' ) );

		// Action to add sorting link at post listing page
		add_filter( 'views_edit-'.BDPP_POST_TYPE, array( $this, 'bdpp_post_sorting_link' ) );

		// Action to add `Save Order` button
		add_action( 'restrict_manage_posts', array( $this, 'bdpp_post_save_order' ) );		

		// Filter for post row data
		add_filter( 'post_row_actions', array($this, 'bdpp_manage_post_row_data'), 10, 2 );

		// Ajax action for post order update
		add_action( 'wp_ajax_bdpp_update_post_order', array( $this, 'bdpp_update_post_order' ) );

		// Ajax action for featured post
		add_action( 'wp_ajax_bdpp_featured_post', array( $this, 'bdpp_featured_post' ) );

		// Ajax action to reset post view count
		add_action( 'wp_ajax_bdpp_reset_post_view_count', array( $this, 'bdpp_reset_post_view_count' ) );

		// Ajax action to save shortcode template
		add_action( 'wp_ajax_bdpp_save_shortcode_tmpl', array( $this, 'bdpp_save_shortcode_tmpl' ) );
		
		// Ajax action to get post taxonomy
		add_action( 'wp_ajax_bdpp_ajax_get_post_taxonomy', array( $this, 'bdpp_ajax_get_post_taxonomy' ) );
		
		// Ajax action to get post type based on display type
		add_action( 'wp_ajax_bdpp_ajax_get_post_types', array( $this, 'bdpp_ajax_get_post_types' ) );

		// Loop of allowed post types
		if( !empty( $allowed_post_types ) ) {
			foreach ($allowed_post_types as $post_key => $post_val) {

				// Action to add custom column to post listing
				add_filter( "manage_{$post_val}_posts_columns", array( $this, 'bdpp_manage_posts_columns') );

				// Action to add custom column data to post listing
				add_action( "manage_{$post_val}_posts_custom_column", array( $this, 'bdpp_manage_post_columns_data' ), 10, 2 );
			}
		}		
	}

	/**
	 * Function to register admin menus
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_register_menu() {

		// Getting Started Page
		add_menu_page( __('Blog Designer Pack Pro', 'blog-designer-pack'), __('Blog Designer Pack', 'blog-designer-pack'), 'manage_options', 'bdpp-settings', array($this, 'bdpp_plugin_settings'), 'dashicons-editor-bold' );

		// Shortcode Builder
		add_submenu_page( 'bdpp-settings', __('Shortcode Builder - Blog Designer Pack Pro', 'blog-designer-pack'), __('Shortcode Builder', 'blog-designer-pack'), 'manage_options', 'bdpp-shrt-generator', array($this, 'bdpp_shortcode_generator') );

		// Template Manager
		add_submenu_page( 'bdpp-settings', __('Shortcode Templates - Blog Designer Pack Pro', 'blog-designer-pack'), __('Shortcode Templates', 'blog-designer-pack'), 'manage_options', 'bdpp-templates', array($this, 'bdpp_template_manager_page') );

		// Style Manager
		add_submenu_page( 'bdpp-settings', __('Style Manager - Blog Designer Pack Pro', 'blog-designer-pack'), __('Style Manager', 'blog-designer-pack'), 'manage_options', 'bdpp-styles', array($this, 'bdpp_style_manager_page') );

		// Shortcode Preview
		add_submenu_page( null, __('Shortcode Preview - Blog Designer Pack Pro', 'blog-designer-pack'), __('Shortcode Preview', 'blog-designer-pack'), 'manage_options', 'bdpp-shortcode-preview', array($this, 'bdpp_shortcode_preview_page') );
	}

	/**
	 * Plugin Setting Page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_plugin_settings() {
		include_once( BDPP_DIR . '/includes/admin/settings/bdpp-settings.php' );
	}

	/**
	 * Plugin Shortcode Builder Page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_shortcode_generator() {
		include_once( BDPP_DIR . '/includes/admin/shortcode-generator/shortcode-generator.php' );
	}

	/**
	 * Plugin Template Manager Page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_template_manager_page() {
		include_once( BDPP_DIR . '/includes/admin/shortcode-generator/shortcode-template-list.php' );
	}

	/**
	 * Plugin Style Manager Page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0.1
	 */
	function bdpp_style_manager_page() {

		if( isset( $_GET['action'] ) && ( $_GET['action'] == 'add' || $_GET['action'] == 'edit' ) ) {
			include_once( BDPP_DIR . '/includes/style-manager/styles-form.php' );
		} else {
			include_once( BDPP_DIR . '/includes/style-manager/styles-list.php' );
		}
	}

	/**
	 * Handle plugin shoercode preview
	 * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	function bdpp_shortcode_preview_page() {
	}

	/**
	 * Handle plugin shoercode preview
	 * 
	 * @package Blog Designer Pack Pro
 	 * @since 1.0
	 */
	function bdpp_generate_preview_screen( $screen ) {
		if( $screen->id == 'admin_page_bdpp-shortcode-preview' ) {
			include_once( BDPP_DIR . '/includes/admin/shortcode-generator/shortcode-preview.php' );
			exit;
		}
	}

	/**
	 * Admin prior processes
	 *
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_admin_init_process() {
		
		// Shortcode Template Delete
		if( ( (isset( $_GET['action'] ) && $_GET['action'] == 'delete' ) || (isset( $_GET['action2'] ) && $_GET['action2'] == 'delete' ) )
			&& isset($_GET['page']) && $_GET['page'] == 'bdpp-templates'
			&& !empty( $_GET['bdpp_tmpl'] ) ) {

			// Get bulk array from $_GET
			$tmpl_ids		= $_GET['bdpp_tmpl'];
			$template_data	= get_option( 'bdpp_shrt_tmpl' );

			// Check if we do not get array of IDs
			if( ! is_array( $tmpl_ids ) ) {
				$tmpl_ids = array( $tmpl_ids );
			}

			// Loop to delete logs
			foreach ( $tmpl_ids as $tmpl_id ) {
				unset( $template_data[ $tmpl_id ] );
			}

			update_option( 'bdpp_shrt_tmpl', $template_data, false );

			$redirect_url = add_query_arg( array( 'page' => 'bdpp-templates', 'message' => '1' ), admin_url( 'admin.php' ) );
			wp_redirect( $redirect_url );
			exit;
		}
	}

	/**
	 * Add 'Sort Post' link at post listing page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_post_sorting_link( $views ) {

	    global $wp_query;

	    // Add sorting link
	    if( !isset( $views['bdpp_sort'] ) && current_user_can( 'edit_others_posts' ) ) {
	    	$class 				= ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) ? 'current' : '';
			$query_string		= remove_query_arg(array( 'orderby', 'order' ));
			$query_string		= add_query_arg( array('orderby' => urlencode('menu_order title'), 'order' => urlencode('ASC') ), $query_string );
			$views['bdpp_sort'] = '<a href="' . esc_url( $query_string ) . '" class="' . esc_attr( $class ) . '">' . __( 'Sort Posts', 'blog-designer-pack' ) . '</a>';
	    }

	    return $views;
	}

	/**
	 * Add 'Save Sort Order' button at post listing page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_post_save_order() {

		global $typenow, $wp_query;

		if( $typenow == BDPP_POST_TYPE && isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'menu_order title' ) {

			$html  = '';
			$html .= "<span class='spinner bdpp-spinner'></span>";
			$html .= "<input type='button' name='bdpp_save_order' class='button button-secondary right bdpp-post-save-order' id='bdpp-post-save-order' value='".__('Save Sort Order', 'blog-designer-pack')."' />";
			echo $html;
		}
	}

	/**
	 * Manage custom columns to post listing page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_manage_posts_columns( $columns ) {

		global $post_type;

		if( $post_type == 'post' ) {
			$new_columns['bdpp_post_order'] = __('Order', 'blog-designer-pack');
		}
		$new_columns['bdpp_feat'] = __('Featured', 'blog-designer-pack');

		$columns = bdpp_add_array( $columns, $new_columns, 2, true );

	    return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_manage_post_columns_data( $column, $post_id ) {

	    global $post_type, $post, $wp_query;

	    // Menu Order column
	    if( $post_type == 'post' && $column == 'bdpp_post_order' ) {
	        $post_menu_order = isset($post->menu_order) ? $post->menu_order : '';

	        echo $post_menu_order;

	       	if ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) {
	       		echo "<input type='hidden' value='{$post_id}' name='bdpp_post[]' class='bdpp-post-order' id='bdpp-post-order-{$post_id}' />";
	    	}
	    }

	    // Featured column
	    if( $column == 'bdpp_feat' ) {
	    	$prefix 	= BDPP_META_PREFIX;
	    	$is_feat 	= get_post_meta( $post_id, $prefix.'feat_post', true );
	    	$feat_cls	= ( $is_feat ) ? 'dashicons-star-filled' : 'dashicons-star-empty';

	    	echo "<i data-id='{$post_id}' class='dashicons {$feat_cls} bdpp-post-feat'></i>";
	    }
	}

	/**
	 * Manage post row actions at post listing page
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_manage_post_row_data( $actions, $post ) {
		
		if( $post->post_type == BDPP_POST_TYPE ) {
			return array_merge( array( 'post_id' => esc_html__('ID:', 'blog-designer-pack') .' '. $post->ID ), $actions );
		}
		return $actions;
	}

	/**
	 * Update Post Order
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_update_post_order() {

		// Taking some defaults
		$result 			= array();
		$result['success'] 	= 0;
		$result['msg'] 		= esc_html__('Sorry, Something happened wrong.', 'blog-designer-pack');

		if( !empty($_POST['form_data']) ) {

			$form_data 		= parse_str($_POST['form_data'], $output_arr);
			$bdpp_posts 	= !empty($output_arr['bdpp_post']) ? $output_arr['bdpp_post'] : '';

			if( !empty($bdpp_posts) ) {

				$post_menu_order = 0;

				// Loop od ids
				foreach ($bdpp_posts as $post_key => $bdpp_post) {
					
					// Update post order
					$update_post = array(
						'ID'           => $bdpp_post,
						'menu_order'   => $post_menu_order,
					);

					// Update the post into the database
					wp_update_post( $update_post );

					$post_menu_order++;
				}

				$result['success'] 	= 1;
				$result['msg'] 		= esc_html__('Posts order saved successfully.', 'blog-designer-pack');
			}
		}
		wp_send_json($result);
	}

	/**
	 * Process Featured Post
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_featured_post() {

		// Taking some defaults
		$prefix		= BDPP_META_PREFIX;
		$post_id 	= bdpp_clean_number( $_POST['post_id'] );
		$feat_val	= ( !empty( $_POST['is_feat'] ) ) ? 0 : 1;
		$result 	= array(
						'success' 	=> 0,
						'msg'		=> esc_html__('Sorry, Something happened wrong.', 'blog-designer-pack')
					);

		if( !empty( $post_id ) ) {
			update_post_meta( $post_id, $prefix.'feat_post', $feat_val );

			$result['success'] 	= 1;
			$result['feat_val'] = $feat_val;
			$result['msg'] 		= ( $feat_val ) ? esc_html__('Post marked as a featured', 'blog-designer-pack') : __('Post removed from featured', 'blog-designer-pack');
		}

		wp_send_json($result);
	}

	/**
	 * Process to rset post view count
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_reset_post_view_count() {

		$result = array( 
					'status'	=> 0,
					'msg'		=> esc_html__('Sorry, Something happened wrong.', 'blog-designer-pack'),
				);

		$prefix		= BDPP_META_PREFIX;
		$post_id 	= isset( $_POST['post_id'] ) ? bdpp_clean_number( $_POST['post_id'] ) : 0;

		if( !empty( $post_id ) ) {

			// Reset view
			update_post_meta( $post_id, $prefix.'post_views', '' );

			$result['status'] 	= 1;
			$result['msg'] 		= esc_html__('Post view count has been reset successfully.', 'blog-designer-pack');
		}
		wp_send_json($result);
	}

	/**
	 * Process to save shortcode template
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_save_shortcode_tmpl() {

		$result = array(
					'status'	=> 0,
					'msg'		=> esc_html__('Sorry, Something happened wrong.', 'blog-designer-pack'),
				);

		if( !empty($_POST['form_data']) && !empty($_POST['shortcode']) && !empty($_POST['type']) ) {

			$form_data 	= parse_str($_POST['form_data'], $output_arr);
			$enable		= !empty( $output_arr['bdpp_tmpl_enable'] )	? 1 : 0;
			$tmpl_name	= !empty($output_arr['bdpp_tmpl_name']) ? bdpp_clean( $output_arr['bdpp_tmpl_name'] ) : __('Template', 'blog-designer-pack');
			$type		= bdpp_clean( $_POST['type'] );
			$shortcode	= bdpp_clean( $_POST['shortcode'] );
			$tmpl_id	= bdpp_clean_number( $_POST['tmpl_id'], 0 );

			$saved_tmpls 	= get_option('bdpp_shrt_tmpl');
			$saved_tmpls 	= ( !empty( $saved_tmpls ) && is_array( $saved_tmpls ) ) ? $saved_tmpls : array();
			
			if( $tmpl_id ) {
				$arr_id			= $tmpl_id;
				$msg			= esc_html__('Template updated. Please Wait...', 'blog-designer-pack');
			} else {
				$arr_id			= !empty( $saved_tmpls ) ? (max( array_keys($saved_tmpls) ) + 1) : 1;
				$msg			= esc_html__('Template successfully created. Please Wait...', 'blog-designer-pack');
			}

			$saved_tmpls[$arr_id] = array(
										'id' 		=> $arr_id,
										'enable'	=> $enable,
										'name'		=> $tmpl_name,
										'type'		=> $type,
										'shortcode'	=> $shortcode,
									);

			// Update templates
			update_option( 'bdpp_shrt_tmpl', $saved_tmpls, false );

			$result = array(
					'status'		=> 1,
					'msg'			=> $msg,
					'tmpl_id'		=> $arr_id,
					'redirect_url'	=> add_query_arg( array('page' => 'bdpp-shrt-generator', 'shortcode' => $type, 'tmpl_id' => $arr_id), admin_url('admin.php') ),
				);
		}

		wp_send_json($result);
	}

	/**
	 * Process to get post taxonomy
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_ajax_get_post_taxonomy() {

		$result = array(
					'status'	=> 0,
					'msg'		=> esc_html__('Sorry, Something happened wrong.', 'blog-designer-pack'),
				);
		$post_type			= bdpp_clean( $_POST['post_type'] );
		$taxonomy_objects 	= get_object_taxonomies( $post_type, 'object' );

		$result = array(
			'status'	=> 1,
			'msg'		=> esc_html__('Success', 'blog-designer-pack'),
			'taxonomy'	=> bdpp_get_taxonomy_options($taxonomy_objects),
		);

		wp_send_json( $result );
	}

	/**
	 * Process to get post type based on display type
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_ajax_get_post_types() {

		$output				= '';
		$type 				= bdpp_clean( $_POST['type'] );
		$saved_posts 		= ( $type == 'trending' ) ? bdpp_get_option( 'trend_post_types', array() ) : bdpp_get_option( 'post_types', array() );
		$support_post_types = bdpp_get_post_types();

		if( !empty( $saved_posts ) ) {
			foreach($saved_posts as $post_key => $post_val) {
				if( isset( $support_post_types[ $post_val ] ) ) {
					$output .= '<option value="'. $post_val .'">'. $support_post_types[ $post_val ] . '</option>';
				}
			}
		} else {
			$output .= '<option value="">'.esc_html__('No Post Type Found', 'blog-designer-pack').'</option>';
		}

		$result = array(
					'status' 	=> 1,
					'post_type'	=> $output,
				);

		wp_send_json( $result );
	}    
}

$bdpp_admin = new BDPP_Admin();
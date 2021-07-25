<?php
/**
 * Metabox Class
 *
 * Handles the admin side functionality of plugin
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BDPP_MetaBox {

	function __construct() {

		// Action to register admin menu
		add_action( 'add_meta_boxes', array( $this, 'bdpp_add_meta_box' ) );

		// Action to save the post meta fields
		add_action( 'save_post', array( $this, 'bdpp_save_post_settings' ), 10, 2 );
	}

	/**
	 * Register all the meta boxes for the post type
	 * 
	 * @package Blog Designer Pack Pro
	 * @version	1.0
	 */
	function bdpp_add_meta_box() {

		// Allowed Post Types
		$general_post_types = bdpp_get_option( 'post_types', array() );
		$trend_post_types 	= bdpp_get_option( 'trend_post_types', array() );

		$allowed_post_types = array_merge( $general_post_types, $trend_post_types );
		$allowed_post_types = array_unique( $allowed_post_types );

		// Post settings metabox
		add_meta_box( 'bdpp_post_sett', __( 'Blog Designer Pack Pro - Settings', 'blog-designer-pack' ),  array( $this, 'bdpp_render_post_sett_meta_box' ), $allowed_post_types, 'normal', 'high' );
	}

	/**
	 * Post Setting MetaBox
	 * 
	 * @package Blog Designer Pack Pro
	 * @version	1.0
	 */
	function bdpp_render_post_sett_meta_box() {
		include_once( BDPP_DIR . '/includes/admin/metabox/post-settings.php' );
	}

	/**
	 * Handles the post settings metabox save functionality
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_save_post_settings( $post_id, $post ) {

		global $post_type;

		// Taking some data
		$sharing_enable 	= bdpp_get_option( 'sharing_enable' );
		$general_post_types = bdpp_get_option( 'post_types', array() );			// General Post Type
		$trend_post_types 	= bdpp_get_option( 'trend_post_types', array() );	// Trending Post Type
		$allowed_post_types = array_merge( $general_post_types, $trend_post_types );
		$allowed_post_types = array_unique( $allowed_post_types );

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) // Check Autosave and revision
			|| ( empty( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )	// Check Revision
			|| ( ! in_array( $post_type, $allowed_post_types ) )				// Check if current post type is supported.
			|| ( ! current_user_can( 'edit_post', $post_id ) ) )
			{
				return $post_id;
			}

			$prefix = BDPP_META_PREFIX; // Taking meta prefix
			
			// Taking $_POST values
			$feat_post	= isset( $_POST[$prefix.'feat_post'] )	? 1 : 0;
			$post_link 	= !empty( $_POST[$prefix.'post_link'] ) ? bdpp_clean_url( $_POST[$prefix.'post_link'] ) : '';

			// Update Post Meta
			update_post_meta( $post_id, $prefix.'post_link', $post_link );
			update_post_meta( $post_id, $prefix.'feat_post', $feat_post );

			// Update sharing meta
			if( $sharing_enable ) {
				$disable_sharing = isset( $_POST[$prefix.'disable_sharing'] ) ? 1 : 0;

				update_post_meta( $post_id, $prefix.'disable_sharing', $disable_sharing );
			}
	}
}

$bdpp_metabox = new BDPP_MetaBox();
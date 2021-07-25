<?php
/**
 * Category / Taxonomy Class
 *
 * Handles the Category / Taxonomy related functionality
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BDPP_Taxonomy {

	function __construct() {

		// Getting allowed taxonomy
		$allowed_taxonomy = bdpp_get_option( 'taxonomy', array() );

		// Save taxonomy fields
		add_action( 'created_term', array($this, 'bdpp_save_taxonomy_custom_meta'), 10, 3 );
		add_action( 'edit_term', array($this, 'bdpp_save_taxonomy_custom_meta'), 10, 3 );

		if( !empty( $allowed_taxonomy ) ) {
			foreach ($allowed_taxonomy as $term_key => $term_val) {

				add_action( "{$term_key}_add_form_fields", array($this, 'bdpp_add_taxonomy_field') );
				add_action( "{$term_key}_edit_form_fields", array($this, 'bdpp_edit_taxonomy_field') );

				// Add custom columns to custom taxonomies
				add_filter( "manage_edit-{$term_key}_columns", array($this, 'bdpp_manage_category_columns') );
				add_filter( "manage_{$term_key}_custom_column", array($this, 'bdpp_manage_category_columns_fields'), 10, 3 );
			}
		}
	}

	/**
	 * Add form field on taxonomy page
	 * 
	 * @package Post Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_add_taxonomy_field( $taxonomy ) {
		include_once( BDPP_DIR . '/includes/admin/taxonomy/add-form.php' );
	}

	/**
	 * Add form field on edit-taxonomy page
	 * 
	 * @package Post Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_edit_taxonomy_field($term){
		include_once( BDPP_DIR . '/includes/admin/taxonomy/edit-form.php' );
	}

	/**
	 * Add image column
	 * 
	 * @package Post Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_manage_category_columns($columns) {
		
		$new_columns['bdpp_image'] = __( 'Image', 'blog-designer-pack' );
		$columns = bdpp_add_array( $columns, $new_columns, 1, true );
		
		return $columns;
	}

	/**
	 * Add column data
	 * 
	 * @package Post Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_manage_category_columns_fields( $output, $column_name, $term_id ) {
		if( $column_name == 'bdpp_image' ) {
			
			$prefix			= BDPP_META_PREFIX;
			$cat_thumb_id	= get_term_meta( $term_id, $prefix.'term_img_id', true );
			$cat_thumb_url	= bdpp_get_image_url( $cat_thumb_id, 'thumbnail' ); 
			
			if( !empty($cat_thumb_url) ) {
				$output .= '<img class="bdpp-cat-img" src="'.esc_url($cat_thumb_url).'" height="50" width="50" alt="" />';
			}
		}
		return $output;
	}

	/**
	 * Function to add term field on edit screen
	 * 
	 * @package Post Blog Designer Pack Pro
	 * @since 1.0
	 */
	function bdpp_save_taxonomy_custom_meta( $term_id, $tt_id = '', $taxonomy = '' ) {

		$allowed_taxonomy = bdpp_get_option( 'taxonomy', array() );

		if( isset( $allowed_taxonomy[ $taxonomy ] ) ) {

			$prefix			= BDPP_META_PREFIX;
			$term_img_id	= !empty( $_POST[$prefix.'term_img_id'] )	? bdpp_clean_number( $_POST[$prefix.'term_img_id'] )			: '';
			$term_link		= !empty( $_POST[$prefix.'term_link'] )		? bdpp_clean_url( $_POST[$prefix.'term_link'] )					: '';
			$term_icon		= !empty( $_POST[$prefix.'term_icon'] )		? bdpp_sanitize_html_classes( $_POST[$prefix.'term_icon'] )		: '';
			$term_bg_clr	= !empty( $_POST[$prefix.'term_bg_clr'] )	? sanitize_hex_color( trim( $_POST[$prefix.'term_bg_clr'] ) )	: '';

			update_term_meta( $term_id, $prefix.'term_img_id', $term_img_id );
			update_term_meta( $term_id, $prefix.'term_link', $term_link );
			update_term_meta( $term_id, $prefix.'term_icon', $term_icon );
			update_term_meta( $term_id, $prefix.'term_bg_clr', $term_bg_clr );
		}
	}
}

$bdpp_taxonomy = new BDPP_Taxonomy();
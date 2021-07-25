<?php
/**
 * Style Manager Form
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking Stored Data
$style_tabs			= bdpp_style_mngr_tab();
$default_style_data = bdpp_default_style_data();
$styles_data		= bdpp_get_style_data();
$style_id			= ! empty( $_GET['style_id'] ) ? bdpp_clean( $_GET['style_id'] ) : '';

if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {

	$action			= 'edit';
	$page_title 	= esc_html__('Edit Style', 'blog-designer-pack') . " #{$style_id}";
	$styles_data	= isset( $styles_data[ $style_id ] ) ? $styles_data[ $style_id ] : '';
	$styles_data	= wp_parse_args( $styles_data, $default_style_data );

	// If no style record is found
	if( empty( $styles_data ) ) {
		echo '<div class="error notice">
				<p><strong>'.__('Sorry, Something happened wrong.', 'blog-designer-pack').'</strong></p>
			  </div>';
		return;
	}

} else {

	$action		= 'add';
	$page_title = esc_html__('Add Style', 'blog-designer-pack');
}

// Taking some variables
$style_page = add_query_arg( array('page' => 'bdpp-styles', 'action' => 'add'), admin_url('admin.php') );
?>

<div class="wrap bdpp-style-form-wrp">

	<h1 class="wp-heading-inline"><?php echo $page_title; ?></h1>
	<a href="<?php echo esc_url( $style_page ); ?>" class="page-title-action"><?php _e('Add New', 'blog-designer-pack'); ?></a>
	<hr class="wp-header-end">

	<?php
	if( ! empty( $_GET['message'] ) && $_GET['message'] == 1 ) {
		echo '<div class="updated notice notice-success is-dismissible">
				<p><strong>'.__('Changes Saved.', 'blog-designer-pack').'</strong></p>
			  </div>';
	}
	?>

	<form id="bdpp-style-form" class="bdpp-style-form" method="post" action="">

		<div class="textright bdpp-top-btn-act-wrap bdpp-clearfix">
			<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
		</div>

		<div class="bdpp-tab-header bdpp-clearfix">
			<div class="bdpp-tab-header-title"><?php _e('Style Manager', 'blog-designer-pack'); ?></div>
		</div><!-- end .bdpp-dashboard-header -->

		<div class="bdpp-vtab-wrap bdpp-clearfix bdpp-style-mngr-sett">
			<ul class="bdpp-vtab-nav-wrap">
				<?php if( ! empty( $style_tabs ) ) {
					foreach ($style_tabs as $tab_key => $tab_data) {

						$tab_key	= sanitize_title( $tab_key );
						$tab_title	= ! empty( $tab_data['title'] ) ? $tab_data['title']	: $tab_key;
						$tab_icon	= ! empty( $tab_data['icon'] )	? $tab_data['icon']		: 'dashicons-admin-generic';
						$active_cls	= ! isset( $active_cls )		? 'bdpp-active-vtab'	: '';
				?>

				<li class="bdpp-vtab-nav <?php echo $active_cls; ?>">
					<a href="#bdpp-style-<?php echo $tab_key; ?>"><i class="dashicons <?php echo $tab_icon; ?>" aria-hidden="true"></i> <?php echo $tab_title; ?></a>
				</li>

				<?php
					}
				} ?>
			</ul>

			<div class="bdpp-vtab-cnt-wrp">
				<?php
					// General Settings
					include_once( BDPP_DIR . '/includes/style-manager/general-style.php' );

					// Post & Post Meta Settings
					include_once( BDPP_DIR . '/includes/style-manager/post-meta-style.php' );

					// Short Content Settings
					include_once( BDPP_DIR . '/includes/style-manager/short-content-style.php' );

					// Read More Button Settings
					include_once( BDPP_DIR . '/includes/style-manager/read-more-btn-style.php' );

					// Read More Button Settings
					include_once( BDPP_DIR . '/includes/style-manager/slider-style.php' );
					
					// Timeline Settings
					include_once( BDPP_DIR . '/includes/style-manager/timeline-style.php' );
					
					// Category Shortcode Settings
					include_once( BDPP_DIR . '/includes/style-manager/category-shortcode-style.php' );
					
					// Pagination Settings
					include_once( BDPP_DIR . '/includes/style-manager/pagination-style.php' );

					do_action( 'bdpp_style_mngr_tab_cnt', $style_id, $styles_data, $action );
				?>
			</div><!-- end .bdpp-vtab-cnt-wrp -->			
		</div><!-- end .bdpp-vtab-wrap -->

		<input type="hidden" value="<?php echo isset( $styles_data['tab'] ) ? bdpp_esc_attr( $styles_data['tab'] ) : ''; ?>" class="bdpp-selected-tab" name="bdpp_styles[tab]" />
		<input type="hidden" name="bdpp_style_nonce" value="<?php echo wp_create_nonce( 'bdpp_style_nonce' ); ?>" />
	</form><!-- end .bdpp-style-form-wrp -->
</div><!-- end .wrap -->
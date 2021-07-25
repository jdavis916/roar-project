<?php
/**
 * Settings Page HTML
 * 
 * The code for the plugins main settings page
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_version;

// Reset all settings
if( ! empty($_POST['bdpp_reset_settings']) ) {

	bdpp_default_settings();

	// Flush closed setting boxes
	update_user_meta( get_current_user_id(), 'closedpostboxes_toplevel_page_bdpp-settings', '' );
}

$settings_tab_arr 	= bdpp_settings_tab();
$bdpp_active_tab 	= ( !empty($_GET['tab']) && array_key_exists( $_GET['tab'], $settings_tab_arr ) ) ? trim($_GET['tab']) : apply_filters( 'bdpp_default_tab', 'general' );
$closed_settings 	= get_user_meta( get_current_user_id(), 'closedpostboxes_toplevel_page_bdpp-settings', true );
$closed_settings	= ( !empty( $closed_settings ) && is_array( $closed_settings ) ) ? $closed_settings : array();
$bdpp_wp_cls 	    = $wp_version >= '5.5' ? 'bdpp-wp-updated' : 'bdpp-wp-old'; // Check wp version
?>
<div class="wrap">

	<h2><?php _e( 'Blog Designer Pack Pro Settings', 'blog-designer-pack' ); ?></h2>

	<?php
	// Save Setting Message
	if(isset($_GET['settings-updated']) && !empty($_GET['settings-updated'])) {
		echo '<div id="message" class="updated fade notice is-dismissible"><p><strong>' . __( 'Changes Saved.', 'blog-designer-pack') . '</strong></p></div>'; 
	}

	// Reset Setting Message
	if(isset($_POST['bdpp_reset_settings']) && !empty($_POST['bdpp_reset_settings'])) {
		echo '<div id="message" class="updated fade notice is-dismissible"><p><strong>' . __( 'Settings reset successfully.', 'blog-designer-pack') . '</strong></p></div>'; 
	}
	?>

	<!-- Reset settings form -->
	<form action="" method="post" id="bdpp-reset-sett-form" class="bdpp-right bdpp-reset-sett-form">
		<div class="bdpp-reset-settings bdpp-clearfix">
			<input type="submit" value="<?php esc_html_e('Reset All Settings', 'blog-designer-pack'); ?>" name="bdpp_reset_settings" id="bdpp_reset_settings" class="button button-primary bdpp-reset-button" />
		</div>
	</form>

	<div class="bdpp-sett-wrp">

		<form action="options.php" method="POST" id="bdpp-settings-form">

			<?php
			settings_fields( 'bdpp_settings' );
			wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );

			global $bdpp_options;
			?>

			<!-- Save Button -->
			<div class="textright bdpp-clearfix">
				<input type="submit" name="bdpp_sett_submit" class="button button-primary bdpp-sett-submit" value="<?php esc_html_e('Save Settings', 'blog-designer-pack'); ?>" />
			</div>

			<h2 class="nav-tab-wrapper bdpp-nav-tab-wrapper bdpp-h2">
				<?php
				if( ! empty( $settings_tab_arr ) ) {
					foreach ($settings_tab_arr as $sett_key => $sett_val) {
						$selected_nav_cls 	= ($bdpp_active_tab == $sett_key) ? 'nav-tab-active' : '';
						$tab_url 			= add_query_arg( array( 'page' => 'bdpp-settings', 'tab' => $sett_key), admin_url('admin.php') );
				?>
						<a class="nav-tab <?php echo $selected_nav_cls; ?> bdpp-nav-tab-<?php echo $sett_key; ?>" href="<?php echo $tab_url; ?>"><?php echo $sett_val; ?></a>
				<?php
					} // End of for each
				} // End of if
				?>
			</h2>
			
			<div class="bdpp-sett-content-wrp bdpp-sett-tab-cnt bdpp-<?php echo $bdpp_active_tab; ?>-sett-cnt-wrp <?php echo $bdpp_wp_cls; ?>">
				<?php do_action( 'bdpp_settings_tab_' . $bdpp_active_tab, $closed_settings ); ?>
			</div><!-- end .bdpp-sett-content-wrp -->

			<?php if( ! empty( $closed_settings ) ) { ?>
			<div class="bdpp-hide bdpp-closed-sett-box" data-sett="<?php echo htmlspecialchars( json_encode( $closed_settings ) ); ?>">
				<div class="postbox closed" id="<?php echo implode(',', $closed_settings); ?>"></div>
			</div>
			<?php } ?>

		</form><!-- end #bdpp-settings-form -->

	</div><!-- end .bdpp-sett-wrp -->
</div><!-- end .wrap -->
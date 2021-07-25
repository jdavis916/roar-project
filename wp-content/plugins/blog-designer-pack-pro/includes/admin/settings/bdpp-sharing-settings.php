<?php
/**
 * Social Sharing Settings Page
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_sharing_settings( $closed_settings ) {

	$closed_class		= in_array( 'bdpp-sharing-sett', $closed_settings ) ? 'closed' : '';

	$reg_post_types 	= bdpp_get_post_types();
	$sharing_designs	= bdpp_sharing_designs();
	$sharing_services	= bdpp_sharing_services();
	
	$general_post_types = bdpp_get_option( 'post_types', array() );
	$sharing_post_types = bdpp_get_option( 'sharing_post_types', array() );
	$sharing_design		= bdpp_get_option( 'sharing_design' );
	$saved_services 	= bdpp_get_option( 'sharing', array() );
	$saved_services 	= ( !empty( $saved_services ) && is_array( $saved_services ) ) ? $saved_services : array(0 => '');
?>

<?php do_action('bdpp_before_sharing_sett'); ?>

<div id="bdpp-sharing-sett-wrp" class="post-box-container bdpp-sharing-sett-wrp">
	<div class="metabox-holder">
		<div id="bdpp-sharing-sett" class="postbox <?php echo $closed_class; ?> bdpp-postbox">

			<div class="postbox-header">
				<h2 class="hndle">
					<span><?php _e( 'Social Sharing Settings', 'blog-designer-pack' ); ?></span>
				</h2>
				<div class="handle-actions">
					<button type="button" class="handlediv"><span class="toggle-indicator"></span></button>
				</div>
			</div>

			<div class="inside">
				<table class="form-table bdpp-sharing-sett-tbl">
					<tbody>

						<?php do_action('bdpp_before_sharing_sett_row'); ?>

						<tr>
							<th><label for="bdpp-enable-sharing"><?php _e( 'Enable Social Sharing', 'blog-designer-pack' ); ?></label></th>
							<td>
								<input type="checkbox" name="bdpp_opts[sharing_enable]" value="1" class="bdpp-checkbox bdpp-enable-sharing" id="bdpp-enable-sharing" <?php checked(1, bdpp_get_option('sharing_enable', 0)); ?>/><br/>
								<span class="description"><?php _e('Check this box to enable social sharing.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						<tr>
							<th><label><?php _e( 'Social Services', 'blog-designer-pack' ); ?></label></th>
							<td>
								<div class="bdpp-social-service-wrap">
									<?php if( !empty( $saved_services ) ) {
										foreach ($saved_services as $service_key => $service_val) {
									?>
									<div class="bdpp-social-service-row">
										<select name="bdpp_opts[sharing][]" class="bdpp-select bdpp-social-service">
											<option value=""><?php _e('Select Social Service', 'blog-designer-pack'); ?></option>
											<?php if( !empty( $sharing_services ) ) {
												foreach ($sharing_services as $sharing_key => $sharing_val) {
											?>
													<option value="<?php echo bdpp_esc_attr( $sharing_key ); ?>" <?php selected( $sharing_key, $service_val ); ?>><?php echo $sharing_val ?></option>
											<?php
												}
											}
											?>
										</select>
										<span class="bdpp-social-service-act">
											<button type="button" class="button button-secondary bdpp-social-service-btn bdpp-social-service-add"><?php _e('Add', 'blog-designer-pack'); ?></button>
											<button type="button" class="button button-secondary bdpp-social-service-btn bdpp-social-service-del"><?php _e('Remove', 'blog-designer-pack'); ?></button>
										</span>
									</div>
									<?php }
									}
									?>
								</div>
								<span class="description"><?php _e('Choose social sharing service. Social sharing will be displayed in same order in which you save.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						<tr>
							<th colspan="2">
								<div class="bdpp-sett-sub-title"><?php _e( 'Social Sharing on Single Pages', 'blog-designer-pack' ); ?></div>
							</th>
						</tr>
						<tr>
							<th><label for="bdpp-sharing-lbl"><?php _e( 'Sharing Label', 'blog-designer-pack' ); ?></label></th>
							<td>
								<input type="text" name="bdpp_opts[sharing_lbl]" value="<?php echo bdpp_esc_attr( bdpp_get_option( 'sharing_lbl' ) ) ?>" class="regular-text bdpp-sharing-label" id="bdpp-sharing-lbl" /><br/>
								<span class="description"><?php _e('Enter sharing label.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						<tr>
							<th><label for="bdpp-sharing-design"><?php _e( 'Sharing Theme', 'blog-designer-pack' ); ?></label></th>
							<td>
								<select name="bdpp_opts[sharing_design]" class="bdpp-select bdpp-sharing-design" id="bdpp-sharing-design">
									<?php if( ! empty( $sharing_designs ) ) {
										foreach ($sharing_designs as $design_key => $design_val) {
									?>
									<option value="<?php echo $design_key; ?>" <?php selected( $sharing_design, $design_key ); ?>><?php echo $design_val; ?></option>
									<?php
										}
									}
									?>
								</select><br/>
								<span class="description"><?php _e('Choose sharing theme.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						<tr>
							<th><label><?php _e( 'Select Post Type', 'blog-designer-pack' ); ?></label></th>
							<td>
								<?php if( !empty($general_post_types) ) {
									foreach ($general_post_types as $post_key => $post_val) {

										// If saved post type is not in general post type
										if( ! array_key_exists( $post_val, $reg_post_types ) ) {
											continue;
										}

										$post_label = isset( $reg_post_types[ $post_val ] ) ? $reg_post_types[ $post_val ] : '--';
								?>
									<div class="bdpp-post-type-wrap">
										<label>
											<input type="checkbox" value="<?php echo $post_val; ?>" name="bdpp_opts[sharing_post_types][]" class="bdpp-checkbox" <?php checked( in_array($post_val, $sharing_post_types), true ); ?> />
											<?php echo $post_label; ?>
											( <?php echo __('Post Type', 'blog-designer-pack').' : '.$post_val; ?> )
										</label>
									</div>
								<?php }
								} ?>
								<span class="description"><?php _e('Select post type box to enable social sharing on single post pages.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>

						<?php do_action('bdpp_after_sharing_sett_row'); ?>

						<tr>
							<td colspan="2">
								<?php submit_button( __( 'Save Settings', 'blog-designer-pack' ), 'button-primary right', 'bdpp_sett_submit', false ); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- .bdpp-sharing-sett-tbl -->
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
</div><!-- #bdpp-sharing-sett-wrp -->

<?php do_action('bdpp_after_sharing_sett'); ?>

<?php }

// Action to add social sharing settings
add_action( 'bdpp_settings_tab_sharing', 'bdpp_render_sharing_settings' );
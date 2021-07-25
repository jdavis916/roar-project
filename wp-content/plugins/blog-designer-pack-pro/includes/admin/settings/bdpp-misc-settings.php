<?php
/**
 * Misc Settings Page
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_misc_settings( $closed_settings ) {

	$closed_class = in_array( 'bdpp-misc-sett', $closed_settings ) ? 'closed' : '';
?>

<?php do_action('bdpp_before_misc_sett'); ?>

<div id="bdpp-misc-sett-wrp" class="post-box-container bdpp-misc-sett-wrp">
	<div class="metabox-holder">
		<div id="bdpp-misc-sett" class="postbox <?php echo $closed_class; ?> bdpp-postbox">

			<div class="postbox-header">
				<h2 class="hndle">
					<span><?php _e( 'Misc Settings', 'blog-designer-pack' ); ?></span>
				</h2>
				<div class="handle-actions">
					<button type="button" class="handlediv"><span class="toggle-indicator"></span></button>
				</div>
			</div>

			<div class="inside">
				<table class="form-table bdpp-misc-sett-tbl">
					<tbody>
					
						<?php do_action('bdpp_before_misc_sett_row'); ?>

						<tr>
							<th scope="row"><label for="bdpp-dsbl-font-awsm"><?php _e( 'Disable Font Awesome CSS', 'blog-designer-pack' ); ?></label></th>
							<td>
								<input type="checkbox" name="bdpp_opts[disable_font_awsm_css]" value="1" class="bdpp-dsbl-font-awsm" id="bdpp-dsbl-font-awsm" <?php checked(1, bdpp_get_option('disable_font_awsm_css', 0)); ?>/><br/>
								<span class="description"><?php _e('Check this box if your theme or any other plugins uses the font awsome css. Plugin will not use it\'s own font awsome css with respect to site speed.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="bdpp-dsbl-owl-css"><?php _e( 'Disable Owl Carousel CSS', 'blog-designer-pack' ); ?></label></th>
							<td>
								<input type="checkbox" name="bdpp_opts[disable_owl_css]" value="1" class="bdpp-dsbl-owl-css" id="bdpp-dsbl-owl-css" <?php checked(1, bdpp_get_option('disable_owl_css', 0)); ?>/><br/>
								<span class="description"><?php _e('Check this box if your theme or any other plugins uses the Owl Carousel css. Plugin will not use it\'s own Owl Carousel css with respect to site speed.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						
						<?php do_action('bdpp_after_misc_sett_row'); ?>
						
						<tr>
							<td colspan="2">
								<?php submit_button( __( 'Save Settings', 'blog-designer-pack' ), 'button-primary right', 'bdpp_sett_submit', false ); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- .bdpp-misc-sett-tbl -->
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
</div><!-- #bdpp-misc-sett-wrp -->

<?php do_action('bdpp_after_misc_sett'); ?>

<?php }

// Action to add misc settings
add_action( 'bdpp_settings_tab_misc', 'bdpp_render_misc_settings' );
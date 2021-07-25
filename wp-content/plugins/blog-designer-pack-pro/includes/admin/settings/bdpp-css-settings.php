<?php

/**
 * CSS Settings Page
 * 
 * The code for the plugins css settings page
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_css_settings( $closed_settings ) {
	global $bdpp_options;

	$closed_class = in_array( 'bdpp-css-sett', $closed_settings ) ? 'closed' : '';
?>

<?php do_action('bdpp_before_css_sett'); ?>

<div id="bdpp-css-sett-wrp" class="post-box-container bdpp-css-sett-wrp">
	<div class="metabox-holder">
		<div id="bdpp-css-sett" class="postbox <?php echo $closed_class; ?> bdpp-postbox">

			<div class="postbox-header">
				<h2 class="hndle">
					<span><?php _e( 'Custom CSS Settings', 'blog-designer-pack' ); ?></span>
				</h2>
				<div class="handle-actions">
					<button type="button" class="handlediv"><span class="toggle-indicator" aria-hidden="true"></span></button>
				</div>
			</div>

			<div class="inside">
				<table class="form-table bdpp-css-sett-tbl">
					<tbody>

						<?php do_action('bdpp_before_css_sett_row'); ?>

						<tr>
							<th scope="row">
								<label for="bdpp-cust-css"><?php _e( 'Custom CSS', 'blog-designer-pack' ); ?></label>
							</th>
							<td>
								<textarea name="bdpp_opts[custom_css]" id="bdpp-cust-css" rows="18" class="large-text bdpp-cust-css"><?php echo esc_textarea( bdpp_get_option('custom_css') ); ?></textarea>
								<span class="description"><?php _e( 'Here you can enter your custom css for the plugin. The css will automatically be inserted to the header of theme, when you save it.', 'blog-designer-pack' ); ?></span>
							</td>
						</tr>

						<?php do_action('bdpp_after_css_sett_row'); ?>

						<tr>
							<td colspan="2">
								<?php submit_button( __( 'Save Custom CSS', 'blog-designer-pack' ), 'button-primary right', 'bdpp_sett_submit', false ); ?>
							</td>
						</tr>

					</tbody>
				</table><!-- .bdpp-css-sett-tbl -->
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- end .metabox-holder -->
</div><!-- #bdpp-css-sett-wrp -->

<?php do_action('bdpp_after_css_sett'); ?>

<?php }

add_action( 'bdpp_settings_tab_css', 'bdpp_render_css_settings' );
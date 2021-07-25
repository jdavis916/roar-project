<?php
/**
 * Style Manager - General Settins
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-general" class="bdpp-vtab-cnt bdpp-style-general">
	
	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('General Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose general style settings.', 'blog-designer-pack'); ?></span>
	</div>

	<table class="form-table bdpp-style-general-tbl">
		<tbody>
			<tr>
				<th scope="row"><label for="bdpp-style-title"><?php esc_html_e('Style Name', 'blog-designer-pack'); ?></label></th>
				<td>
					<input type="text" name="bdpp_styles[title]" value="<?php echo isset( $styles_data['title'] ) ? bdpp_esc_attr( $styles_data['title'] ) : ''; ?>" class="bdpp-style-title regular-text" id="bdpp-style-title" /><br/>
					<span class="description"><?php esc_html_e( 'Enter style name. This is just for admin purpose.', 'blog-designer-pack' ); ?></span>
				</td>
			</tr>

			<tr>
				<th colspan="2">
					<div class="bdpp-sett-sub-title"><?php esc_html_e('How to Use', 'blog-designer-pack'); ?></div>
				</th>
			</tr>
			<tr>
				<td colspan="2">
					<p><?php _e('This is a style manager. You can change the basic look and feel of plugin output and make it according to your theme if necessary.', 'blog-designer-pack'); ?></p>
					<p><?php _e('You just need to pass the style ID as a shortcode parameter in any shortcode. e.g', 'blog-designer-pack'); ?><code>[bdp_post style_id="1"]</code></p><br/>
					<p><strong><?php _e('Note : Style Manager include styles for all shortcodes e.g Grid, Slider, Timeline and etc. So you just need to choose style for the respective area and for respective shortcode only. Below image will demo straight you about the style parts.', 'blog-designer-pack'); ?></strong></p>

					<br/>
					<div class="bdpp-text-center">
						<img style="border:2px solid #ccc;" src="<?php echo BDPP_URL; ?>assets/images/style-manager-info.png" alt="" />
					</div>
				</td>
			</tr>

			<?php do_action( 'bdpp_style_mngr_general_cnt', $style_id, $styles_data, $action ); ?>

			<tr>
				<td colspan="2">
					<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .bdpp-style-general -->
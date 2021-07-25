<?php
/**
 * Style Manager - Timeline Settins
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-timeline" class="bdpp-vtab-cnt bdpp-style-timeline">

	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('Timeline Appearance Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose timline appearance settings.', 'blog-designer-pack'); ?></span>
	</div>

	<table class="form-table bdpp-style-timeline">
		<tr>
			<th scope="row"><label for="bdpp-tmnl-theme-clr"><?php esc_html_e('Timeline Theme Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[tmnl_theme_clr]" value="<?php echo isset( $styles_data['tmnl_theme_clr'] ) ? bdpp_esc_attr( $styles_data['tmnl_theme_clr'] ) : ''; ?>" class="bdpp-tmnl-theme-clr bdpp-color-box" id="bdpp-tmnl-theme-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose timeline theme color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-tmnl-icon-clr"><?php esc_html_e('Timeline Icon Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[tmnl_icon_clr]" value="<?php echo isset( $styles_data['tmnl_icon_clr'] ) ? bdpp_esc_attr( $styles_data['tmnl_icon_clr'] ) : ''; ?>" class="bdpp-tmnl-icon-clr bdpp-color-box" id="bdpp-tmnl-icon-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose timeline post icon color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-tmnl-pbg-clr"><?php esc_html_e('Post Content Background Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[tmnl_pbg_clr]" value="<?php echo isset( $styles_data['tmnl_pbg_clr'] ) ? bdpp_esc_attr( $styles_data['tmnl_pbg_clr'] ) : ''; ?>" class="bdpp-tmnl-pbg-clr bdpp-color-box" id="bdpp-tmnl-pbg-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose timeline post content background color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>

		<?php do_action( 'bdpp_style_mngr_timeline_cnt', $style_id, $styles_data, $action ); ?>
		
		<tr>
			<td colspan="2">
				<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
			</td>
		</tr>
	</table>
</div><!-- end .bdpp-style-timeline -->
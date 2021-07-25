<?php
/**
 * Style Manager - Read More Button Settins
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-rdm-btn" class="bdpp-vtab-cnt bdpp-style-rdm-btn">

	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('Read More Button Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose read more button style settings.', 'blog-designer-pack'); ?></span>
	</div>

	<table class="form-table bdpp-style-rdm-btn-tbl">
		<tr>
			<th scope="row"><label for="bdpp-rdm-font-size"><?php esc_html_e('Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[rdm_font_size]" value="<?php echo isset( $styles_data['rdm_font_size'] ) ? bdpp_esc_attr( $styles_data['rdm_font_size'] ) : ''; ?>" placeholder="14" class="bdpp-rdm-font-size" id="bdpp-rdm-font-size" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter read more button font size. e.g 14', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-rdm-font-clr"><?php esc_html_e('Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[rdm_font_clr]" value="<?php echo isset( $styles_data['rdm_font_clr'] ) ? bdpp_esc_attr( $styles_data['rdm_font_clr'] ) : ''; ?>" class="bdpp-rdm-font-clr bdpp-color-box" id="bdpp-rdm-font-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose read more button font color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-rdm-font-hclr"><?php esc_html_e('Font Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[rdm_font_hclr]" value="<?php echo isset( $styles_data['rdm_font_hclr'] ) ? bdpp_esc_attr( $styles_data['rdm_font_hclr'] ) : ''; ?>" class="bdpp-rdm-font-hclr bdpp-color-box" id="bdpp-rdm-font-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose read more button font hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-rdm-bg-clr"><?php esc_html_e('Background Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[rdm_bg_clr]" value="<?php echo isset( $styles_data['rdm_bg_clr'] ) ? bdpp_esc_attr( $styles_data['rdm_bg_clr'] ) : ''; ?>" class="bdpp-rdm-bg-clr bdpp-color-box" id="bdpp-rdm-bg-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose read more button background color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-rdm-bg-hclr"><?php esc_html_e('Background Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[rdm_bg_hclr]" value="<?php echo isset( $styles_data['rdm_bg_hclr'] ) ? bdpp_esc_attr( $styles_data['rdm_bg_hclr'] ) : ''; ?>" class="bdpp-rdm-bg-hclr bdpp-color-box" id="bdpp-rdm-bg-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose read more button background hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-rdm-border-clr"><?php esc_html_e('Border Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[rdm_border_clr]" value="<?php echo isset( $styles_data['rdm_border_clr'] ) ? bdpp_esc_attr( $styles_data['rdm_border_clr'] ) : ''; ?>" class="bdpp-rdm-border-clr bdpp-color-box" id="bdpp-rdm-border-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose read more button border color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-rdm-border-hclr"><?php esc_html_e('Border Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[rdm_border_hclr]" value="<?php echo isset( $styles_data['rdm_border_hclr'] ) ? bdpp_esc_attr( $styles_data['rdm_border_hclr'] ) : ''; ?>" class="bdpp-rdm-border-hclr bdpp-color-box" id="bdpp-rdm-border-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose read more button border hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>

		<?php do_action( 'bdpp_style_mngr_rdm_btn_cnt', $style_id, $styles_data, $action ); ?>

		<tr>
			<td colspan="2">
				<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
			</td>
		</tr>
	</table>
</div><!-- end .bdpp-style-rdm-btn -->
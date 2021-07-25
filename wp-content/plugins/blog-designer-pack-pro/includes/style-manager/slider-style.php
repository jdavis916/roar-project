<?php
/**
 * Style Manager - Slider Settins
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-slider" class="bdpp-vtab-cnt bdpp-style-slider">
	
	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('Post/Category Slider Appearance Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose post pr category slider appearance settings.', 'blog-designer-pack'); ?></span>
	</div>

	<table class="form-table bdpp-style-slider">
		<tr>
			<th scope="row"><label for="bdpp-slider-arw-clr"><?php esc_html_e('Arrow Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[slider_arw_clr]" value="<?php echo isset( $styles_data['slider_arw_clr'] ) ? bdpp_esc_attr( $styles_data['slider_arw_clr'] ) : ''; ?>" class="bdpp-slider-arw-clr bdpp-color-box" id="bdpp-slider-arw-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose slider arrow font color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-slider-arw-hclr"><?php esc_html_e('Arrow Font Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[slider_arw_hclr]" value="<?php echo isset( $styles_data['slider_arw_hclr'] ) ? bdpp_esc_attr( $styles_data['slider_arw_hclr'] ) : ''; ?>" class="bdpp-slider-arw-hclr bdpp-color-box" id="bdpp-slider-arw-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose slider arrow font hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-slider-arw-bg-clr"><?php esc_html_e('Arrow Background Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[slider_arw_bg_clr]" value="<?php echo isset( $styles_data['slider_arw_bg_clr'] ) ? bdpp_esc_attr( $styles_data['slider_arw_bg_clr'] ) : ''; ?>" class="bdpp-slider-arw-bg-clr bdpp-color-box" id="bdpp-slider-arw-bg-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose slider arrow background color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-slider-arw-bg-hclr"><?php esc_html_e('Arrow Background Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[slider_arw_bg_hclr]" value="<?php echo isset( $styles_data['slider_arw_bg_hclr'] ) ? bdpp_esc_attr( $styles_data['slider_arw_bg_hclr'] ) : ''; ?>" class="bdpp-slider-arw-bg-hclr bdpp-color-box" id="bdpp-slider-arw-bg-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose slider arrow background hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-slider-dots-clr"><?php esc_html_e('Navigation Dots Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[slider_dots_clr]" value="<?php echo isset( $styles_data['slider_dots_clr'] ) ? bdpp_esc_attr( $styles_data['slider_dots_clr'] ) : ''; ?>" class="bdpp-slider-dots-clr bdpp-color-box" id="bdpp-slider-dots-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose slider navigation dots color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-slider-dots-aclr"><?php esc_html_e('Navigation Dots Active Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[slider_dots_aclr]" value="<?php echo isset( $styles_data['slider_dots_aclr'] ) ? bdpp_esc_attr( $styles_data['slider_dots_aclr'] ) : ''; ?>" class="bdpp-slider-dots-aclr bdpp-color-box" id="bdpp-slider-dots-aclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose slider navigation dots active color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>

		<?php do_action( 'bdpp_style_mngr_slider_cnt', $style_id, $styles_data, $action ); ?>

		<tr>
			<td colspan="2">
				<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
			</td>
		</tr>
	</table>
</div><!-- end .bdpp-style-slider -->
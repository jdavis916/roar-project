<?php
/**
 * Style Manager - Pagination Settins
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-pagination" class="bdpp-vtab-cnt bdpp-style-pagination">

	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('Pagination Appearance Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose pagination appearance settings.', 'blog-designer-pack'); ?></span>
	</div>

	<table class="form-table bdpp-style-pagination">
		<tr>
			<th scope="row"><label for="bdpp-pagi-theme-clr"><?php esc_html_e('Pagination Theme Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[pagi_theme_clr]" value="<?php echo isset( $styles_data['pagi_theme_clr'] ) ? bdpp_esc_attr( $styles_data['pagi_theme_clr'] ) : ''; ?>" class="bdpp-pagi-theme-clr bdpp-color-box" id="bdpp-pagi-theme-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose pagination theme color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-pagi-themef-clr"><?php esc_html_e('Pagination Theme Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[pagi_themef_clr]" value="<?php echo isset( $styles_data['pagi_themef_clr'] ) ? bdpp_esc_attr( $styles_data['pagi_themef_clr'] ) : ''; ?>" class="bdpp-pagi-themef-clr bdpp-color-box" id="bdpp-pagi-themef-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose pagination theme font color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-pagi-themeh-clr"><?php esc_html_e('Pagination Theme Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[pagi_theme_h_clr]" value="<?php echo isset( $styles_data['pagi_theme_h_clr'] ) ? bdpp_esc_attr( $styles_data['pagi_theme_h_clr'] ) : ''; ?>" class="bdpp-pagi-themeh-clr bdpp-color-box" id="bdpp-pagi-themeh-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose pagination theme hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>		
		<tr>
			<th scope="row"><label for="bdpp-pagi-themefh-clr"><?php esc_html_e('Pagination Theme Font Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[pagi_themef_h_clr]" value="<?php echo isset( $styles_data['pagi_themef_h_clr'] ) ? bdpp_esc_attr( $styles_data['pagi_themef_h_clr'] ) : ''; ?>" class="bdpp-pagi-themefh-clr bdpp-color-box" id="bdpp-pagi-themefh-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose pagination theme hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>	
		<tr>
			<th scope="row"><label for="bdpp-pagi-active-clr"><?php esc_html_e('Pagination Active Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[pagi_active_clr]" value="<?php echo isset( $styles_data['pagi_active_clr'] ) ? bdpp_esc_attr( $styles_data['pagi_active_clr'] ) : ''; ?>" class="bdpp-pagi-active-clr bdpp-color-box" id="bdpp-pagi-active-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose active pagination color. Note : This will be used for numeric pagination only.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-pagi-activef-clr"><?php esc_html_e('Pagination Active Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[pagi_activef_clr]" value="<?php echo isset( $styles_data['pagi_activef_clr'] ) ? bdpp_esc_attr( $styles_data['pagi_activef_clr'] ) : ''; ?>" class="bdpp-pagi-activef-clr bdpp-color-box" id="bdpp-pagi-activef-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose active pagination font color. Note : This will be used for numeric pagination only.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-pagi-font-size"><?php esc_html_e('Pagination Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[pagi_font_size]" value="<?php echo isset( $styles_data['pagi_font_size'] ) ? bdpp_esc_attr( $styles_data['pagi_font_size'] ) : ''; ?>" placeholder="14" class="bdpp-pagi-font-size" id="bdpp-pagi-font-size" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter pagination font size. e.g 14', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
			

		<?php do_action( 'bdpp_style_mngr_pagination_cnt', $style_id, $styles_data, $action ); ?>
		
		<tr>
			<td colspan="2">
				<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
			</td>
		</tr>
	</table>
</div><!-- end .bdpp-style-pagination -->
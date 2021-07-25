<?php
/**
 * Style Manager - Short Content Settins
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-post-cnt" class="bdpp-vtab-cnt bdpp-style-post-cnt">
	
	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('Post & Category Content Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose post or category short content style settings.', 'blog-designer-pack'); ?></span>
	</div>

	<table class="form-table bdpp-style-post-cnt-tbl">
		<tr>
			<th scope="row"><label for="bdpp-cnt-font-size"><?php esc_html_e('Short Content Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cnt_font_size]" value="<?php echo isset( $styles_data['cnt_font_size'] ) ? bdpp_esc_attr( $styles_data['cnt_font_size'] ) : ''; ?>" placeholder="14" class="bdpp-cnt-font-size" id="bdpp-cnt-font-size" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter post short content font size. e.g 14', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-cnt-lineheight"><?php esc_html_e('Short Content Line Height', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cnt_lineheight]" value="<?php echo isset( $styles_data['cnt_lineheight'] ) ? bdpp_esc_attr( $styles_data['cnt_lineheight'] ) : ''; ?>" placeholder="20" class="bdpp-cnt-lineheight" id="bdpp-cnt-lineheight" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter post short content line height. e.g 20', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-cnt-font-clr"><?php esc_html_e('Short Content Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cnt_font_clr]" value="<?php echo isset( $styles_data['cnt_font_clr'] ) ? bdpp_esc_attr( $styles_data['cnt_font_clr'] ) : ''; ?>" class="bdpp-cnt-font-clr bdpp-color-box" id="bdpp-cnt-font-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose post short content font color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>

		<?php do_action( 'bdpp_style_mngr_post_cnt', $style_id, $styles_data, $action ); ?>

		<tr>
			<td colspan="2">
				<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
			</td>
		</tr>
	</table>
</div><!-- end .bdpp-style-post-cnt -->
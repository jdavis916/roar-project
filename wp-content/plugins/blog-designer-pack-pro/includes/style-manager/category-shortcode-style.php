<?php
/**
 * Style Manager - Category Shortcode
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-cat-shrt" class="bdpp-vtab-cnt bdpp-style-cat-shrt">
	
	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('Category Shortcode Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose category shortcode settings.', 'blog-designer-pack'); ?></span>
	</div>
	
	<table class="form-table bdpp-style-cat-shrt">		
		<tr>
			<th scope="row"><label for="bdpp-cat-shrt-fsize"><?php esc_html_e('Category Title Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_shrt_fsize]" value="<?php echo isset( $styles_data['cat_shrt_fsize'] ) ? bdpp_esc_attr( $styles_data['cat_shrt_fsize'] ) : ''; ?>" placeholder="22" class="bdpp-cat-shrt-fsize" id="bdpp-cat-shrt-fsize" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter category title font size. e.g 22', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-cat-shrt-title-clr"><?php esc_html_e('Category Title Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_shrt_title_clr]" value="<?php echo isset( $styles_data['cat_shrt_title_clr'] ) ? bdpp_esc_attr( $styles_data['cat_shrt_title_clr'] ) : ''; ?>" class="bdpp-cat-shrt-title-clr bdpp-color-box" id="bdpp-cat-shrt-title-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category title font color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-cat-shrt-title-bclr"><?php esc_html_e('Category Title Bg Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_shrt_title_bclr]" value="<?php echo isset( $styles_data['cat_shrt_title_bclr'] ) ? bdpp_esc_attr( $styles_data['cat_shrt_title_bclr'] ) : ''; ?>" class="bdpp-cat-shrt-title-bclr bdpp-color-box" id="bdpp-cat-shrt-title-bclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category title background color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-cat-shrt-count-fsize"><?php esc_html_e('Category Count Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_shrt_count_fsize]" value="<?php echo isset( $styles_data['cat_shrt_count_fsize'] ) ? bdpp_esc_attr( $styles_data['cat_shrt_count_fsize'] ) : ''; ?>" placeholder="22" class="bdpp-cat-shrt-count-fsize" id="bdpp-cat-shrt-count-fsize" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter category count number font size. e.g 18', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-cat-shrt-count-clr"><?php esc_html_e('Category Count Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_shrt_count_clr]" value="<?php echo isset( $styles_data['cat_shrt_count_clr'] ) ? bdpp_esc_attr( $styles_data['cat_shrt_count_clr'] ) : ''; ?>" class="bdpp-cat-shrt-count-clr bdpp-color-box" id="bdpp-cat-shrt-count-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category count number font color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-cat-shrt-count-bclr"><?php esc_html_e('Category Count Bg Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_shrt_count_bclr]" value="<?php echo isset( $styles_data['cat_shrt_count_bclr'] ) ? bdpp_esc_attr( $styles_data['cat_shrt_count_bclr'] ) : ''; ?>" class="bdpp-cat-shrt-count-bclr bdpp-color-box" id="bdpp-cat-shrt-count-bclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category count number background color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>

		<?php do_action( 'bdpp_style_mngr_cat_shrt_cnt', $style_id, $styles_data, $action ); ?>

		<tr>
			<td colspan="2">
				<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
			</td>
		</tr>
	</table>

</div><!-- end .bdpp-style-cat-shrt -->
<?php
/**
 * Style Manager - Post Meta Settins
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-style-post-meta" class="bdpp-vtab-cnt bdpp-style-post-meta">

	<div class="bdpp-tab-info-wrap">
		<div class="bdpp-tab-title"><?php esc_html_e('Post & Post Meta Settings', 'blog-designer-pack'); ?></div>
		<span class="bdpp-tab-desc"><?php esc_html_e('Choose post and post meta style settings.', 'blog-designer-pack'); ?></span>
	</div>

	<table class="form-table bdpp-style-post-meta-tbl">
		<tr>
			<th scope="row"><label for="bdpp-title-font-size"><?php esc_html_e('Post Title Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[title_font_size]" value="<?php echo isset( $styles_data['title_font_size'] ) ? bdpp_esc_attr( $styles_data['title_font_size'] ) : ''; ?>" placeholder="22" class="bdpp-title-font-size" id="bdpp-title-font-size" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter post title font size. e.g 22', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-title-lineheight"><?php esc_html_e('Post Title Line Height', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[title_lineheight]" value="<?php echo isset( $styles_data['title_lineheight'] ) ? bdpp_esc_attr( $styles_data['title_lineheight'] ) : ''; ?>" placeholder="30" class="bdpp-title-lineheight" id="bdpp-title-lineheight" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter post title line height. e.g 30. Leave empty for default value.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-title-clr"><?php esc_html_e('Post Title Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[post_title_clr]" value="<?php echo isset( $styles_data['post_title_clr'] ) ? bdpp_esc_attr( $styles_data['post_title_clr'] ) : ''; ?>" class="bdpp-title-clr bdpp-color-box" id="bdpp-title-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose post title font color. Leave empty for default color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-title-hclr"><?php esc_html_e('Post Title Font Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[post_title_hclr]" value="<?php echo isset( $styles_data['post_title_hclr'] ) ? bdpp_esc_attr( $styles_data['post_title_hclr'] ) : ''; ?>" class="bdpp-title-hclr bdpp-color-box" id="bdpp-title-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose post title font hover color. Leave empty for default color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		
		<tr>
			<th colspan="2">
				<div class="bdpp-sett-sub-title"><?php esc_html_e('Post Featured Image Hover Setting', 'blog-designer-pack'); ?></div>
			</th>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-dsbl-img-zoom"><?php esc_html_e('Disable Image Hover Zoom Effect', 'blog-designer-pack'); ?></label></th>
			
			<td>
				<input type="checkbox" name="bdpp_styles[disable_img_zoom]" value="1" class="bdpp-dsbl-img-zoom" id="bdpp-dsbl-img-zoom" <?php checked(1, $styles_data['disable_img_zoom']); ?>/><br/>
				<span class="description"><?php _e('Disable image hover zoom effect from the respective designs.', 'blog-designer-pack'); ?></span>
			</td>
			
		</tr>

		<tr>
			<th colspan="2">
				<div class="bdpp-sett-sub-title"><?php esc_html_e('Post Category Settings', 'blog-designer-pack'); ?></div>
			</th>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-category-font-size"><?php esc_html_e('Category Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_font_size]" value="<?php echo isset( $styles_data['cat_font_size'] ) ? bdpp_esc_attr( $styles_data['cat_font_size'] ) : ''; ?>" placeholder="14" class="bdpp-category-font-size" id="bdpp-category-font-size" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter category font size. e.g 14', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-category-font-clr"><?php esc_html_e('Category Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_font_clr]" value="<?php echo isset( $styles_data['cat_font_clr'] ) ? bdpp_esc_attr( $styles_data['cat_font_clr'] ) : ''; ?>" class="bdpp-category-font-clr bdpp-color-box" id="bdpp-category-font-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category font color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-category-font-hclr"><?php esc_html_e('Category Font Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_font_hclr]" value="<?php echo isset( $styles_data['cat_font_hclr'] ) ? bdpp_esc_attr( $styles_data['cat_font_hclr'] ) : ''; ?>" class="bdpp-category-font-hclr bdpp-color-box" id="bdpp-category-font-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category font hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-category-bg-clr"><?php esc_html_e('Category Background Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_bg_clr]" value="<?php echo isset( $styles_data['cat_bg_clr'] ) ? bdpp_esc_attr( $styles_data['cat_bg_clr'] ) : ''; ?>" class="bdpp-category-bg-clr bdpp-color-box" id="bdpp-category-bg-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category background color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-category-bg-hclr"><?php esc_html_e('Category Background Hover Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[cat_bg_hclr]" value="<?php echo isset( $styles_data['cat_bg_hclr'] ) ? bdpp_esc_attr( $styles_data['cat_bg_hclr'] ) : ''; ?>" class="bdpp-category-bg-hclr bdpp-color-box" id="bdpp-category-bg-hclr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose category background hover color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>

		<tr>
			<th colspan="2">
				<div class="bdpp-sett-sub-title"><?php esc_html_e('Post Meta Settings', 'blog-designer-pack'); ?></div>
			</th>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-meta-font-size"><?php esc_html_e('Meta Font Size', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[meta_font_size]" value="<?php echo isset( $styles_data['meta_font_size'] ) ? bdpp_esc_attr( $styles_data['meta_font_size'] ) : ''; ?>" placeholder="14" class="bdpp-meta-font-size" id="bdpp-meta-font-size" /> <?php esc_html_e('Px', 'blog-designer-pack'); ?><br/>
				<span class="description"><?php esc_html_e( 'Enter font size for post meta like Tags, Author, Date, Share and etc. e.g 14', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-meta-font-clr"><?php esc_html_e('Meta Font Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[meta_font_clr]" value="<?php echo isset( $styles_data['meta_font_clr'] ) ? bdpp_esc_attr( $styles_data['meta_font_clr'] ) : ''; ?>" class="bdpp-meta-font-clr bdpp-color-box" id="bdpp-meta-font-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose font color for post meta like Tags, Author, Date, Share and etc.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="bdpp-meta-icon-clr"><?php esc_html_e('Meta Icon Color', 'blog-designer-pack'); ?></label></th>
			<td>
				<input type="text" name="bdpp_styles[meta_icon_clr]" value="<?php echo isset( $styles_data['meta_icon_clr'] ) ? bdpp_esc_attr( $styles_data['meta_icon_clr'] ) : ''; ?>" class="bdpp-meta-icon-clr bdpp-color-box" id="bdpp-meta-icon-clr" /><br/>
				<span class="description"><?php esc_html_e( 'Choose post meta icon color.', 'blog-designer-pack' ); ?></span>
			</td>
		</tr>

		<?php do_action( 'bdpp_style_mngr_post_meta_cnt', $style_id, $styles_data, $action ); ?>

		<tr>
			<td colspan="2">
				<input type="submit" name="bdpp_style_mngr_sett_submit" class="button button-primary right" value="<?php esc_html_e( 'Save Settings', 'blog-designer-pack' ) ?>" />
			</td>
		</tr>
	</table>
</div><!-- end .bdpp-style-post-meta -->
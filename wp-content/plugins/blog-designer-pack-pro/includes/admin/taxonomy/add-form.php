<?php
/**
 * Add taxonomy form field
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$prefix = BDPP_META_PREFIX; // Taking metabox prefix
?>

<div class="form-field bdpp-term-link-wrap">
	<label for="bdpp-term-link"><?php esc_html_e('Category Link', 'blog-designer-pack'); ?></label>
	<input type="text" name="<?php echo $prefix; ?>term_link" value="" class="bdpp-term-link" id="bdpp-term-link" />
	<p><?php esc_html_e( 'Enter custom category link. Leave it empty for default link.', 'blog-designer-pack' ); ?></p>
</div>

<div class="form-field bdpp-term-icon-wrap">
	<label for="bdpp-term-icon"><?php esc_html_e('Category Icon', 'blog-designer-pack'); ?></label>
	<input type="text" name="<?php echo $prefix; ?>term_icon" value="" class="bdpp-term-icon" id="bdpp-term-icon" />
	<p><?php esc_html_e( 'Enter category icon from Font Awesome or etc. e.g fa fa-music', 'blog-designer-pack' ); ?></p>
</div>

<div class="form-field bdpp-term-img-wrap">
	<label for="bdpp-term-thumb"><?php esc_html_e('Choose Category Image', 'blog-designer-pack'); ?></label>
	<input type="button" id="bdpp-term-thumb" class="button button-secondary bdpp-term-thumb bdpp-img-upload" value="<?php esc_html_e( 'Choose Image', 'blog-designer-pack'); ?>" />
	<input type="button" class="button button-secondary bdpp-term-thumb-clear bdpp-image-clear" value="<?php esc_html_e( 'Clear', 'blog-designer-pack'); ?>" />
	<input type="hidden" name="<?php echo $prefix; ?>term_img_id" value="" class="bdpp-cat-thumb-id bdpp-thumb-id" />
	<p><?php esc_html_e( 'Upload / Choose category image.', 'blog-designer-pack' ); ?></p>
	
	<div class="bdpp-img-preview bdpp-img-view bdpp-term-img-view"></div>
</div>

<div class="form-field bdpp-term-clr-wrap bdpp-term-bg-clr-wrap">
	<label for="bdpp-term-bg-clr"><?php esc_html_e('Category Background Color', 'blog-designer-pack'); ?></label>
	<input type="text" name="<?php echo $prefix; ?>term_bg_clr" value="" class="bdpp-term-bg-clr bdpp-color-box" id="bdpp-term-bg-clr" />
	<p><?php esc_html_e( 'Choose category background color. Leave it empty for default.', 'blog-designer-pack' ); ?></p>
</div>
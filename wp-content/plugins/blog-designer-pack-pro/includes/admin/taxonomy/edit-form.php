<?php
/**
 * Edit form field
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$prefix = BDPP_META_PREFIX; // Taking metabox prefix
		
//getting term ID
$term_id = $term->term_id;

// Getting stored values
$term_thumb_id		= get_term_meta( $term_id, $prefix.'term_img_id', true );
$term_link			= get_term_meta( $term_id, $prefix.'term_link', true );
$term_icon			= get_term_meta( $term_id, $prefix.'term_icon', true );
$term_bg_clr		= get_term_meta( $term_id, $prefix.'term_bg_clr', true );
$term_thumb_image	= bdpp_get_image_url( $term_thumb_id, 'thumbnail' );
?>

<tr class="form-field bdpp-term-link-wrap">
	<th scope="row">
		<label for="bdpp-term-link"><?php esc_html_e('Category Link', 'blog-designer-pack'); ?></label>
	</th>
	<td>
		<input type="text" name="<?php echo $prefix; ?>term_link" value="<?php echo esc_url( $term_link ); ?>" class="bdpp-term-link" id="bdpp-term-link" />
		<p class="description"><?php esc_html_e( 'Enter custom category link. Leave it empty for default link.', 'blog-designer-pack' ); ?></p>
	</td>
</tr>

<tr class="form-field bdpp-term-icon-wrap">
	<th scope="row">
		<label for="bdpp-term-icon"><?php esc_html_e('Category Icon', 'blog-designer-pack'); ?></label>
	</th>
	<td>
		<input type="text" name="<?php echo $prefix; ?>term_icon" value="<?php echo bdpp_esc_attr( $term_icon ); ?>" class="bdpp-term-icon" id="bdpp-term-icon" />
		<p class="description"><?php esc_html_e( 'Enter category icon from Font Awesome or etc. e.g fa fa-music', 'blog-designer-pack' ); ?></p>
	</td>
</tr>

<tr class="form-field bdpp-term-img-wrap">
	<th scope="row">
		<label for="bdpp-term-thumb"><?php esc_html_e('Choose Image', 'blog-designer-pack'); ?></label>
	</th>
	<td>
		<input type="button" id="bdpp-term-thumb" class="button button-secondary bdpp-img-upload bdpp-term-thumb" value="<?php esc_html_e( 'Choose Image', 'blog-designer-pack'); ?>" />
		<input type="button" class="button button-secondary bdpp-term-thumb-clear bdpp-image-clear" value="<?php esc_html_e( 'Clear', 'blog-designer-pack'); ?>" />
		<input type="hidden" name="<?php echo $prefix; ?>term_img_id" value="<?php echo esc_attr( $term_thumb_id ); ?>" class="bdpp-cat-thumb-id bdpp-thumb-id" />
		<p class="description"><?php esc_html_e( 'Upload / Choose category image.', 'blog-designer-pack' ); ?></p>
		
		<div class="bdpp-img-preview bdpp-img-view bdpp-img-view">
			<?php if( ! empty( $term_thumb_image ) ) { ?>
			<img src="<?php echo esc_url( $term_thumb_image ); ?>" alt="" />
			<?php } ?>
		</div>
	</td>
</tr>

<tr class="form-field bdpp-term-bg-clr-wrap">
	<th scope="row">
		<label for="bdpp-term-bg-clr"><?php esc_html_e('Category Background Color', 'blog-designer-pack'); ?></label>
	</th>
	<td>
		<input type="text" name="<?php echo $prefix; ?>term_bg_clr" value="<?php echo bdpp_esc_attr( $term_bg_clr ); ?>" class="bdpp-term-bg-clr bdpp-color-box" id="bdpp-term-bg-clr" />
		<p class="description"><?php esc_html_e( 'Choose category background color. Leave it empty for default.', 'blog-designer-pack' ); ?></p>
	</td>
</tr>
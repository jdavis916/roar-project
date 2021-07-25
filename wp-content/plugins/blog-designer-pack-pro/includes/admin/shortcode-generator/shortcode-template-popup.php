<?php
/**
 * Template Generator Popup
 *
 * @package Blog Designer Pack Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// If template id is set
if( $tmpl_id ) {
	$popup_class	= 'bdpp-edit-shrt-tmpl-popup-wrp';
	$popup_title	= __('Update Shortcode Template', 'blog-designer-pack');
	$template_name	= $template_data['name'];
	$tmpl_enable	= $template_data['enable'];
} else {
	$popup_class	= 'bdpp-add-shrt-tmpl-popup-wrp';
	$popup_title	= __('Shortcode Template Manager', 'blog-designer-pack');
	$template_name	= '';
	$tmpl_enable	= 1;
}
?>

<div class="<?php echo $popup_class; ?> bdpp-popup-wrp bdpp-hide">
	<div class="bdpp-popup-data-cnt">

		<div class="bdpp-img-cnt-block">
			<div class="bdpp-popup-close bdpp-popup-close-wrp"><img src="<?php echo BDPP_URL; ?>assets/images/close.png" alt="<?php _e('Close (Esc)', 'blog-designer-pack'); ?>" title="<?php _e('Close', 'blog-designer-pack'); ?>" /></div>

			<div class="bdpp-popup-body-wrp">
				<div class="bdpp-popup-title"><?php echo $popup_title; ?></div>
				<div class="bdpp-popup-body">
					<form method="post" action="" class="bdpp-shrt-tmpl-from" id="bdpp-shrt-tmpl-from">
						<table class="form-table">
							<tr>
								<th>
									<label for="bdpp-tmpl-name"><?php _e('Template Name', 'blog-designer-pack'); ?></label>
								</th>
								<td>
									<input type="text" name="bdpp_tmpl_name" value="<?php echo bdpp_esc_attr( $template_name ); ?>" class="large-text bdpp-tmpl-name" id="bdpp-tmpl-name" /><br/>
									<span class="description"><?php esc_html_e('Enter template name. This is just for your admin reference.', 'blog-designer-pack'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="bdpp-tmpl-enable"><?php _e('Live', 'blog-designer-pack'); ?></label>
								</th>
								<td>
									<input type="checkbox" name="bdpp_tmpl_enable" class="bdpp-tmpl-enable" id="bdpp-tmpl-enable" value="1" <?php checked( $tmpl_enable, 1 ); ?> /><br/>
									<span class="description"><?php esc_html_e('Check this box to make the template live. Note: If template is not live then no result will be displayed at front.', 'blog-designer-pack'); ?></span>
								</td>
							</tr>
							<?php if( $tmpl_id ) { ?>
							<tr>
								<th>
									<label><?php _e('Previous Shortcode', 'blog-designer-pack'); ?></label>
								</th>
								<td>
									<div class="bdpp-popup-shrt-preview"><?php echo $template_data['shortcode']; ?></div>
									<span class="description"><?php esc_html_e('Previous value of shortcode template, In case you want to compare with the below current one.', 'blog-designer-pack'); ?></span>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<th>
									<label><?php _e('Shortcode', 'blog-designer-pack'); ?></label>
								</th>
								<td>
									<div class="bdpp-popup-shrt-preview bdpp-tmpl-shrt-preview"></div>
									<span class="description"><?php esc_html_e('The output of this shortcode will be displayed at front.', 'blog-designer-pack'); ?></span>
								</td>
							</tr>
							<tr>
								<th colspan="2" align="right">
									<div class="bdpp-popup-notice bdpp-hide"></div>
									<button type="button" class="button button-primary right bdpp-shrt-tmpl-save"><?php _e('Save Changes', 'blog-designer-pack'); ?></button>
									<span class="spinner bdpp-popup-spinner"></span>
								</th>
							</tr>
						</table>
					</form>
				</div>
			</div><!-- end .bdpp-popup-body-wrp -->
		</div><!-- end .bdpp-img-cnt-block -->

	</div><!-- end .bdpp-popup-data-cnt -->
</div><!-- end .bdpp-img-data-wrp -->
<div class="bdpp-popup-overlay"></div>
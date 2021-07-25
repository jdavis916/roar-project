<?php
/**
 * Taxonomy Settings Page
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_taxonomy_settings( $closed_settings ) {

	$reg_post_types 	= bdpp_get_post_types();
	$general_post_types = bdpp_get_option( 'post_types', array() );
	$allowed_taxonomy	= bdpp_get_option( 'taxonomy', array() );

	$closed_class = in_array( 'bdpp-taxonomy-sett', $closed_settings ) ? 'closed' : '';
?>

<?php do_action('bdpp_before_taxonomy_sett'); ?>

<div id="bdpp-taxonomy-sett-wrp" class="post-box-container bdpp-taxonomy-sett-wrp">
	<div class="metabox-holder">
		<div id="bdpp-taxonomy-sett" class="postbox <?php echo $closed_class; ?> bdpp-postbox">

			<div class="postbox-header">
				<h2 class="hndle">
					<span><?php _e( 'Taxonomy Settings', 'blog-designer-pack' ); ?></span>
				</h2>
				<div class="handle-actions">
					<button type="button" class="handlediv"><span class="toggle-indicator"></span></button>
				</div>
			</div>

			<div class="inside">
				<table class="form-table bdpp-taxonomy-sett-tbl">
					<tbody>
					
						<?php do_action('bdpp_before_taxonomy_sett_row'); ?>

						<tr>
							<th scope="row"><label><?php _e( 'Select Taxonomy', 'blog-designer-pack' ); ?></label></th>
							<td>
								<?php if( !empty($general_post_types) ) {
									foreach ($general_post_types as $post_key => $post_label) {

										$taxonomy_objects = bdpp_get_taxonomies( $post_label );

										// If no taxonomy OR saved post type is not in general post type
										if( empty( $taxonomy_objects ) || ! array_key_exists( $post_label, $reg_post_types ) ) {
											continue;
										}
								?>
									<div class="bdpp-term-type-wrap">
										<div class="bdpp-term-type-title"><?php echo $reg_post_types[$post_label]; ?></div>
										<?php foreach ($taxonomy_objects as $term_key => $term_label) { ?>
										<div class="bdpp-term-type-inr-wrap">
											<label>
												<input type="checkbox" value="<?php echo bdpp_esc_attr( $post_label ); ?>" name="bdpp_opts[taxonomy][<?php echo $term_key; ?>]" class="bdpp-checkbox" <?php checked( array_key_exists($term_key, $allowed_taxonomy), true ); ?> />
												<?php echo $term_label; ?>
												( <?php echo $term_key; ?> )
											</label>
										</div>
									<?php } ?>
									</div>
								<?php }
								} ?>
								<span class="description"><?php esc_html_e('Select category/taxonomy box to enable taxonomy support. You can enter category/taxonomy name within the shortcode parameter.', 'blog-designer-pack'); ?></span> <br/>
								<span class="description"><?php esc_html_e('Note: You have to enable relevant post type from `General` tab to get taxonomy list here.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						
						<?php do_action('bdpp_after_taxonomy_sett_row'); ?>
						
						<tr>
							<td colspan="2">
								<?php submit_button( __( 'Save Settings', 'blog-designer-pack' ), 'button-primary right', 'bdpp_sett_submit', false ); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- .bdpp-taxonomy-sett-tbl -->
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
</div><!-- #bdpp-taxonomy-sett-wrp -->

<?php do_action('bdpp_after_taxonomy_sett'); ?>

<?php }

// Action to add taxonomy settings
add_action( 'bdpp_settings_tab_taxonomy', 'bdpp_render_taxonomy_settings' );
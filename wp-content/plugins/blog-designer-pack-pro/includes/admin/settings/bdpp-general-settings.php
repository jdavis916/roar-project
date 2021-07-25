<?php
/**
 * General Settings Page
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_general_settings( $closed_settings ) {

	$reg_post_types 	= bdpp_get_post_types();
	$saved_post_types 	= bdpp_get_option( 'post_types', array() );

	$closed_class = in_array( 'bdpp-general-sett', $closed_settings ) ? 'closed' : '';
?>

<?php do_action('bdpp_before_general_sett'); ?>

<div id="bdpp-general-sett-wrp" class="post-box-container bdpp-general-sett-wrp">
	<div class="metabox-holder">
		<div id="bdpp-general-sett" class="postbox <?php echo $closed_class; ?> bdpp-postbox">

			<div class="postbox-header">
				<h2 class="hndle">
					<span><?php _e( 'Post Type Settings', 'blog-designer-pack' ); ?></span>
				</h2>
				<div class="handle-actions">
					<button type="button" class="handlediv right"><span class="toggle-indicator"></span></button>
				</div>	
			</div>

			<div class="inside">
				<table class="form-table bdpp-general-sett-tbl">
					<tbody>
					
						<?php do_action('bdpp_before_general_sett_row'); ?>

						<tr>
							<th scope="row"><label><?php _e( 'Select Post Type', 'blog-designer-pack' ); ?></label></th>
							<td>
								<?php if( !empty($reg_post_types) ) {
									foreach ($reg_post_types as $post_key => $post_label) {
										$taxonomy_objects = bdpp_get_taxonomies( $post_key, 'list' );
								?>
									<div class="bdpp-post-type-wrap">
										<label>
											<input type="checkbox" value="<?php echo $post_key; ?>" name="bdpp_opts[post_types][]" class="bdpp-checkbox" <?php checked( in_array($post_key, $saved_post_types), true ); ?> <?php disabled($post_key, 'post'); ?> />
											<?php echo $post_label; ?>
												( <?php echo __('Post Type', 'blog-designer-pack').' : '.$post_key; ?>
												<?php if( !empty($taxonomy_objects) ) {
													echo '| '.__('Taxonomy', 'blog-designer-pack').' : '.$taxonomy_objects;
												} ?>
												)
										</label>
									</div>
								<?php }
								} ?>
								<span class="description"><?php _e('Select post type box to enable post support. You can enter post type name and category name within the shortcode parameter.', 'blog-designer-pack'); ?></span> <br/>
								<span class="description"><?php _e('Note: `post` will be remain enabled by default.', 'blog-designer-pack'); ?></span>
							</td>
						</tr>
						
						<?php do_action('bdpp_after_general_sett_row'); ?>
						
						<tr>
							<td colspan="2">
								<?php submit_button( __( 'Save Settings', 'blog-designer-pack' ), 'button-primary right', 'bdpp_sett_submit', false ); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- .bdpp-general-sett-tbl -->
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
</div><!-- #bdpp-general-sett-wrp -->

<?php do_action('bdpp_after_general_sett'); ?>

<?php }

// Action to add general settings
add_action( 'bdpp_settings_tab_general', 'bdpp_render_general_settings' );
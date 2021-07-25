<?php
/**
 * Trending Settings Page
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bdpp_render_trending_settings( $closed_settings ) {

	$reg_post_types 	= bdpp_get_post_types();
	$trend_post_types 	= bdpp_get_option( 'trend_post_types', array() );

	$closed_class = in_array( 'bdpp-trending-sett', $closed_settings ) ? 'closed' : '';
?>

<?php do_action('bdpp_before_trending_sett'); ?>

<div id="bdpp-trending-sett-wrp" class="post-box-container bdpp-trending-sett-wrp">
	<div class="metabox-holder">
		<div id="bdpp-trending-sett" class="postbox <?php echo $closed_class; ?> bdpp-postbox">

			<div class="postbox-header">
				<h2 class="hndle">
					<span><?php _e( 'Post Type Settings', 'blog-designer-pack' ); ?></span>
				</h2>
				<div class="handle-actions">
					<button type="button" class="handlediv"><span class="toggle-indicator"></span></button>
				</div>
			</div>

			<div class="inside">
				<table class="form-table bdpp-trending-sett-tbl">
					<tbody>
					
						<?php do_action('bdpp_before_trending_sett_row'); ?>

						<tr>
							<th scope="row"><label><?php _e( 'Select Post Type', 'blog-designer-pack' ); ?></label></th>
							<td>
								<?php if( !empty($reg_post_types) ) {
									foreach ($reg_post_types as $post_key => $post_label) {
										$taxonomy_objects = bdpp_get_taxonomies( $post_key, 'list' );
								?>
									<div class="bdpp-post-type-wrap">
										<label>
											<input type="checkbox" value="<?php echo $post_key; ?>" name="bdpp_opts[trend_post_types][]" class="bdpp-checkbox" <?php checked( in_array($post_key, $trend_post_types), true ); ?> />
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
								<span class="description"><?php _e('Select post type box to enable trending post feature. You can enter post type name and category name within the shortcode parameter.', 'blog-designer-pack'); ?></span> <br/>
							</td>
						</tr>
						
						<?php do_action('bdpp_after_trending_sett_row'); ?>
						
						<tr>
							<td colspan="2">
								<?php submit_button( __( 'Save Settings', 'blog-designer-pack' ), 'button-primary right', 'bdpp_sett_submit', false ); ?>
							</td>
						</tr>
					</tbody>
				</table><!-- .bdpp-trending-sett-tbl -->
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
</div><!-- #bdpp-trending-sett-wrp -->

<?php do_action('bdpp_after_trending_sett'); ?>

<?php }

// Action to add trending settings
add_action( 'bdpp_settings_tab_trending', 'bdpp_render_trending_settings' );
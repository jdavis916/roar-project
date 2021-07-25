<?php
/**
 * Post Settings MetaBox HTML
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $post_type;

// Taking some data
$prefix 			= BDPP_META_PREFIX;
$general_post_types = bdpp_get_option( 'post_types', array() );
$trend_post_types 	= bdpp_get_option( 'trend_post_types', array() );
$sharing_enable 	= bdpp_get_option( 'sharing_enable', 0 );

$post_link			= get_post_meta( $post->ID, $prefix.'post_link', true );
$feat_post			= get_post_meta( $post->ID, $prefix.'feat_post', true );
$disable_sharing	= get_post_meta( $post->ID, $prefix.'disable_sharing', true );
?>

<div class="bdpp-post-sett-mb-wrp">
	<table class="form-table bdpp-post-sett-mb-tbl">
		<tbody>
			<?php if( $sharing_enable ) : ?>
			<tr>
				<th scope="row">
					<label for="bdpp-disable-sharing"><?php _e( 'Disable Social Sharing', 'blog-designer-pack' ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo $prefix; ?>disable_sharing" value="1" class="bdpp-checkbox bdpp-disable-sharing" id="bdpp-disable-sharing" <?php checked( $disable_sharing, 1 ); ?> /><br/>
					<span class="description"><?php _e('Check this box to disable social sharing for this post. ', 'blog-designer-pack'); ?></span>
				</td>
			</tr>
			<?php endif; ?>

			<tr>
				<th scope="row">
					<label for="bdpp-feat-post"><?php _e( 'Featured Post', 'blog-designer-pack' ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo $prefix; ?>feat_post" value="1" class="bdpp-checkbox bdpp-feat-post" id="bdpp-feat-post" <?php checked( $feat_post, 1 ); ?> /><br/>
					<span class="description"><?php _e('Check this box to mark this post as a featured post.', 'blog-designer-pack'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="bdpp-read-more-link"><?php _e( 'Read More Link', 'blog-designer-pack' ); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo $prefix; ?>post_link" value="<?php echo esc_url( $post_link ); ?>" class="large-text bdpp-read-more-link" id="bdpp-read-more-link" /><br/>
					<span class="description"><?php _e('Enter custom read more link. Leave empty for default post permalink.', 'blog-designer-pack'); ?></span>
				</td>
			</tr>

			<?php if( in_array( $post_type, $trend_post_types) ) : ?>
			<tr>
				<th colspan="2">
					<div class="bdpp-sett-sub-title"><?php _e( 'Trending Post Settings', 'blog-designer-pack' ); ?></div>
				</th>
			</tr>

			<tr>
				<th scope="row"><label><?php _e( 'Post View Count', 'blog-designer-pack' ); ?></label></th>
				<td>
					<?php $post_view_count = bdpp_clean_number( get_post_meta( $post->ID, $prefix.'post_views', true ), 0 ); ?>
					
					<span class="bdpp-post-count-view"><?php echo number_format( $post_view_count ); ?></span>
					
					<?php if( $post_view_count ) { ?>
					<input type="button" name="bdpp_reset_post_count" value="<?php _e('Reset Post Count', 'blog-designer-pack'); ?>" class="button button-secondary bdpp-reset-post-count" />
					<?php } ?>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div><!-- end .bdpp-post-sett-mb-wrp -->
<?php
/**
 * Post List Widget Template 5
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/widget/post-list/design-5.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
?>
<div class="bdpp-post-widget-main <?php echo $wrp_cls; ?> bdpp-clearfix">
	<div class="bdpp-widget-content">
		<div class="bdpp-col-s-12 bdpp-columns">
			<?php if($show_category && $cate_name ) { ?>
			<div class="bdpp-post-cats"><?php echo $cate_name; ?></div>
			<?php } ?>

			<h4 class="bdpp-post-title">
				<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
			</h4>

			<?php if( $show_date ) { ?>
			<div class="bdpp-post-meta">
				<?php echo bdpp_post_meta_data( array('post_date' => $show_date) ); ?>
			</div>
			<?php }

			if( $show_content ) { ?>
			<div class="bdpp-post-desc"><?php echo bdpp_get_post_excerpt( $post->ID, get_the_content(), $content_words_limit ); ?></div>
			<?php } ?>
		</div>
	</div>
</div>
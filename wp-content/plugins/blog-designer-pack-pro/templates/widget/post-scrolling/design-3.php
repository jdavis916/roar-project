<?php
/**
 * Post Scrollin Widget Template 3
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/widget/post-scrolling/design-3.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
?>
<li class="bdpp-post-li <?php echo $wrp_cls; ?>">
	<div class="bdpp-post-img-bg">
		<a class="bdpp-post-link-bg" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>" <?php echo $image_style; ?>></a>

		<div class="bdpp-post-widget-overlay">
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
</li>
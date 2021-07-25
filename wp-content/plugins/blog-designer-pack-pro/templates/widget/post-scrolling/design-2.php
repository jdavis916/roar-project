<?php
/**
 * Post Scrollin Widget Template 2
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/widget/post-scrolling/design-2.php
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
	<div class="bdpp-post-list-content bdpp-clearfix">
		<div class="bdpp-post-list-left <?php if ( ! $feat_img ) { echo 'bdpp-col-s-12'; } else { echo 'bdpp-col-s-7'; } ?> bdpp-columns">
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

		<?php if ( $feat_img ) { ?>
		<div class="bdpp-post-list-right bdpp-col-s-5 bdpp-columns">
			<div class="bdpp-post-img-bg">
				<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>">
					<img src="<?php echo esc_url( $feat_img ); ?>" alt="<?php the_title_attribute(); ?>" />
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
</li>
<?php
/**
 * Slider Template 6
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/slider/design-6.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

// Post Meta Data
$meta_data = array(
				'author'	=> $show_author,
				'post_date'	=> $show_date,
				'comments' 	=> $show_comments,
				'sharing'   => $sharing
			);
?>
<div class="bdpp-post-slide <?php echo $wrp_cls; ?> bdpp-clearfix" <?php echo $hash_listener; ?>>
	<div class="bdpp-post-slider-content bdpp-clearfix">
		<div class="bdpp-col-left bdpp-col-xl-4 bdpp-columns bdpp-clearfix">	
			<div class="bdpp-featured-meta">
				<?php if($show_category && $cate_name ) { ?>
				<div class="bdpp-post-cats"><?php echo $cate_name; ?></div>
				<?php } ?>

				<h2 class="bdpp-post-title">
					<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
				</h2>

				<?php if($show_date || $show_author || $show_comments || $sharing) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-up">
					<?php echo bdpp_post_meta_data( $meta_data, array( 'sharing_trigger' => 'hover' ) ); ?>
				</div>
				<?php }

				if( $show_content ) { ?>
				<div class="bdpp-post-content">
					<div class="bdpp-post-desc"><?php echo bdpp_get_post_excerpt( $post->ID, get_the_content(), $content_words_limit ); ?></div>
					<?php if( $show_read_more ) { ?>
					<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>" class="bdpp-rdmr-btn"><?php echo $read_more_text; ?></a>
					<?php } ?>
				</div>
				<?php }

				if( $show_tags && $tags ) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-down"><?php echo $tags; ?></div>
				<?php }	?>
			</div>
		</div>

		<div class="bdpp-col-right bdpp-col-xl-8 bdpp-columns">	
			<a class="bdpp-post-linkoverlay" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"></a>
			<div class="bdpp-post-img-bg <?php echo $lazy_cls; ?>" <?php echo $image_style; ?>>
				<?php if( $format == 'video' ) { echo bdpp_post_format_html( $format ); } ?>
			</div>
		</div>
	</div>
</div>
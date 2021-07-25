<?php
/**
 * Carousel Template 6
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/carousel/design-6.php
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
				'category'	=> $show_category,
				'comments'	=> $show_comments,
				'sharing'	=> $sharing
			);
?>
<div class="bdpp-post-slide <?php echo $wrp_cls; ?>" <?php echo $hash_listener; ?>>
	<div class="bdpp-post-carousel-content">
		<?php if ( $feat_img ) { ?>
		<div class="bdpp-post-img-bg">
			<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>">
				<?php if( ! $lazyload ) { ?>
				<img src="<?php echo esc_url( $feat_img ); ?>" alt="<?php the_title_attribute(); ?>" />
				<?php } else { ?>
				<img class="owl-lazy" data-src="<?php echo esc_url( $feat_img ); ?>" alt="<?php the_title_attribute(); ?>" />
				<?php } ?>
			</a>
		</div>
		<?php } ?>
		<div class="bdpp-post-content-inner">	
			<?php if( $format == 'video' ) { echo bdpp_post_format_html( $format ); } ?>
			<h2 class="bdpp-post-title">
				<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
			</h2>

			<?php if($show_category || $show_date || $show_author || $show_comments || $sharing) { ?>
			<div class="bdpp-post-meta bdpp-post-meta-up">
				<?php echo bdpp_post_meta_data( $meta_data, array( 'taxonomy' => $taxonomy, 'sharing_trigger' => 'hover' ) ); ?>
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
			<?php } ?>
		</div>
	</div>
</div>
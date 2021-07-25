<?php
/**
 * GridBox Template 2
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/gridbox/design-2.php
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
				'sharing'	=> $sharing,
			);
$height_css = ($height) ? 'height:'.$height.'px;' : '';

if($count == 1) { ?>
<div class="bdpp-post-gridbox bdpp-post-gridbox-left bdpp-col-2 bdpp-columns <?php echo $wrp_cls; ?>">
	<div class="bdpp-post-grid-content">
		<a class="bdpp-post-linkoverlay" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"></a>
		<div class="bdpp-post-img-bg" style="<?php echo $height_css; ?> background-image:url(<?php echo esc_url( $feat_img ); ?>);">
			<?php if($show_category && $cate_name ) { ?>
			<div class="bdpp-post-cats"><?php echo $cate_name; ?></div>
			<?php } ?>

			<div class="bdpp-post-content-overlay">
				<?php if( $format == 'video' ) { echo bdpp_post_format_html( $format ); } ?>
				<h2 class="bdpp-post-title">
					<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
				</h2>

				<?php if($show_date || $show_author || $show_comments || $sharing) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-up">
					<?php echo bdpp_post_meta_data( $meta_data ); ?>
				</div>
				<?php }

				if( $show_content) { ?>
					<div class="bdpp-post-content">				
						<div class="bdpp-post-desc"><?php echo bdpp_get_post_excerpt( $post->ID, get_the_content(), $content_words_limit ); ?></div>							
						<?php if( $show_read_more ) { ?>
						<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>" class="bdpp-rdmr-btn"><?php echo $read_more_text; ?></a>
						<?php } ?>
					</div>
				<?php }

				if( $show_tags && $tags ) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-down"><?php echo $tags; ?></div>
				<?php }	 ?>			
			</div>
		</div>		
	</div>
</div>
<?php } else {

$image_thumb = bdpp_get_post_feat_image( $post->ID, 'thumbnail', true ); ?>

<div class="bdpp-post-gridbox bdpp-post-gridbox-right bdpp-col-2 bdpp-columns <?php echo $wrp_cls; ?>">
	<div class="bdpp-post-grid-content bdpp-clearfix">			
		<?php if ( $image_thumb ) { ?>
		<div class="bdpp-col-s-4 bdpp-columns">
			<div class="bdpp-post-img-bg">
				<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>">
					<img src="<?php echo esc_url( $image_thumb ); ?>" alt="<?php the_title_attribute(); ?>" />
					<?php if( $format == 'video' ) { echo bdpp_post_format_html( $format ); } ?>
				</a>
			</div>
		</div>
		<?php } ?>

		<div class="<?php if ( !$image_thumb ) { echo 'bdpp-col-s-12'; } else { echo 'bdpp-col-s-8'; } ?> bdpp-columns">
			<?php if($show_category && $cate_name ) { ?>
			<div class="bdpp-post-cats"><?php echo $cate_name; ?></div>
			<?php } ?>

			<div class="bdpp-post-content-overlay">
				<h4 class="bdpp-post-title">
					<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
				</h4>
				<?php if($show_date || $show_author || $show_comments || $sharing) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-up">
					<?php echo bdpp_post_meta_data( $meta_data ); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
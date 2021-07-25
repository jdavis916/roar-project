<?php
/**
 * GridBox Template 9
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/gridbox/design-9.php
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


$modulo = ($count % 4);
switch ( $modulo ) {
	case 1:
	case 2:
		$wrp_cls .= ' bdpp-col-3';
		break;		
	
	default:
		$wrp_cls 	.= ' bdpp-col-3';
		$height		= ( $height / 2 );
		break;
}
$height_css = ($height) ? 'height:'.$height.'px;' : '';

if( ($count % 4) == 1) { ?>
<div class="bdpp-post-gridbox-main bdpp-clearfix">
<?php } ?>

<div class="bdpp-post-gridbox <?php echo $wrp_cls; ?> bdpp-columns bdpp-clearfix" style="<?php echo $height_css; ?>">
	<div class="bdpp-post-grid-content">
		<a class="bdpp-post-linkoverlay" href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"></a>
		<div class="bdpp-post-img-bg" style="background-image:url(<?php echo esc_url( $feat_img ); ?>);">
			<?php if($show_category && $cate_name ) { ?>
			<div class="bdpp-post-cats"><?php echo $cate_name; ?></div>
			<?php } ?>

			<div class="bdpp-post-content-overlay">
				<?php if( $format == 'video' ) { echo bdpp_post_format_html( $format ); }

				if($modulo && $modulo <= 2) { ?>
				<h2 class="bdpp-post-title">
					<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
				</h2>
				<?php } else { ?>	
				<h3 class="bdpp-post-title">
					<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
				</h3>
				<?php }

				if($show_date || $show_author || $show_comments || $sharing) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-up">
					<?php echo bdpp_post_meta_data( $meta_data ); ?>
				</div>
				<?php }

				if( $show_content && ($modulo && $modulo <= 2) ) { ?>
					<div class="bdpp-post-content">
						<div class="bdpp-post-desc"><?php echo bdpp_get_post_excerpt( $post->ID, get_the_content(), $content_words_limit ); ?></div>
					</div>
					<?php if( $show_read_more ) { ?>
					<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>" class="bdpp-rdmr-btn"><?php echo $read_more_text; ?></a>
					<?php }
				}

				if( $show_tags && $tags ) { ?>
				<div class="bdpp-post-meta bdpp-post-meta-down"><?php echo $tags; ?></div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php if( ($modulo  == 0 ) || ( $post_count == $count ) ) { ?>
</div>
<?php } ?>
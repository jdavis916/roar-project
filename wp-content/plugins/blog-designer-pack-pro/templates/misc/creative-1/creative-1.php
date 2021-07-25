<?php
/**
 * Creative 1 Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/misc/creative-1/creative-1.php
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
<div class="bdpp-post-grid <?php echo $wrp_cls; ?>" data-count="<?php echo $count; ?>" data-bg="<?php echo esc_url( $feat_img ); ?>">
	<div class="bdpp-post-grid-content">
		<?php if($show_category && $cate_name ) { ?>
			<div class="bdpp-post-cats"><?php echo $cate_name; ?></div>
		<?php } ?>
		<div class="bdpp-post-grid-bottom">
			<h2 class="bdpp-post-title">
				<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_behaviour; ?>"><?php the_title(); ?></a>
			</h2>			
			<div class="bdpp-post-meta">
				<?php echo bdpp_post_meta_data( $meta_data ); ?>
			</div>			
		</div>
	</div>
</div>
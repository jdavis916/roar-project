<?php
/**
 * @package avenue
 */

if (get_theme_option('posts--img')) {
	avenue_post_preview_image(get_theme_option('posts--img_size'), 'post-standard_img');
}
?>

<div class="post-standard_desc-w">

	<?php get_template_part( 'post-templates/standard/part', 'aside' ); ?>

	<div class="post-standard_main">
		<?php if (avenue_categorized_blog()) { ?>
			<div class="post-standard_category"><?php the_category(' '); ?></div>
		<?php } ?>

		<?php get_template_part( 'post-templates/standard/part', 'header' ); ?>

		<div class="post-standard_desc">
			<?php echo apply_filters( 'the_content', avenue_esc_post_preview(get_the_content()) ); ?>
		</div>

		<?php get_template_part( 'post-templates/standard/part', 'meta' ); ?>
	</div>
</div>

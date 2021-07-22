<?php
/**
 * @package avenue
 */
?>

<?php avenue_post_preview_image(get_theme_option('posts--img_size'), 'post-metro_img'); ?>

<div class="post-metro_icon">
	<span class="icon-check"></span>
</div>

<div class="post-metro_desc-w">	
	<blockquote class="post-metro_desc"><?php echo apply_filters( 'the_content', avenue_esc_post_preview(get_the_content()) ); ?></blockquote>
</div>

<?php get_template_part( 'post-templates/metro/part', 'link' ); ?>

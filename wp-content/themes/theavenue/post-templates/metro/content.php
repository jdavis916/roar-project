<?php
/**
 * @package avenue
 */

global $avenue_post_loop;

?>

<?php avenue_post_preview_image(get_theme_option('posts--img_size'), 'post-metro_img'); ?>

<div class="post-metro_desc-w">
	<?php get_template_part( 'post-templates/metro/part', 'category' ); ?>
	
	<?php the_title( '<header><h3 class="post-metro_h">', '</h3></header>' ); ?>

	<div class="post-metro_date"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time></div>
</div>

<?php get_template_part( 'post-templates/metro/part', 'link' ); ?>

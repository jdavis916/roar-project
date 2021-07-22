<?php
/**
 * @package avenue
 */
?>

<?php avenue_post_preview_image_quote(get_theme_option('posts--img_size'), 'post-metro_img'); ?>

<div class="post-metro_icon">“</div>

<div class="post-metro_desc-w">

	<blockquote class="post-metro_desc"><?php echo apply_filters( 'the_content', avenue_esc_post_preview(get_the_content()) ); ?></blockquote>

	<?php the_title( '<cite class="post-metro_h">', '</cite>' ); ?>
</div>

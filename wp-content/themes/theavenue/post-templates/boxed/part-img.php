<?php
// $double_width = avenue_post_meta('local_single_post--double_width');
$post_format  = get_post_format();

if (has_post_thumbnail()) {
	$image = wp_get_attachment_image_src(get_post_thumbnail_id(), get_theme_option('posts--img_size'));
	?>
	<div class="post-boxed__img-wrapper">
		<a
			href="<?php echo esc_url(get_permalink()); ?>"
			rel="bookmark"
			class="post-boxed__img"
			style="background-image:url(<?php echo esc_url($image[0]); ?>)"
		></a>
	</div>
	<?php
}
?>

<?php

$current_post_content = get_the_content('');
$ar_current_post_content = avenue_post_preview_link($current_post_content);

?>

<?php get_template_part('post-templates/boxed/part', 'category'); ?>

<div class="post-boxed__content">
	<div class="post-boxed__icon">
		<span class="icon-link"></span>
	</div>

	<?php get_template_part('post-templates/boxed/part', 'header'); ?>

	<div class="post-boxed__desc">
		<?php echo esc_url($ar_current_post_content['link']); ?>
	</div>
</div>

<?php get_template_part('post-templates/boxed/part', 'meta'); ?>

<a
	href="<?php echo esc_url($ar_current_post_content['link']); ?>"
	class="post-boxed__link"
	rel="bookmark"
	title="<?php the_title(); ?>"
></a>

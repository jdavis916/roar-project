<?php get_template_part('post-templates/boxed/part', 'category'); ?>

<div class="post-boxed__content">
	<div class="post-boxed__icon">
		<i class="fa fa-twitter"></i>
	</div>

	<blockquote class="post-boxed__desc">
		<?php echo apply_filters('the_content', avenue_esc_post_preview(get_the_content())); ?>
	</blockquote>

	<?php the_title('<cite class="post-boxed__title">', '</cite>'); ?>
</div>

<?php get_template_part('post-templates/boxed/part', 'meta'); ?>

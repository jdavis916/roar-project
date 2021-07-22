<div class="post-boxed__inner">
	<?php get_template_part('post-templates/boxed/part', 'img'); ?>

	<div class="post-boxed__content">
		<?php get_template_part('post-templates/boxed/part', 'category'); ?>

		<?php get_template_part('post-templates/boxed/part', 'header'); ?>

		<div class="post-boxed__desc">
			<?php echo apply_filters('the_excerpt', avenue_esc_post_preview(get_the_excerpt())); ?>
		</div>

		<?php get_template_part('post-templates/boxed/part', 'meta'); ?>
	</div>
</div>

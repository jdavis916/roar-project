<div class="post-boxed__content">
	<div class="post-boxed__quote_icon">“</div>

	<div class="post-boxed__quote_content">
		<blockquote class="post-boxed__desc">
			<?php echo apply_filters('the_content', avenue_esc_post_preview(get_the_content())); ?>
		</blockquote>

		<?php the_title('<cite class="post-boxed__title">', '</cite>'); ?>
	</div>
</div>

<div class="post-boxed__meta">

	<span class="post-boxed__date">
		<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
	</span>

	<?php if (!post_password_required() && comments_open()) { ?>
		<a href="<?php comments_link(); ?>" class="post-boxed__comments">

			<?php if ( comments_number('', ' 1', ' %') ) { ?>
				<span class="icon-speech-bubble"></span><?php comments_number('', ' 1', ' %'); ?>
			<?php } ?>
		</a>
	<?php } ?>

</div>

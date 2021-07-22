<?php
/**
 * @package avenue
 */
?>

<?php get_template_part( 'post-templates/grid/part', 'img' ); ?>

<div class="post-grid_desc-w">
	<?php get_template_part( 'post-templates/grid/part', 'category' ); ?>

	<?php get_template_part( 'post-templates/grid/part', 'header' ); ?>

	<div class="post-grid_desc">
		<?php echo apply_filters( 'the_excerpt', avenue_esc_post_preview(get_the_excerpt()) ); ?>
	</div>
</div>

<?php get_template_part( 'post-templates/grid/part', 'meta' ); ?>

<?php get_template_part( 'post-templates/grid/part', 'link' ); ?>

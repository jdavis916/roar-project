<?php
/**
 * @package avenue
 */
?>

<?php if (avenue_categorized_blog()) { ?>
	<div class="post-masonry_category">
		<?php the_category(' '); ?>
	</div>
<?php } ?>

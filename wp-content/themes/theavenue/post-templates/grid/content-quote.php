<?php
/**
 * @package avenue
 */
?>

<div class="post-grid_desc-w">
	<div class="post-grid_icon">“</div>

	<blockquote class="post-grid_desc"><?php echo apply_filters( 'the_content', avenue_esc_post_preview(get_the_content()) ); ?></blockquote>
	
	<?php the_title( '<cite class="post-grid_h">', '</cite>' ); ?>
</div>
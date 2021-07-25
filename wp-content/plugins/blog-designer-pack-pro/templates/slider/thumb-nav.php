<?php
/**
 * Slider Thumbnail Navigation
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/slider/thumb-nav.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="bdpp-thumb-slider-wrap bdpp-wrap bdpp-thumb-<?php echo $design; ?>">
	<div class="bdpp-thumb-slider owl-carousel">
		<?php echo $thumb_items; ?>
	</div>
</div>
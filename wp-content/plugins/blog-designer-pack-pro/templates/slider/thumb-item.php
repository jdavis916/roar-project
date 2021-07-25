<?php
/**
 * Slider Thumbnail Navigation Items
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/slider/thumb-item.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="bdpp-thumb-item <?php echo $wrp_cls; ?>" <?php echo $hash_listener; ?>> 
	<div class="bdpp-thumb-cnt <?php echo $lazy_cls; ?>" <?php echo $image_thumb_style; ?>></div>
</div>
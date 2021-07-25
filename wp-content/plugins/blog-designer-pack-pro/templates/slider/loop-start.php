<?php
/**
 * Loop Start - Slider Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/slider/loop-start.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="bdpp-slider-wrap-main">
	<div id="bdpp-post-slider-wrap-<?php echo $unique; ?>" class="bdpp-post-slider-wrap owl-carousel <?php echo 'bdpp-'.$design .' '. $css_class; ?> bdpp-clearfix" data-conf="<?php echo htmlspecialchars(json_encode( $slider_conf )); ?>">
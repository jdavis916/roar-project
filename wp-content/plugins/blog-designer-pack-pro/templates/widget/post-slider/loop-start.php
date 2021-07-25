<?php
/**
 * Loop Start - Post Slider Widget Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/widget/post-slider/loop-start.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-post-slider-wdgt-<?php echo $unique; ?>" class="bdpp-post-slider-wdgt owl-carousel bdpp-post-widget-wrap bdpp-<?php echo $design .' '. $css_class; ?> bdpp-clearfix" data-conf="<?php echo htmlspecialchars(json_encode( $slider_conf )); ?>">
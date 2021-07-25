<?php
/**
 * Loop Start - Taxonomy Slider Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/taxonomy/slider/loop-start.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-term-slider-<?php echo $unique; ?>" class="bdpp-term-slider-wrap owl-carousel bdpp-<?php echo $design.' '.$css_class; ?> bdpp-clearfix" data-conf="<?php echo htmlspecialchars(json_encode( $slider_conf )); ?>">
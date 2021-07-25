<?php
/**
 * Loop Start - Carousel Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/carousel/loop-start.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="bdpp-post-carousel-wrap-<?php echo $unique; ?>" class="bdpp-post-carousel-wrap owl-carousel <?php echo 'bdpp-'.$design .' '. $css_class; ?> bdpp-clearfix" data-conf="<?php echo htmlspecialchars(json_encode( $slider_conf )); ?>">
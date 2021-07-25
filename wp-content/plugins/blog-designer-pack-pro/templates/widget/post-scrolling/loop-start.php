<?php
/**
 * Loop Start - Vertical Post Scroling Widget Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/widget/post-scroling/loop-start.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="bdpp-wrap bdpp-post-scroling-wdgt inf-post-scroling-wdgt bdpp-post-widget-wrap bdpp-<?php echo $design .' '. $css_class; ?>">

	<?php if( $arrows ) { ?>
	<div class="bdpp-vscroll-btn-wrap bdpp-text-right bdpp-clearfix">
		<span class="post-vticker-up"><i class="fa fa-chevron-up"></i></span> <span class="post-vticker-down"><i class="fa fa-chevron-down"></i></span>
	</div>
	<?php } ?>

	<div id="bdpp-post-scroling-wdgt-<?php echo $unique; ?>" class="bdpp-vticker-scroling-wdgt-js bdpp-vticker-scroling-wdgt bdpp-clearfix" data-conf="<?php echo htmlspecialchars(json_encode( $slider_conf )); ?>">
		<ul class="bdpp-vscroll-wdgt-wrap">
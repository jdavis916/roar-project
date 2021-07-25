<?php
/**
 * Loop Start - Creative 1 Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/misc/creative-1/loop-start.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$style = "<style type='text/css'>
			@media only screen and (max-width:{$slider_screen}px) {
				#bdpp-post-ctv1-{$unique} .bdpp-post-ctv1-thumb-active{display:none !important;}
				#bdpp-post-ctv1-{$unique} .bdpp-post-ctv1-thumb{position:unset;}
				#bdpp-post-ctv1-{$unique} .bdpp-post-ctv-one-inr-wrap{white-space: nowrap; overflow-y: hidden; overflow-x: scroll;}
				#bdpp-post-ctv1-{$unique} .bdpp-post-grid{white-space: normal; width: 50%; background-size:cover; border:0;}
				#bdpp-post-ctv1-{$unique} .bdpp-columns{float: none; display: inline-block; vertical-align: top;}
				#bdpp-post-ctv1-{$unique} .bdpp-no-thumb{border-left:1px solid rgba(255,255,255,0.2);}
			}
		</style>";
echo $style;
?>
<div id="bdpp-post-ctv1-<?php echo $unique; ?>" class="bdpp-wrap bdpp-post-ctv1-wrap bdpp-grid-<?php echo $grid .' '. $css_class; ?>" data-slider-screen="<?php echo $slider_screen; ?>">
	<div class="bdpp-post-ctv-one-inr-wrap bdpp-clearfix">
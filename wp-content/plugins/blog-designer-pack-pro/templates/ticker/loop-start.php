<?php
/**
 * Loop Start - Ticker Template
 *
 * This template can be overridden by copying it to yourtheme/blog-designer-pack-pro/ticker/loop-start.php
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<style type="text/css">
#bdpp-ticker-<?php echo $unique; ?>{border-color:<?php echo $theme_color ?>;}
#bdpp-ticker-<?php echo $unique; ?> .bdpp-label{background:<?php echo $theme_color ?>; color: <?php echo $heading_font_color; ?>}
#bdpp-ticker-<?php echo $unique; ?> .inf-controls span.inf-ctrl-btn{background-color:<?php echo $ctrl_bg_color ?>; border-color: <?php echo $ctrl_bg_color ?>;}
#bdpp-ticker-<?php echo $unique; ?> .inf-controls span.inf-ctrl-btn:hover{background-color:<?php echo $ctrl_bgh_color ?>;}
#bdpp-ticker-<?php echo $unique; ?> .inf-arrow{color:<?php echo $ctrl_txt_color ?>;}
#bdpp-ticker-<?php echo $unique; ?> .inf-action{background-color:<?php echo $ctrl_txt_color ?>; color:<?php echo $ctrl_txt_color ?>;}
#bdpp-ticker-<?php echo $unique; ?> .bdpp-ctrl-btn:hover .inf-action{background-color:<?php echo $ctrl_txth_color ?>; color:<?php echo $ctrl_txth_color ?>;}
#bdpp-ticker-<?php echo $unique; ?> .bdpp-ctrl-btn:hover .inf-arrow{color:<?php echo $ctrl_txth_color ?>;}
#bdpp-ticker-<?php echo $unique; ?> ul li a:hover, #bdpp-ticker-<?php echo $unique; ?> ul li a{color:<?php echo $font_color; ?>; font-style:<?php echo $font_style; ?>;}
@media only screen and (max-width:640px) {
	<?php if($show_title_in_mobile) { ?>
		#bdpp-ticker-<?php echo $unique; ?> .bdpp-label{display: block !important;}
	<?php } else { ?>
		#bdpp-ticker-<?php echo $unique; ?> .bdpp-label{display: none !important;}
	<?php } ?>
	<?php if($hide_ctrl_in_mobile) { ?>
		#bdpp-ticker-<?php echo $unique; ?> .bdpp-controls{display: none !important;}
	<?php } ?>
}
</style>

<div class="bdpp-wrap bdpp-ticker-wrp inf-news-ticker" id="bdpp-ticker-<?php echo $unique; ?>" data-conf="<?php echo htmlspecialchars(json_encode($ticker_conf)); ?>">	 
	<?php if( $ticker_title ) { ?>
	 <div class="inf-label bdpp-label"><?php echo $ticker_title; ?></div>
	<?php } ?>
	<div class="inf-ticker bdpp-ticker">
		<ul class="bdpp-ticker-cnt">
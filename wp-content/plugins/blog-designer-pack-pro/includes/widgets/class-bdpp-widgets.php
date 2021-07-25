<?php
/**
 * Widget Class
 * Widget related functions and widget registration.
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Include widget classes.
require_once( BDPP_DIR . '/includes/widgets/class-bdpp-post-widget.php' );
require_once( BDPP_DIR . '/includes/widgets/class-bdpp-post-slider-widget.php' );
require_once( BDPP_DIR . '/includes/widgets/class-bdpp-post-scrolling-widget.php' );

/**
 * Register Widgets.
 *
 * @since 1.0
 */
function bdpp_register_widgets() {
	register_widget( 'BDPP_Post_Widget' );
	register_widget( 'BDPP_Post_Slider_Widget' );
	register_widget( 'BDPP_Post_Scrolling_Widget' );
}
add_action( 'widgets_init', 'bdpp_register_widgets' );
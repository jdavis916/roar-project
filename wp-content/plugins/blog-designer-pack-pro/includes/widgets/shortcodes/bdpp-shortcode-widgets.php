<?php
/**
 * Shortcode Widgets Class
 * Shortcode Widget related functions and widget registration.
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Plugin Shortcode Widgets
require_once( BDPP_DIR . '/includes/widgets/shortcodes/abstract-bdpp-shortcode-widgets.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-slider.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-grid.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-list.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-carousel.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-masonry.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-gridbox.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-gridbox-slider.php' ); 
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-timeline.php' ); 
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-post-ticker.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-taxonomy-grid.php' );
require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-taxonomy-slider.php' );

/**
 * Register Widgets.
 *
 * @since 1.0
 */
function bdpp_register_shortcode_widgets() {
	register_widget( 'BDPP_Post_Slider' );
	register_widget( 'BDPP_Post_Grid' );
	register_widget( 'BDPP_Post_List' ); 
	register_widget( 'BDPP_Post_Carousel' ); 
	register_widget( 'BDPP_Post_Masonry' );  
	register_widget( 'BDPP_Post_Gridbox' ); 
	register_widget( 'BDPP_Post_Gridbox_Slider' );
	register_widget( 'BDPP_Post_Timeline' );
	register_widget( 'BDPP_Post_Ticker' );
	register_widget( 'BDPP_Taxonomy_Grid' );
	register_widget( 'BDPP_Taxonomy_Slider' );
}

// Action to register widget
add_action( 'widgets_init', 'bdpp_register_shortcode_widgets' );
<?php
/**
 * Post Carousel Widget
 *
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Widget cart class.
 */
class BDPP_Post_Carousel extends BDPP_Shortcode_Widget {

	var $defaults;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id			= 'bdpp-post-carousel-swdgt';
		$this->widget_cssclass		= 'bdpp-post-carousel-swdgt';
		$this->widget_title			= __( 'Post Carousel', 'blog-designer-pack' );
		$this->widget_name			= __( 'BDPP - Post Carousel Shortcode', 'blog-designer-pack' );
		$this->widget_description	= __( 'Display posts in a carousel view.', 'blog-designer-pack' );
		$this->settings				= bdp_post_carousel_shortcode_fields();
		$this->defaults				= $this->widget_defaults();

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {

		$instance = $this->filter_widget_instance( $instance );

		$this->widget_start( $args, $instance );

		echo bdpp_render_post_carousel( $instance );

		$this->widget_end( $args );
	}
}
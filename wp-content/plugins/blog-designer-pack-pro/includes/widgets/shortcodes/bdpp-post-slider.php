<?php
/**
 * Post Slider Widget
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
class BDPP_Post_Slider extends BDPP_Shortcode_Widget {

	var $defaults;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id			= 'bdpp-post-slider-swdgt';
		$this->widget_cssclass		= 'bdpp-post-slider-swdgt';
		$this->widget_title			= __( 'Post Slider', 'blog-designer-pack' );
		$this->widget_name			= __( 'BDPP - Post Slider Shortcode', 'blog-designer-pack' );
		$this->widget_description	= __( 'Display posts in a slider view.', 'blog-designer-pack' );
		$this->settings				= bdp_post_slider_shortcode_fields();
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

		echo bdpp_render_post_slider( $instance );

		$this->widget_end( $args );
	}
}
<?php
/**
 * Post Gridbox Slider Widget
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
class BDPP_Post_Gridbox_Slider extends BDPP_Shortcode_Widget {

	var $defaults;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id			= 'bdpp-post-gridbox-slider-swdgt';
		$this->widget_cssclass		= 'bdpp-post-gridbox-slider-swdgt';
		$this->widget_title			= __( 'Post Gridbox Slider', 'blog-designer-pack' );
		$this->widget_name			= __( 'BDPP - Post Gridbox Slider Shortcode', 'blog-designer-pack' );
		$this->widget_description	= __( 'Display posts in a gridbox slider view.', 'blog-designer-pack' );
		$this->settings				= bdp_post_gridbox_slider_shortcode_fields();
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

		echo bdpp_render_post_gridbox_slider( $instance );

		$this->widget_end( $args );
	}
}
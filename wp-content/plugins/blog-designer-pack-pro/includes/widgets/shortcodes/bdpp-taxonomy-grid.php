<?php
/**
 * Post Taxonomy Grid Widget
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
class BDPP_Taxonomy_Grid extends BDPP_Shortcode_Widget {

	var $defaults;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_id			= 'bdpp-taxonomy-grid-swdgt';
		$this->widget_cssclass		= 'bdpp-taxonomy-grid-swdgt';
		$this->widget_title			= __( 'Taxonomy Grid', 'blog-designer-pack' );
		$this->widget_name			= __( 'BDPP - Taxonomy Grid Shortcode', 'blog-designer-pack' );
		$this->widget_description	= __( 'Display taxonomy in a grid view.', 'blog-designer-pack' );
		$this->settings				= bdp_cat_grid_shortcode_fields();
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

		echo bdpp_render_taxonomy_grid( $instance );

		$this->widget_end( $args );
	}
}
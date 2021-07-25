<?php
/**
* Vertical Post Slider Widget Class.
*
* @package Blog Designer Pack Pro
* @since 1.0.1
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BDPP_Post_Scrolling_Widget extends WP_Widget {

	// Widget variables
	var $defaults;

	function __construct() {

		// Widget settings
		$widget_ops = array('classname' => 'bdpp-post-scrolling-widget', 'description' => __('Display posts with vertical slider view.', 'blog-designer-pack') );

		// Create the widget
		parent::__construct( 'bdpp-post-scrolling-widget', __('BDPP - Post Vertical Slider Widget', 'blog-designer-pack'), $widget_ops);

		// Widgets defaults
		$this->defaults = array(
			'title' 				=> esc_html__( 'Latest Posts', 'blog-designer-pack' ),
			'post_type'				=> BDPP_POST_TYPE,
			'taxonomy'				=> BDPP_CAT,
			'type'					=> '',
			'design' 				=> 'design-1',
			'show_date'				=> 1,
			'show_category'			=> 1,
			'sticky_posts'			=> 0,
			'limit' 				=> 5,
			'show_content'			=> 0,
			'content_words_limit'	=> 20,
			'media_size' 			=> 'thumbnail',
			'link_behaviour'		=> 'self',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'category' 				=> '',
			'exclude_cat'			=> '',
			'posts'					=> '',
			'hide_post'				=> '',
			'query_offset'			=> '',
			'style_id'				=> '',
			'css_class'				=> '',
			'arrows'				=> 1,
			'show_items'			=> 3,
			'height'				=> 400,
			'pause'					=> 4000,
			'speed'					=> 600,
			'autoplay'				=> 0,
			'autoplay_hover_pause'	=> 1,
			'direction'				=> 'up',
			'tab'					=> 'general',
		);
	}

	/**
	 * Updates the widget control options
	 *
	 * @package Post Slider and Carousel Pro
	 * @since 1.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance		= $old_instance;
		$new_instance 	= wp_parse_args( (array) $new_instance, $this->defaults );

		// Input fields
		$instance['title']					= bdpp_clean( $new_instance['title'] );
		$instance['post_type']				= bdpp_clean( $new_instance['post_type'] );
		$instance['taxonomy']				= bdpp_clean( $new_instance['taxonomy'] );
		$instance['category']				= bdpp_clean( $new_instance['category'] );
		$instance['exclude_cat']			= bdpp_clean( $new_instance['exclude_cat'] );
		$instance['posts']					= bdpp_clean( $new_instance['posts'] );
		$instance['hide_post']				= bdpp_clean( $new_instance['hide_post'] );
		$instance['type']					= bdpp_clean( $new_instance['type'] );
		$instance['design']					= bdpp_clean( $new_instance['design'] );
		$instance['media_size']				= bdpp_clean( $new_instance['media_size'] );
		$instance['link_behaviour']			= bdpp_clean( $new_instance['link_behaviour'] );
		$instance['orderby']				= bdpp_clean( $new_instance['orderby'] );
		$instance['show_date']				= ( !empty( $new_instance['show_date'] ) ) 				? 1 : 0;
		$instance['show_category']			= ( !empty( $new_instance['show_category'] ) ) 			? 1 : 0;
		$instance['show_content']			= ( !empty( $new_instance['show_content'] ) )			? 1 : 0;
		$instance['sticky_posts']			= ( !empty( $new_instance['sticky_posts'] ) )			? 1 : 0;	
		$instance['autoplay']				= ( !empty( $new_instance['autoplay'] ) ) 				? 1 : 0;
		$instance['autoplay_hover_pause']	= ( !empty( $new_instance['autoplay_hover_pause'] ) ) 	? 1 : 0;
		$instance['arrows']					= ( !empty( $new_instance['arrows'] ) ) 				? 1 : 0;		
		$instance['limit']					= bdpp_clean_number( $new_instance['limit'], 5, 'number' );
		$instance['query_offset']			= bdpp_clean_number( $new_instance['query_offset'], '' );		
		$instance['content_words_limit']	= bdpp_clean_number( $new_instance['content_words_limit'], 20 );
		$instance['show_items']				= bdpp_clean_number( $new_instance['show_items'], 3, 'number' );
		$instance['height']					= bdpp_clean_number( $new_instance['height'], '' );
		$instance['pause']					= bdpp_clean_number( $new_instance['pause'], 4000 );		
		$instance['speed']					= bdpp_clean_number( $new_instance['speed'], 600 );
		$instance['direction']				= bdpp_clean( $new_instance['direction'] );		
		$instance['style_id']				= bdpp_clean_number( $new_instance['style_id'], '' );
		$instance['order']					= ( strtolower($new_instance['order']) == 'asc' ) ? 'ASC' : 'DESC';
		$instance['css_class']				= bdpp_sanitize_html_classes( $new_instance['css_class'] );
		$instance['tab']					= bdpp_clean( $new_instance['tab'] );

		return $instance;
	}

	/**
	 * Displays the widget form in widget area
	 *
	 * @package Post Slider and Carousel Pro
	 * @since 1.0
	 */
	function form( $instance ) {
		$instance			= wp_parse_args( (array) $instance, $this->defaults );
		$widget_designs		= bdpp_post_scrolling_widget_designs();
		$support_post_types	= bdpp_get_post_types();
		$styles_data		= bdpp_get_style_data( 'simplified' );
		$saved_post_types	= ( $instance['type'] == 'trending' ) ? bdpp_get_option( 'trend_post_types', array() ) : bdpp_get_option( 'post_types', array() );
		$sel_post_type		= (!empty($instance['post_type']) && in_array($instance['post_type'], $saved_post_types)) ? $instance['post_type']    : '';
		$sel_taxonomy		= (!empty($instance['post_type']) && in_array($instance['post_type'], $saved_post_types)) ? $instance['taxonomy']     : '';
?>
		<div class="bdpp-scrolling-widget-content">
			<div class="bdpp-widget-title bdpp-widget-acc" data-target="general"><i class="dashicons dashicons-admin-generic"></i> <?php _e('General Fields', 'blog-designer-pack'); ?> <i class="dashicons dashicons-arrow-down-alt2" title="<?php _e('Click to toggle', 'blog-designer-pack'); ?>"></i></div>
			<div class="bdpp-widget-acc-cnt-wrap bdpp-widget-general <?php if( $instance['tab'] != 'general' ) { echo 'bdpp-hide'; } ?>">
				<!-- Title -->
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'blog-designer-pack'); ?>:</label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['title'] ); ?>" />
				</p>

				<!-- Design -->
				<p>
					<label for="<?php echo $this->get_field_id( 'design' ); ?>"><?php _e( 'Design', 'blog-designer-pack'); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'design' ); ?>" name="<?php echo $this->get_field_name( 'design' ); ?>">
						<?php if( !empty( $widget_designs ) ) {
							foreach ( $widget_designs as $design_key => $design_data ) {
								echo '<option value="'.$design_key.'" '.selected( $design_key, $instance['design'], false ).'>'.$design_data.'</option>';
							}
						}
						?>
					</select>
				</p>

				<!-- Show Date -->
				<p>
					<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e( 'Show Date', 'blog-designer-pack' ); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>">
						<option value="1" <?php selected( $instance['show_date'], 1 ); ?>><?php _e('Yes', 'blog-designer-pack'); ?></option>
						<option value="0" <?php selected( $instance['show_date'], 0 ); ?>><?php _e('No', 'blog-designer-pack'); ?></option>
					</select>
				</p>

				<!-- Show Category -->
				<p>
					<label for="<?php echo $this->get_field_id('show_category'); ?>"><?php _e( 'Show Category', 'blog-designer-pack' ); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>">
						<option value="1" <?php selected( $instance['show_category'], 1 ); ?>><?php _e('Yes', 'blog-designer-pack'); ?></option>
						<option value="0" <?php selected( $instance['show_category'], 0 ); ?>><?php _e('No', 'blog-designer-pack'); ?></option>
					</select>
				</p>
				
				<!-- Show Content -->
				<p>
					<label for="<?php echo $this->get_field_id('show_content'); ?>"><?php _e( 'Show Short Content', 'blog-designer-pack' ); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'show_content' ); ?>" name="<?php echo $this->get_field_name( 'show_content' ); ?>">
						<option value="1" <?php selected( $instance['show_content'], 1 ); ?>><?php _e('Yes', 'blog-designer-pack'); ?></option>
						<option value="0" <?php selected( $instance['show_content'], 0 ); ?>><?php _e('No', 'blog-designer-pack'); ?></option>
					</select>
				</p>
				
				<!-- Content Word Limit -->
				<p>
					<label for="<?php echo $this->get_field_id( 'content_words_limit' ); ?>"><?php _e( 'Content Word Limit', 'blog-designer-pack'); ?>:</label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'content_words_limit' ); ?>" name="<?php echo $this->get_field_name( 'content_words_limit' ); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['content_words_limit'] ); ?>" />
					<em><?php _e( 'Enter Content word limit e.g 20. Content word limit will only work if Show Short Content is set to Yes.', 'blog-designer-pack' ); ?></em>
				</p>

				<!-- Image Size -->
				<p>
					<label for="<?php echo $this->get_field_id('media_size'); ?>"><?php _e( 'Image Size', 'blog-designer-pack' ); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('media_size'); ?>" name="<?php echo $this->get_field_name('media_size'); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['media_size'] ); ?>" />
					<em><?php _e( 'Choose WordPress registered media size. e.g thumbnail, medium, medium_large, large, full.', 'blog-designer-pack' ); ?></em>
				</p>

				<!-- Link Target -->
				<p>
					<label for="<?php echo $this->get_field_id( 'link_behaviour' ); ?>"><?php _e( 'Link Target', 'blog-designer-pack'); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'link_behaviour' ); ?>" name="<?php echo $this->get_field_name( 'link_behaviour' ); ?>">
						<option value=""><?php _e('Open in Same Window', 'blog-designer-pack') ?></option>
						<option value="new" <?php selected( $instance['link_behaviour'], 'new' ); ?>><?php _e('Open in New Window', 'blog-designer-pack') ?></option>
					</select>
				</p>

				<!-- Style Manager -->
				<p>
					<label for="<?php echo $this->get_field_id( 'style_id' ); ?>"><?php _e( 'Style Manager', 'blog-designer-pack'); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'style_id' ); ?>" name="<?php echo $this->get_field_name( 'style_id' ); ?>">
						<?php if( ! empty( $styles_data ) ) {
							foreach ( $styles_data as $style_key => $style_val ) {
								echo '<option value="'.$style_key.'" '.selected( $instance['style_id'], $style_key, false ).'>'.$style_val.'</option>';
							}
						} ?>
					</select>
					<em><?php _e( 'Choose your created style from style manager.', 'blog-designer-pack' ); ?></em>
				</p>

				<!-- CSS Class -->
				<p>
					<label for="<?php echo $this->get_field_id('css_class'); ?>"><?php _e( 'CSS Class', 'blog-designer-pack' ); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('css_class'); ?>" name="<?php echo $this->get_field_name('css_class'); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['css_class'] ); ?>" />
					<em><?php _e( 'Add an extra CSS class for designing purpose.', 'blog-designer-pack' ); ?></em>
				</p>
			</div><!-- end .bdpp-widget-acc-cnt-wrap -->

			<div class="bdpp-widget-title bdpp-widget-acc" data-target="slider"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Slider Fields', 'blog-designer-pack'); ?> <i class="dashicons dashicons-arrow-down-alt2" title="<?php _e('Click to toggle', 'blog-designer-pack'); ?>"></i></div>
			<div class="bdpp-widget-acc-cnt-wrap bdpp-widget-slider <?php if( $instance['tab'] != 'slider' ) { echo 'bdpp-hide'; } ?>">
				
				<!-- Arrows -->
				<p>
					<label for="<?php echo $this->get_field_id('arrows'); ?>"><?php _e( 'Navigation Arrows', 'blog-designer-pack' ); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'arrows' ); ?>" name="<?php echo $this->get_field_name( 'arrows' ); ?>">
						<option value="1" <?php selected( $instance['arrows'], 1 ); ?>><?php _e('Yes', 'blog-designer-pack'); ?></option>
						<option value="0" <?php selected( $instance['arrows'], 0 ); ?>><?php _e('No', 'blog-designer-pack'); ?></option>
					</select>
				</p>

				<!-- Direction -->
				<p>
					<label for="<?php echo $this->get_field_id( 'direction' ); ?>"><?php _e( 'Direction', 'blog-designer-pack' ); ?>:</label>
					<select name="<?php echo $this->get_field_name( 'direction' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'direction' ); ?>">
						<option value="up" <?php selected( $instance['direction'], 'up' ); ?>><?php _e( 'Up', 'blog-designer-pack' ); ?></option>
						<option value="down" <?php selected( $instance['direction'], 'down' ); ?>><?php _e( 'Down', 'blog-designer-pack' ); ?></option>						
					</select>
				</p>

				<!-- Autoplay -->
				<p>
					<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e( 'Autoplay', 'blog-designer-pack' ); ?>:</label>
					<select name="<?php echo $this->get_field_name( 'autoplay' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'autoplay' ); ?>">
						<option value="0" <?php selected( $instance['autoplay'], 0 ); ?>><?php _e( 'Yes', 'blog-designer-pack' ); ?></option>
						<option value="1" <?php selected( $instance['autoplay'], 1 ); ?>><?php _e( 'No', 'blog-designer-pack' ); ?></option>						
					</select>
				</p>

				<!--  Autoplay Pause on Hover -->
				<p>
					<label for="<?php echo $this->get_field_id( 'autoplay_hover_pause' ); ?>"><?php _e( ' Autoplay Pause on Hover', 'blog-designer-pack' ); ?>:</label>
					<select name="<?php echo $this->get_field_name( 'autoplay_hover_pause' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'autoplay_hover_pause' ); ?>">
						<option value="1" <?php selected( $instance['autoplay_hover_pause'], 1 ); ?>><?php _e( 'Yes', 'blog-designer-pack' ); ?></option>
						<option value="0" <?php selected( $instance['autoplay_hover_pause'], 0 ); ?>><?php _e( 'No', 'blog-designer-pack' ); ?></option>						
					</select>
				</p>

				<!-- show items -->
				<p>
					<label for="<?php echo $this->get_field_id( 'show_items' ); ?>"><?php _e( 'Show Number of Items', 'blog-designer-pack'); ?>:</label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'show_items' ); ?>" name="<?php echo $this->get_field_name( 'show_items' ); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['show_items'] ); ?>" />
				</p>

				<!-- Height -->
				<p>
					<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height', 'blog-designer-pack'); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['height'] ); ?>" />
					<em><?php _e( 'Note : If you pass the height then `Number of Items` will not work.', 'blog-designer-pack' ); ?></em>
				</p>
				
				<!-- Pause -->
				<p>
					<label for="<?php echo $this->get_field_id( 'pause' ); ?>"><?php _e( 'Interval', 'blog-designer-pack'); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'pause' ); ?>" name="<?php echo $this->get_field_name( 'pause' ); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['pause'] ); ?>" />
				</p>

				<!-- Speed -->
				<p>
					<label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Speed', 'blog-designer-pack'); ?>:</label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'speed' ); ?>" name="<?php echo $this->get_field_name( 'speed' ); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['speed'] ); ?>" />
				</p>
				
			</div><!-- end .bdpp-widget-acc-cnt-wrap -->

			<div class="bdpp-widget-title bdpp-widget-acc" data-target="query"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Query Fields', 'blog-designer-pack'); ?> <i class="dashicons dashicons-arrow-down-alt2" title="<?php _e('Click to toggle', 'blog-designer-pack'); ?>"></i></div>
			<div class="bdpp-widget-acc-cnt-wrap bdpp-widget-query <?php if( $instance['tab'] != 'query' ) { echo 'bdpp-hide'; } ?>">
				<!-- Limit -->
				<p>
					<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Number of Items', 'blog-designer-pack'); ?>:</label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['limit'] ); ?>" />
				</p>

				<!-- Order By -->
				<p>
					<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'blog-designer-pack' ); ?>:</label>
					<select name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>">
						<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php _e( 'Post Date', 'blog-designer-pack' ); ?></option>
						<option value="modified" <?php selected( $instance['orderby'], 'modified' ); ?>><?php _e( 'Post Updated Date', 'blog-designer-pack' ); ?></option>
						<option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php _e( 'Post Id', 'blog-designer-pack' ); ?></option>
						<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php _e( 'Post Title', 'blog-designer-pack' ); ?></option>
						<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php _e( 'Random', 'blog-designer-pack' ); ?></option>
						<option value="menu_order" <?php selected( $instance['orderby'], 'menu_order' ); ?>><?php _e( 'Menu Order (Sort Order)', 'blog-designer-pack' ); ?></option>
					</select>
				</p>

				<!-- Order -->
				<p>
					<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order', 'blog-designer-pack' ); ?>:</label>
					<select name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>">
						<option value="asc" <?php selected( $instance['order'], 'ASC' ); ?>><?php _e( 'Ascending', 'blog-designer-pack' ); ?></option>
						<option value="desc" <?php selected( $instance['order'], 'DESC' ); ?>><?php _e( 'Descending', 'blog-designer-pack' ); ?></option>
					</select>
				</p>

				<!-- Type -->
				<p>
					<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Post Display Type', 'blog-designer-pack' ); ?>:</label>
					<select name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat bdpp-post-display-types" id="<?php echo $this->get_field_id( 'type' ); ?>">
						<option value=""><?php _e( 'Default Posts', 'blog-designer-pack' ); ?></option>
						<option value="featured" <?php selected( $instance['type'], 'featured' ); ?>><?php _e( 'Featured Post', 'blog-designer-pack' ); ?></option>
						<option value="trending" <?php selected( $instance['type'], 'trending' ); ?>><?php _e( 'Trending Post', 'blog-designer-pack' ); ?></option>
					</select>
					<em><?php _e( 'Select display type of post. Is it Featured or Trending?', 'blog-designer-pack' ); ?></em>
				</p>

				<!-- Post type -->
				<p>
					<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e( 'Post Type', 'blog-designer-pack' ); ?>:</label>
					<select class="widefat bdpp-reg-post-types" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" >
						<?php
						if( !empty( $saved_post_types ) && !empty( $support_post_types ) ) {
							foreach ( $support_post_types as $post_key => $post_value ) {
								if( in_array( $post_key, $saved_post_types ) ) {
									echo '<option value="'.$post_key.'" '. selected( $post_key, $instance['post_type'], false ) .'>'.$post_value.'</option>';
								}
							}
						} else {
							echo '<option value="">'.__('No Post Type Found', 'blog-designer-pack').'</option>';
						}
						?>
					</select>
				</p>

				<!-- Taxonomy  -->
				<p>
					<label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e( 'Taxonomy', 'blog-designer-pack' ); ?>:</label>
					<select class="widefat bdpp-reg-taxonomy" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
					<?php
						$taxonomy_objects	= get_object_taxonomies( $sel_post_type, 'object' );
						$taxonomy			= bdpp_get_taxonomy_options( $taxonomy_objects, $sel_taxonomy );
						echo $taxonomy;
					?>
					</select>
				</p>

				<!-- Sticky Post -->
				<p>
					<label for="<?php echo $this->get_field_id('sticky_posts'); ?>"><?php _e( 'Display Sticky Posts', 'blog-designer-pack' ); ?>:</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'sticky_posts' ); ?>" name="<?php echo $this->get_field_name( 'sticky_posts' ); ?>">
						<option value="1" <?php selected( $instance['sticky_posts'], 1 ); ?>><?php _e('Yes', 'blog-designer-pack'); ?></option>
						<option value="0" <?php selected( $instance['sticky_posts'], 0 ); ?>><?php _e('No', 'blog-designer-pack'); ?></option>
					</select>
				</p>

				<!-- Category -->
				<p>
					<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Display Specific Category', 'blog-designer-pack' ); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['category'] ); ?>" />
					<em><?php _e( 'Enter category id to display categories wise.', 'blog-designer-pack' ); ?> <label title="<?php _e("You can pass multiple ids with comma seperated. You can find id at relevant category listing page. \n\nPlease be sure that you have added valid category id for chosen post type otherwise no result will be displayed.", 'blog-designer-pack'); ?>">[?]</label></em>
				</p>

				<!-- Exclude Category -->
				<p>
					<label for="<?php echo $this->get_field_id('exclude_cat'); ?>"><?php _e( 'Exclude Category', 'blog-designer-pack' ); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('exclude_cat'); ?>" name="<?php echo $this->get_field_name('exclude_cat'); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['exclude_cat'] ); ?>" />
					<em><?php _e( 'Exclude post category. Works only if `Category` field is empty.', 'blog-designer-pack' ); ?> <label title="<?php _e("You can pass multiple ids with comma seperated. You can find id at relevant category listing page. \n\nPlease be sure that you have added valid category id for chosen post type otherwise no result will be displayed.", 'blog-designer-pack'); ?>">[?]</label></em>
				</p>

				<!-- Posts -->
				<p>
					<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e( 'Display Specific Post', 'blog-designer-pack' ); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['posts'] ); ?>" />
					<em><?php _e( 'Enter id of post which you want to display.', 'blog-designer-pack' ); ?> <label title="<?php _e('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'blog-designer-pack'); ?>">[?]</label></em>
				</p>

				<!-- Hide Post -->
				<p>
					<label for="<?php echo $this->get_field_id('hide_post'); ?>"><?php _e( 'Exclude Post', 'blog-designer-pack' ); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('hide_post'); ?>" name="<?php echo $this->get_field_name('hide_post'); ?>" type="text" value="<?php echo bdpp_esc_attr( $instance['hide_post'] ); ?>" />
					<em><?php _e( 'Enter id of post which you do not want to display.', 'blog-designer-pack' ); ?> <label title="<?php _e('You can pass multiple ids with comma seperated. You can find id at relevant post listing page.', 'blog-designer-pack'); ?>">[?]</label></em>
				</p>

				<!-- Query Offset -->
				<p>
					<label for="<?php echo $this->get_field_id('query_offset'); ?>"><?php esc_html_e( 'Query Offset', 'blog-designer-pack' ); ?>:</label>
					<input class="widefat" id="<?php echo $this->get_field_id('query_offset'); ?>" name="<?php echo $this->get_field_name('query_offset'); ?>" type="text" value="<?php echo $instance['query_offset']; ?>" />
					<em><?php _e('Query `offset` parameter to exclude number of post. Leave empty for default.', 'blog-designer-pack'); ?></em><br/>
					<em><?php _e('Note: This parameter will not work when Number of Items is set to -1.', 'blog-designer-pack'); ?></em>
				</p>
			</div><!-- end .bdpp-widget-acc-cnt-wrap -->

			<input type="hidden" name="<?php echo $this->get_field_name('tab'); ?>" value="<?php echo bdpp_esc_attr( $instance['tab'] ); ?>" class="bdpp-widget-sel-tab" />
			<div class="bdpp-widget-loader"></div>
		</div><!-- end .bdpp-widget-content -->
	<?php
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @package Post Slider and Carousel Pro
	 * @since 1.0
	 */
	function widget( $widget_args, $instance ) {
		$atts = wp_parse_args( (array) $instance, $this->defaults );
		extract($widget_args, EXTR_SKIP);

		$widget_designs			= bdpp_post_scrolling_widget_designs();
		$saved_post_types 		= ( $atts['type'] == 'trending' ) ? bdpp_get_option( 'trend_post_types', array() ) : bdpp_get_option( 'post_types', array() );
		$title					= apply_filters( 'widget_title', $atts['title'], $atts, $this->id_base );
		$atts['link_behaviour']	= ( $atts['link_behaviour'] == 'new' )	? '_blank'								: '_self';
		$atts['sticky_posts']	= !empty( $atts['sticky_posts'] )		? false : true;
		$atts['category'] 		= !empty( $atts['category'] )			? explode(',', $atts['category']) 		: array();
		$atts['exclude_cat']	= !empty( $atts['exclude_cat'] )		? explode(',', $atts['exclude_cat'])	: array();
		$atts['posts']			= !empty( $atts['posts'] )				? explode(',', $atts['posts']) 			: array();
		$atts['hide_post']		= !empty( $atts['hide_post'] )			? explode(',', $atts['hide_post']) 		: array();
		$atts['post_type']      = (!empty($atts['post_type']) && in_array($atts['post_type'], $saved_post_types)) ? $atts['post_type']    : '';
		$atts['taxonomy']       = (!empty($atts['post_type']) && in_array($atts['post_type'], $saved_post_types)) ? $atts['taxonomy']     : '';		
		$atts['design'] 		= ($atts['design'] && (array_key_exists(trim($atts['design']), $widget_designs))) ? trim( $atts['design'] ) : 'design-1';
		$atts['css_class']		.= ! empty( $atts['style_id'] ) ? " bdpp-style-mngr-{$atts['style_id']}" : '';
		$atts['unique']			= bdpp_get_unique();

		// Extract widget Var
		extract($atts);

		// Taking some globals
		global $post;

		// Enqueue required scripts
		wp_enqueue_script( 'jquery-vticker' );
		wp_enqueue_script( 'bdpp-public-script' );
		bdpp_enqueue_script();

		// Taking some variables
		$count  				= 1;
		$prefix					= BDPP_META_PREFIX;
		$atts['slider_conf'] 	= compact('show_items', 'speed', 'height', 'pause', 'direction', 'autoplay', 'autoplay_hover_pause');

		// WP Query Parameters
		$args = array( 
			'post_type'				=> $post_type,
			'post_status' 			=> array('publish'),
			'order'					=> $order,
			'orderby'				=> $orderby,
			'posts_per_page' 		=> $limit,
			'post__in'		 		=> $posts,
			'post__not_in'	 		=> $hide_post,
			'offset'				=> $query_offset,
			'no_found_rows'			=> true,
			'ignore_sticky_posts'	=> $sticky_posts,
		);

		// Category Parameter
		if( $category ) {

			$args['tax_query'] = array(
									array( 
										'taxonomy' 	=> $taxonomy,
										'field' 	=> 'term_id',
										'terms' 	=> $category,
									));

		} else if( $exclude_cat ) {
			
			$args['tax_query'] = array(
										array(
											'taxonomy' 	=> $taxonomy,
											'field' 	=> 'term_id',
											'terms' 	=> $exclude_cat,
											'operator'	=> 'NOT IN',
										));
		}

		// For featured post
		if( $type == 'featured' ) {

			$args['meta_query'] = array(
										array(
											'key'	=> $prefix.'feat_post',
											'value'	=> 1,
										),
									);

		} else if( $type == 'trending' ) {

			$args['orderby'] 	= ( $orderby == 'post_views' ) ? 'meta_value_num' : $orderby;
			$args['meta_query'] = array(
										array(
											'key'		=> $prefix.'post_views',
											'value'		=> 0,
											'compare' 	=> '>',
										),
									);
		}

		$args = apply_filters( 'bdpp_post_scrolling_widget_query_args', $args, $atts );
		$args = apply_filters( 'bdpp_posts_query_args', $args, $atts );

		// WP Query
		$query = new WP_Query( $args );

		// Start Widget Output
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if( empty( $post_type ) ) {

			echo esc_html__('Sorry, No Post Type is configured. Please enable form plugin settings and choose within widget.', 'blog-designer-pack');

		} elseif( $query->have_posts() ) {

			bdpp_generate_style( $style_id, 'widget', 'slider', 'bdpp-post-scrolling-widget', $atts );			

			bdpp_get_template( 'widget/post-scrolling/loop-start.php', $atts );

			while ( $query->have_posts() ) : $query->the_post();

				$atts['count']      = $count++;
				$atts['format']		= bdpp_get_post_format();
				$atts['feat_img'] 	= bdpp_get_post_feat_image( $post->ID, $media_size, true );
				$atts['post_link'] 	= bdpp_get_post_link( $post->ID );
				$atts['cate_name'] 	= bdpp_get_post_terms( $post->ID, $taxonomy );

				$atts['wrp_cls']	= "bdpp-post-{$atts['format']}";
				$atts['wrp_cls']	.= ( is_sticky( $post->ID ) ) ? ' bdpp-sticky'		: '';
				$atts['wrp_cls'] 	.= empty($atts['feat_img'])	  ? ' bdpp-no-thumb'	: ' bdpp-has-thumb';				

				// Creating image style
				if( $atts['feat_img']) {
					$atts['image_style'] = 'style="background-image:url('.esc_url( $atts['feat_img'] ).');"';
				}

				// Include Dsign File
				bdpp_get_template( "widget/post-scrolling/{$design}.php", $atts );

			endwhile;

			bdpp_get_template( 'widget/post-scrolling/loop-end.php', $atts );

		} // end of have_post()

		wp_reset_postdata(); // Reset WP Query

		echo $after_widget;
	}
}
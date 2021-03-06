<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');


if (function_exists('visual_composer')) {
	add_action('init', 'disableVisualComposerMeta', 100);
	function disableVisualComposerMeta() {
		remove_action('wp_head', array(visual_composer(), 'addMetaData'));
	}
}


add_action( 'vc_before_init', 'avenue_vc_settings' );
function avenue_vc_settings() {
	vc_set_as_theme(true);
	vc_set_default_editor_post_types(array(
		'page',
		'product',
		'project',
	));
}

if (defined('WPB_VC_VERSION')) {
	remove_action( 'wp_enqueue_scripts', 'vc_woocommerce_add_to_cart_script' );

	add_action('wp_enqueue_scripts', 'avenue_vc_woocommerce_add_to_cart_script');
	function avenue_vc_woocommerce_add_to_cart_script() {
		wp_enqueue_script( 'vc_woocommerce-add-to-cart-js', vc_asset_url( 'js/vendors/woocommerce-add-to-cart.js' ), array( 'wc-add-to-cart' ), WPB_VC_VERSION, true );
	}
}


class avenueVCAddons {
		function __construct() {
			// We safely integrate with VC with this hook
			if (!defined('WPB_VC_VERSION')) {
				return;
			}

			add_action( 'init', array( $this, 'integrate_with_vc' ) );

			add_filter( 'vc_autocomplete_avenue_vc_project_grid_include_callback', array( $this, 'vc_include_field_search' ), 10, 1 );
			add_filter( 'vc_autocomplete_avenue_vc_project_grid_include_render', array( $this, 'vc_include_field_render' ), 10, 1 );
			add_filter( 'vc_autocomplete_avenue_vc_project_grid_taxonomies_callback', array( $this, 'vc_autocomplete_projects_categories_field_search' ), 10, 1 );
			add_filter( 'vc_autocomplete_avenue_vc_project_grid_taxonomies_render', array( $this, 'vc_autocomplete_projects_categories_field_render' ), 10, 1 );

			// Use this when creating a shortcode addon
			$avenue_add_shrtcd = 'add_' . 'shortcode';
			$avenue_add_shrtcd( 'avenue_vc_project_grid', array( $this, 'render_avenue_vc_project_grid' ) );
			$avenue_add_shrtcd( 'avenue_vc_team_member', array( $this, 'render_avenue_vc_team_member' ) );

			// Register CSS and JS
			// add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
		}


		public function vc_include_field_search( $search_string ) {
			$query = $search_string;
			$data = array();
			$args = array(
				's' => $query,
				'post_type' => 'project',
			);
			$args['vc_search_by_title_only'] = true;
			$args['numberposts'] = - 1;
			if ( 0 === strlen( $args['s'] ) ) {
				unset( $args['s'] );
			}
			add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
			$posts = get_posts( $args );
			if ( is_array( $posts ) && ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$data[] = array(
						'value' => $post->ID,
						'label' => $post->post_title,
						'group' => $post->post_type,
					);
				}
			}

			return $data;
		}


		public function vc_include_field_render( $value ) {
			$post = get_post( $value['value'] );

			return is_null( $post ) ? false : array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}


		public function vc_autocomplete_projects_categories_field_search( $search_string ) {
			$data = array();
			$projects_categories = get_terms( 'projects_category', array(
				'hide_empty' => false,
				'search' => $search_string,
			) );
			if ( ! empty( $projects_categories ) && ! is_wp_error( $projects_categories ) ){
				foreach ( $projects_categories as $project_category ) {
					if ( is_object( $project_category ) ) {
						$data[] = array(
							'label'    => $project_category->name,
							'value'    => $project_category->term_id,
							'group_id' => $project_category->taxonomy,
						);
					}
				}
			}

			return $data;
		}


		public function vc_autocomplete_projects_categories_field_render( $term ) {
			$terms = get_terms( 'projects_category', array(
				'include' => array( $term['value'] ),
				'hide_empty' => false,
			) );
			$data = false;
			if ( is_array( $terms ) && 1 === count( $terms ) ) {
				$term = $terms[0];
				$data = vc_get_term_object( $term );
			}

			return $data;
		}


		public function integrate_with_vc() {
			/*
			Add your Visual Composer logic here.
			Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

			More info: http://kb.wpbakery.com/index.php?title=Vc_map
			*/

			$size_names = array_flip(get_image_size_names());

			vc_map( array(
				'name' => esc_html__('Project Grid', 'avenue'),
				'base' => 'avenue_vc_project_grid',
				'icon' => 'icon-wpb-application-icon-large',
				'content_element' => true,
				'category' => 'Avenue',
				'description' => esc_html__('Posts, pages or custom posts in grid', 'avenue'),
				'params' => array(
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('List of IDs', 'avenue'),
						'param_name' => 'ids',
						'value' => array( esc_html__('Yes', 'avenue') => 'yes' ),
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__('Include only', 'avenue'),
						'param_name' => 'include',
						'description' => esc_html__('Add projects by title.', 'avenue'),
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
							'groups' => true,
						),
						'dependency' => array(
							'element' => 'ids',
							'value' => array( 'yes' ),
						),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Show filter', 'avenue'),
						'param_name' => 'filter',
						'value' => array( esc_html__('Yes', 'avenue') => 'yes' ),
						'description' => esc_html__('Append filter to grid.', 'avenue'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Alignment', 'avenue'),
						'param_name' => 'filter_align',
						'value' => array(
							esc_html__('Center', 'avenue') => 'center',
							esc_html__('Left', 'avenue') => 'left',
							esc_html__('Right', 'avenue') => 'right',
						),
						'std' => 'center',
						'dependency' => array(
							'element' => 'filter',
							'value' => array( 'yes' ),
						),
						'description' => esc_html__('Select filter alignment.', 'avenue'),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Light text for filter', 'avenue'),
						'param_name' => 'light_text_filter',
						'value' => array( esc_html__('Yes', 'avenue') => 'yes' ),
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__('Narrow data source', 'avenue'),
						'param_name' => 'taxonomies',
						'settings' => array(
							'multiple' => true,
							'min_length' => 1,
							'groups' => true,
							'unique_values' => true,
							'display_inline' => true,
							'delay' => 500,
							'auto_focus' => true,
						),
						'param_holder_class' => 'vc_not-for-custom',
						'description' => esc_html__('Enter categories, tags or custom taxonomies.', 'avenue'),
						'dependency' => array(
							'element' => 'ids',
							'value_not_equal_to' => array( 'yes' ),
						),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Total items', 'avenue'),
						'param_name' => 'items',
						'value' => 9,
						'description' => esc_html__('Set max limit for items in grid or enter -1 to display all.', 'avenue'),
						'dependency' => array(
							'element' => 'ids',
							'value_not_equal_to' => array( 'yes' ),
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Grid columns', 'avenue'),
						'param_name' => 'items_columns',
						'value' => array(
							'4 columns' => 4,
							'3 columns' => 3,
							'2 columns' => 2,
							'1 column' => 1,
						),
						'std' => 3,
						'description' => esc_html__('Select number of single grid columns.', 'avenue'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Gap', 'avenue'),
						'param_name' => 'gap',
						'value' => array(
							'0px' => 0,
							'2px' => 1,
							'4px' => 2,
							'10px' => 5,
							'20px' => 10,
							'30px' => 15,
						),
						'std' => 15,
						'description' => esc_html__('Select gap between grid columns.', 'avenue'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Use expanded grid columns on big screens', 'avenue'),
						'param_name' => 'items_expanded_columns',
						'value' => array( esc_html__('Yes', 'avenue') => 'yes' ),
						'description' => esc_html__('2 to 3, 3 to 4, 4 to 6 columns on big screes.', 'avenue'),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Use double height and double width view', 'avenue'),
						'param_name' => 'double',
						'value' => array( esc_html__('Yes', 'avenue') => 'yes' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Image size', 'avenue'),
						'param_name' => 'img_size',
						'value' => $size_names,
						'dependency' => array(
							'not_empty' => true,
						),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Large font size', 'avenue'),
						'param_name' => 'large_font_size',
						'value' => array( esc_html__('Yes', 'avenue') => 'yes' ),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Color to overlay image on hover', 'avenue'),
						'param_name' => 'img_overlay',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Title align', 'avenue'),
						'param_name' => 'title_align',
						'value' => array(
							esc_html__('Left', 'avenue') => 'left',
							esc_html__('Center', 'avenue') => 'center',
							esc_html__('Right', 'avenue') => 'right',
						),
						'std' => 'center',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Animation on hover', 'avenue'),
						'param_name' => 'animation',
						'value' => array(
							'No' => '',
							'Simple' => '1',
							'Simple (reverse)' => '2',
							'Blur' => '3',
							'Colorful' => '4',
							'Bordered' => '5',
							'Slice' => '6',
							'Grayscale' => '7',
							'Boxed' => '8',
							'Boxed Big' => '9',
							'Lined Vertical' => '11',
						),
						'std' => '',
					),
					array(
						'type' => 'vc_grid_id',
						'param_name' => 'grid_id',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Extra class name', 'avenue'),
						'param_name' => 'ex_class',
						'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'avenue'),
					),
					array(
						'type' => 'css_editor',
						'heading' => esc_html__('CSS box', 'avenue'),
						'param_name' => 'css',
						'group' => esc_html__('Design Options', 'avenue'),
					),
				),
			) );

			vc_map( array(
				'name' => esc_html__('Team Member', 'avenue'),
				'base' => 'avenue_vc_team_member',
				'content_element' => true,
				'category' => 'Avenue',
				'description' => esc_html__('Display a team member with effects, description and social icons', 'avenue'),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Name', 'avenue'),
						'param_name' => 'title',
						'admin_label' => true,
						'description' => esc_html__('Type your team member name.', 'avenue'),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Job Title', 'avenue'),
						'param_name' => 'job',
						'description' => esc_html__('Type your team member job title, e.g. Manager.', 'avenue'),
					),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__('Photo', 'avenue'),
						'param_name' => 'img',
						'value' => '',
						'description' => esc_html__('Upload or select a photo from media gallery.', 'avenue'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Photo size', 'avenue'),
						'param_name' => 'img_size',
						'value' => $size_names,
						'dependency' => array(
							'element' => 'img',
							'not_empty' => true,
						),
					),
					array(
						'type' => 'textarea_html',
						'heading' => esc_html__('Description', 'avenue'),
						'param_name' => 'content',
						'value' => '',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Text Position', 'avenue'),
						'param_name' => 'txt_position',
						'value' => array(
							esc_html__('Text and social links after photo', 'avenue') => '',
							esc_html__('Text and social links on second slide (on hover)', 'avenue') => '__card __anim_1',
							esc_html__('Text on first slide, social links on second (on hover)', 'avenue') => '__card __anim_2',
						),
						'std' => '',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Text Vertical Alignment', 'avenue'),
						'param_name' => 'txt_vertical_align',
						'value' => array(
							esc_html__('Top', 'avenue') => '__top',
							esc_html__('Middle', 'avenue') => '__middle',
							esc_html__('Bottom', 'avenue') => '__bottom',
						),
						'std' => '__middle',
						'dependency' => array(
							'element' => 'txt_position',
							'not_empty' => true,
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Text Alignment', 'avenue'),
						'param_name' => 'txt_align',
						'value' => array(
							esc_html__('Center', 'avenue') => 'text-center',
							esc_html__('Left', 'avenue') => 'text-left',
							esc_html__('Right', 'avenue') => 'text-right',
						),
						'std' => 'text-center',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Color scheme', 'avenue'),
						'param_name' => 'color_scheme',
						'value' => array(
							esc_html__('Light', 'avenue') => '__light',
							esc_html__('Dark', 'avenue') => '__dark',
						),
						'std' => '__light',
						'dependency' => array(
							'element' => 'txt_position',
							'is_empty' => true,
						),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Boxed', 'avenue'),
						'param_name' => 'boxed',
						'value' => array( esc_html__('Yes', 'avenue') => '__boxed' ),
						'dependency' => array(
							'element' => 'txt_position',
							'is_empty' => true,
						),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__('Scale photo on hover', 'avenue'),
						'param_name' => 'img_scale',
						'value' => array( esc_html__('Yes', 'avenue') => '__scale' ),
						'dependency' => array(
							'element' => 'txt_position',
							'not_empty' => true,
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Filter for photo on hover', 'avenue'),
						'param_name' => 'img_filter',
						'value' => array(
							'Disable' => '',
							'Grayscale (color to gray)' => '__gray',
							'Grayscale (gray to color)' => '__color',
						),
						'std' => '',
						'dependency' => array(
							'element' => 'txt_position',
							'not_empty' => true,
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Overlay', 'avenue'),
						'param_name' => 'img_overlay',
						'value' => array(
							esc_html__('Disable', 'avenue') => '',
							esc_html__('First Slide', 'avenue') => '__overlay',
							esc_html__('Second Slide (on hover)', 'avenue') => '__on-hover',
							esc_html__('Both Slides', 'avenue') => '__both',
							esc_html__('Gradient On First Slide', 'avenue') => '__gradient',
							esc_html__('Gradient On Second Slide (on hover)', 'avenue') => '__gradient-on-hover',
							esc_html__('Gradient On Both Slides', 'avenue') => '__gradient-both',
						),
						'std' => '',
						'dependency' => array(
							'element' => 'txt_position',
							'not_empty' => true,
						),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Overlay Color', 'avenue'),
						'param_name' => 'img_overlay_color',
						'dependency' => array(
							'element' => 'img_overlay',
							'not_empty' => true,
						),
					),
					array(
						'type' => 'vc_grid_id',
						'param_name' => 'grid_id',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__('Extra class name', 'avenue'),
						'param_name' => 'ex_class',
						'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'avenue'),
					),
					array(
						'type' => 'css_editor',
						'heading' => esc_html__('CSS box', 'avenue'),
						'param_name' => 'css',
						'group' => esc_html__('Design Options', 'avenue'),
					),
				),
			) );

			$social_links = get_social_links();
			$avenue_vc_social_links = array();
			$avenue_vc_social_links[] = array(
				'type' => 'checkbox',
				'heading' => esc_html__('Use brand colors', 'avenue'),
				'param_name' => 'brand_colors',
				'group' => esc_html__('Social links', 'avenue'),
			);
			foreach ($social_links as $id => $icon_and_name) {
				$avenue_vc_social_links[] = array(
					'type' => 'textfield',
					'heading' => $icon_and_name,
					'param_name' => $id,
					'group' => esc_html__('Social links', 'avenue'),
				);
			}
			vc_add_params( 'avenue_vc_team_member', $avenue_vc_social_links );
		}

		/*
		Shortcode logic how it should be rendered
		*/
		public function render_avenue_vc_project_grid($atts, $content = null) {
			$atts = shortcode_atts( array(
				'ids' => false,
				'include' => '',
				'filter' => false,
				'filter_align' => 'center',
				'light_text_filter' => false,
				'taxonomies' => '',
				'items' => 9,
				'items_columns' => 3,
				'items_expanded_columns' => false,
				'gap' => 15,
				'double' => false,
				'img_size' => 'full',
				'large_font_size' => false,
				'img_overlay' => '',
				'title_align' => 'center',
				'animation' => false,
				'grid_id' => false,
				'ex_class' => false,
				'css' => false,
			), $atts );

			if ($atts['ids']) {
				$args = array(
					'post_type' => 'project',
					'post__in'  => explode(", ", $atts['include']),
				);
			} else {
				$args = array(
					'post_type' => 'project',
					'posts_per_page' => $atts['items'],
					'post_status' => 'publish',
					'tax_query' => !$atts['taxonomies'] ?  array() : array(
						array(
							'taxonomy' => 'projects_category',
							'field'    => 'term_id',
							'terms'    => explode(", ", $atts['taxonomies']),
						),
					),
				);
			}

			$projects = new WP_Query($args);

			if ($projects->have_posts()) {
				ob_start();
				include get_template_directory() . '/plugins/js_composer/templates/project_grid.php';
				$output = ob_get_contents();
				ob_get_clean();

				wp_reset_postdata();

				return $output;
			}
		}

		public function render_avenue_vc_team_member($atts, $content = null) {
			$social_links = get_social_links();
			$default_social_links = array();
			foreach ($social_links as $id => $icon_and_name) {
				$default_social_links[$id] = '';
			}

			$default_atts = array_merge( array(
				'title' => '',
				'job' => '',
				'img' => '',
				'img_size' => 'full',
				'color_scheme' => '__light',
				'boxed' => '',
				'txt_position' => '',
				'txt_vertical_align' => '__middle',
				'txt_align' => 'text-center',
				'img_scale' => '',
				'img_filter' => '',
				'img_overlay' => '',
				'img_overlay_color' => '',
				'grid_id' => false,
				'ex_class' => false,
				'css' => false,
				'brand_colors' => false,
			), $default_social_links );

			$atts = shortcode_atts( $default_atts, $atts );

			ob_start();
			include get_template_directory() . '/plugins/js_composer/templates/team_member.php';
			$output = ob_get_contents();
			ob_get_clean();

			return $output;
		}

		/*
		Load plugin css and javascript files which you may need on front end of your site
		*/
		// public function loadCssAndJs() {
		// 	If you need any css files on front end, here is how you can load them.
		// 	wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
		// 	wp_enqueue_style( 'vc_extend_style' );

		// 	If you need any javascript files on front end, here is how you can load them.
		// 	wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
		// }
}
// Finally initialize code
new avenueVCAddons();

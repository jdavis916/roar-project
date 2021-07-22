<?php
Redux::setSection( $opt_name, array(
	'id' => 'sec_single_post',
	'title' => esc_html__('Single post', 'avenue'),
	'desc' => esc_html__('Change single post templates.', 'avenue'),
	'icon' => 'el el-pencil-alt',
	'fields' => array(
		array(
			'id' => 'single_post--layout--sidebars',
			'type' => 'image_select',
			'title' => esc_html__( 'Sidebars in single post', 'avenue' ),
			'subtitle' => esc_html__( 'Select the layout to be used in single post.', 'avenue' ),
			'options' => array(
				'' => array(
					'alt' => 'default',
					'img' => get_template_directory_uri() . '/images/sidebars/def.png'
				),
				'without' => array(
					'alt' => 'without sidebar',
					'img' => get_template_directory_uri() . '/images/sidebars/1c.png'
				),
				'left' => array(
					'alt' => 'sidebar at left',
					'img' => get_template_directory_uri() . '/images/sidebars/2cl.png'
				),
				'right' => array(
					'alt' => 'sidebar at right',
					'img' => get_template_directory_uri() . '/images/sidebars/2cr.png'
				)
			),
			'default' => '',
		),

		array(
			'id' => 'single_post--layout--content_width',
			'type' => 'select',
			'title' => esc_html__('Content container type', 'avenue'),
			'subtitle' => esc_html__('Define container configuration to be used, it can be normal, expanded or compact.', 'avenue'),
			'options' => array(
				'expanded' => esc_html__('Expanded', 'avenue'),
				'normal' => esc_html__('Normal', 'avenue'),
				'compact' => esc_html__('Compact', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'single_post--featured_image',
			'type' => 'switch',
			'title' => esc_html__('Featured image', 'avenue'),
			'subtitle' => esc_html__('If on, featured image will be displayed at single post before content.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'single_post--categories',
			'type' => 'switch',
			'title' => esc_html__('Categories', 'avenue'),
			'subtitle' => esc_html__('If on, categories will be displayed.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'single_post--author',
			'type' => 'switch',
			'title' => esc_html__('Author', 'avenue'),
			'subtitle' => esc_html__('If on, the author will be displayed.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'single_post--share',
			'type' => 'switch',
			'title' => esc_html__('Social share', 'avenue'),
			'subtitle' => esc_html__('If on, social share icons will be displayed.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'single_post--tags',
			'type' => 'switch',
			'title' => esc_html__('Tags after content', 'avenue'),
			'subtitle' => esc_html__('If on, the tags will be displayed after post content.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'single_post--nav',
			'type' => 'switch',
			'title' => esc_html__('Post navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be displayed below content.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'single_post--nav__fixed',
			'type' => 'switch',
			'title' => esc_html__('Fixed post navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be fixed in the middle of browser window.', 'avenue'),
			'default' => 0,
			'required' => array('single_post--nav', '=', 1),
		),

		array(
			'id' => 'single_post--header_section',
			'type' => 'section',
			'title' => esc_html__('Header settings at single post', 'avenue'),
			'indent' => true,
		),

			array(
				'id' => 'single_post--header--negative_height',
				'type' => 'button_set',
				'title' => esc_html__('Negative height', 'avenue'),
				'subtitle' => esc_html__('If on, header and top header will not have height and background and title wrapper or content will be showed behind it.', 'avenue'),
				'options' => array(
					'1' => esc_html__('On', 'avenue'),
					'' => esc_html__('Default', 'avenue'),
					'0' => esc_html__('Off', 'avenue'),
				),
				'default' => '',
			),

			array(
				'id' => 'single_post--header--color_scheme',
				'type' => 'select',
				'title' => esc_html__('Color scheme for header', 'avenue'),
				'options' => array(
					'light' => esc_html__('Light text', 'avenue'),
					'dark' => esc_html__('Dark text', 'avenue'),
				),
				'default' => '',
			),

		array(
			'id' => 'single_post--header_section__end',
			'type' => 'section',
			'indent' => false,
		),

		array(
			'id' => 'single_post--title_wrapper_section',
			'type' => 'section',
			'title' => esc_html__('Title wrapper settings at single post', 'avenue'),
			'indent' => true,
		),

			array(
				'id' => 'single_post--title_wrapper',
				'type' => 'button_set',
				'title' => esc_html__('Title wrapper at single post', 'avenue'),
				'subtitle' => esc_html__('If on, title wrapper will be displayed at single post.', 'avenue'),
				'options' => array(
					'1' => esc_html__('On', 'avenue'),
					'' => esc_html__('Default', 'avenue'),
					'0' => esc_html__('Off', 'avenue'),
				),
				'default' => '',
			),

			array(
				'id' => 'single_post--title_wrapper--full_height',
				'type' => 'button_set',
				'title' => esc_html__('Full viewport height at single post', 'avenue'),
				'subtitle' => esc_html__('If on, title wrapper will have same height than viewport/window at single post.', 'avenue'),
				'options' => array(
					'1' => esc_html__('On', 'avenue'),
					'' => esc_html__('Default', 'avenue'),
					'0' => esc_html__('Off', 'avenue'),
				),
				'default' => '',
			),

			array(
				'id' => 'single_post--title_wrapper--parallax',
				'type' => 'button_set',
				'title' => esc_html__('Title wrapper parallax at single post', 'avenue'),
				'options' => array(
					'1' => esc_html__('On', 'avenue'),
					'' => esc_html__('Default', 'avenue'),
					'0' => esc_html__('Off', 'avenue'),
				),
				'default' => '',
			),

			array(
				'id' => 'single_post--title_wrapper--featured_image_on_bg',
				'type' => 'switch',
				'title' => esc_html__('Featured image as title wrapper background', 'avenue'),
				'default' => 0,
			),

			array(
				'id' => 'single_post--title_wrapper_styles--align',
				'type' => 'button_set',
				'title' => esc_html__('Text align', 'avenue'),
				'options' => array(
					'' => esc_html__('Default', 'avenue'),
					'left' => esc_html__('Left', 'avenue'),
					'center' => esc_html__('Center', 'avenue'),
					'right' => esc_html__('Right', 'avenue'),
				),
				'default' => '',
			),

			array(
				'id' => 'single_post--title_wrapper_styles--font_breadcrumb',
				'type' => 'typography',
				'title' => esc_html__('Breadcrumb typography', 'avenue'),
				'google' => false,
				'font-family' => false,
				'font-style' => false,
				'font-weight' => false,
				'font-size' => false,
				'line-height' => false,
				'subsets' => true,
				'text-align' => false,
			),

			array(
				'id' => 'single_post--title_wrapper_styles--font_title',
				'type' => 'typography',
				'title' => esc_html__('Title typography', 'avenue'),
				'google' => false,
				'font-family' => false,
				'font-style' => false,
				'font-weight' => false,
				'font-size' => false,
				'line-height' => false,
				'subsets' => true,
				'text-align' => false,
			),

			array(
				'id' => 'single_post--title_wrapper_styles--font_desc',
				'type' => 'typography',
				'title' => esc_html__('Description typography', 'avenue'),
				'subtitle' => esc_html__('Typography to optional description used in pages.', 'avenue'),
				'google' => false,
				'font-family' => false,
				'font-style' => false,
				'font-weight' => false,
				'font-size' => false,
				'line-height' => false,
				'subsets' => true,
				'text-align' => false,
			),

			array(
				'id' => 'single_post--title_wrapper_styles--bg_overlay',
				'type' => 'color_rgba',
				'title' => esc_html__('Title wrapper background overlay', 'avenue'),
				'default' => array(
					'alpha' => 0,
				),
			),

		array(
			'id' => 'single_post--title_wrapper_section__end',
			'type' => 'section',
			'indent' => false,
		),
	)
) );

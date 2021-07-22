<?php
Redux::setSection( $opt_name, array(
	'id' => 'sec_posts',
	'title' => esc_html__('Blog', 'avenue'),
	'desc' => esc_html__('Change blog and archives templates.', 'avenue'),
	'icon' => 'el el-pencil',
	'fields' => array(
		array(
			'id' => 'posts--layout--sidebars',
			'type' => 'image_select',
			'title' => esc_html__( 'Sidebars in blog', 'avenue' ),
			'subtitle' => esc_html__( 'Select the layout to be used in blog.', 'avenue' ),
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
			'id' => 'posts--layout--content_width',
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
			'id' => 'posts--view',
			'type' => 'select',
			'title' => esc_html__('Posts view', 'avenue'),
			'subtitle' => esc_html__('Select the view to be used by posts.', 'avenue'),
			'options' => array(
				'standard' => 'Standard',
				'grid' => 'Grid',
				'metro' => 'Metro',
				'masonry' => 'Masonry',
				'boxed' => 'Boxed',
			),
			'default' => 'standard',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'posts--img',
			'type' => 'switch',
			'title' => esc_html__('Thumbnails', 'avenue'),
			'subtitle' => esc_html__('If on, thumbnails will be displayed in the blog.', 'avenue'),
			'default' => 1,
			'required' => array('posts--view', '!=', 'metro'),
		),

		array(
			'id' => 'posts--img_size',
			'type' => 'select',
			'title' => esc_html__('Thumbnails size', 'avenue'),
			'options' => get_image_size_names(),
			'default' => 'rectangle_medium__crop',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'posts--desc',
			'type' => 'textarea',
			'title' => esc_html__('Description', 'avenue'),
			'subtitle' => esc_html__('You can use a, strong, br, em and strong HTML tags. Use this field to display an optional text on title wrapper layout part.', 'avenue'),
			'validate' => 'html_custom',
			'allowed_html' => array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'target' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array()
			),
		),

		array(
			'id' => 'posts--nav',
			'type' => 'switch',
			'title' => esc_html__('Posts navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be displayed below posts.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'posts--header_section',
			'type' => 'section',
			'title' => esc_html__('Header settings at blog', 'avenue'),
			'indent' => true,
		),

			array(
				'id' => 'posts--header--color_scheme',
				'type' => 'select',
				'title' => esc_html__('Color scheme for header', 'avenue'),
				'options' => array(
					'light' => esc_html__('Light text', 'avenue'),
					'dark' => esc_html__('Dark text', 'avenue'),
				),
				'default' => '',
			),

		array(
			'id' => 'posts--header_section__end',
			'type' => 'section',
			'indent' => false,
		),

		array(
			'id' => 'posts--title_wrapper_section',
			'type' => 'section',
			'title' => esc_html__('Title wrapper settings at blog', 'avenue'),
			'indent' => true,
		),

			array(
				'id' => 'posts--title_wrapper',
				'type' => 'button_set',
				'title' => esc_html__('Enable this layout part?', 'avenue'),
				'subtitle' => esc_html__('If on, this layout part will be displayed.', 'avenue'),
				'options' => array(
					'1' => esc_html__('On', 'avenue'),
					'' => esc_html__('Default', 'avenue'),
					'0' => esc_html__('Off', 'avenue'),
				),
				'default' => '',
			),

			array(
				'id' => 'posts--title_wrapper_styles--font_breadcrumb',
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
				'id' => 'posts--title_wrapper_styles--font_title',
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
				'id' => 'posts--title_wrapper_styles--font_desc',
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
				'id' => 'posts--title_wrapper_styles--bg',
				'type' => 'background',
				'title' => esc_html__('Title wrapper background', 'avenue'),
				'subtitle' => esc_html__('Overwrite title wrapper at blog and archives. Background image will be replaced on background pattern if you chose pattern in the next option.', 'avenue'),
			),

			array(
				'id' => 'posts--title_wrapper_styles--bg_overlay',
				'type' => 'color_rgba',
				'title' => esc_html__('Title wrapper background overlay', 'avenue'),
				'default' => array(
					'alpha' => 0,
				),
			),

		array(
			'id' => 'posts--title_wrapper_section__end',
			'type' => 'section',
			'indent' => false,
		),

		array(
			'id' => 'posts--content_section',
			'type' => 'section',
			'title' => esc_html__('Content settings at blog', 'avenue'),
			'indent' => true,
		),

			array(
				'id'=>'posts--content--dynamic_area__before',
				'type' => 'select',
				'title' => esc_html__('Dynamic area before posts', 'avenue'),
				'subtitle' => esc_html__('Select the page which content will be loaded and displayed before posts.', 'avenue'),
				'data' => 'pages',
				'default' => '',
			),

			array(
				'id'=>'posts--content--dynamic_area__after',
				'type' => 'select',
				'title' => esc_html__('Dynamic area after posts', 'avenue'),
				'subtitle' => esc_html__('Select the page which content will be loaded and displayed after posts.', 'avenue'),
				'data' => 'pages',
				'default' => '',
			),

			array(
				'id' => 'posts--content_styles--padding',
				'type' => 'spacing',
				'mode' => 'padding',
				'title' => esc_html__('Content padding', 'avenue'),
				'right' => false,
				'left' => false,
				'units' => 'px',
			),

		array(
			'id' => 'posts--content_section__end',
			'type' => 'section',
			'indent' => false,
		),
	)
) );

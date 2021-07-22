<?php
Redux::setSection( $opt_name, array(
	'id' => 'sec_projects',
	'title' => esc_html__('Projects', 'avenue'),
	'desc' => esc_html__('Change projects templates.', 'avenue'),
	'icon' => 'el el-idea',
	'fields' => array(
		array(
			'id' => 'projects--title',
			'type' => 'text',
			'title' => esc_html__('Projects title', 'avenue'),
			'default' => 'Projects',
		),

		array(
			'id' => 'projects--layout--sidebars',
			'type' => 'image_select',
			'title' => esc_html__('Sidebars in projects', 'avenue'),
			'subtitle' => esc_html__('Select the layout to be used in projects.', 'avenue'),
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
			'id' => 'projects--layout--content_width',
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
			'id' => 'projects--categories_align',
			'type' => 'button_set',
			'title' => esc_html__('Categories filter align', 'avenue'),
			'options' => array(
				'left' => esc_html__('Left', 'avenue'),
				'center' => esc_html__('Center', 'avenue'),
				'right' => esc_html__('Right', 'avenue'),
			),
			'default' => 'center',
		),

		array(
			'id' => 'projects--columns',
			'type' => 'slider',
			'title' => esc_html__('Columns', 'avenue'),
			'subtitle' => esc_html__('Define the columns numbers to be used in the projects.', 'avenue'),
			'default' => '3',
			'min' => '1',
			'step' => '1',
			'max' => '4',
		),

		array(
			'id' => 'projects--closely',
			'type' => 'switch',
			'title' => esc_html__('Show projects closely?', 'avenue'),
			'subtitle' => esc_html__('If on, projects will be shown without margins.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'projects--img_size',
			'type' => 'select',
			'title' => esc_html__('Image size', 'avenue'),
			'options' => get_image_size_names(),
			'default' => 'rectangle_medium__crop',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'projects--font_size',
			'type' => 'button_set',
			'title' => esc_html__('Font size', 'avenue'),
			'options' => array(
				'medium' => esc_html__('Medium', 'avenue'),
				'large' => esc_html__('Large', 'avenue'),
			),
			'default' => 'medium',
		),

		array(
			'id' => 'projects--bg_overlay',
			'type' => 'color_rgba',
			'title' => esc_html__('Color to overlay image on hover', 'avenue'),
			'default' => array(
				'alpha' => 0,
			),
		),

		array(
			'id' => 'projects--align',
			'type' => 'button_set',
			'title' => esc_html__('Title align', 'avenue'),
			'options' => array(
				'left' => esc_html__('Left', 'avenue'),
				'center' => esc_html__('Center', 'avenue'),
				'right' => esc_html__('Right', 'avenue'),
			),
			'default' => 'center',
		),

		array(
			'id' => 'projects--animation',
			'type' => 'select',
			'title' => esc_html__('Animation on hover', 'avenue'),
			'options' => array(
				'1' => esc_html__('Simple', 'avenue'),
				'2' => esc_html__('Simple (reverse)', 'avenue'),
				'3' => esc_html__('Blur', 'avenue'),
				'4' => esc_html__('Colorful', 'avenue'),
				'5' => esc_html__('Bordered', 'avenue'),
				'6' => esc_html__('Slice', 'avenue'),
				'7' => esc_html__('Grayscale', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'projects--nav',
			'type' => 'switch',
			'title' => esc_html__('Projects navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be displayed below projects.', 'avenue'),
			'default' => 1,
		),
	)
) );
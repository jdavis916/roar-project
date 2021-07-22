<?php
$boxSections[] = array(
	'title' => esc_html__('Layout', 'avenue'),
	'desc' => esc_html__('Change the main theme\'s layout and configure it.', 'avenue'),
	'fields' => array(
		array(
			'id' => 'local_general_styles--accent',
			'type' => 'color',
			'title' => esc_html__('Accent color', 'avenue'),
			'subtitle' => esc_html__('Pick an accent color to overwrite the default from the theme. Usually used for links and buttons.', 'avenue'),
			'transparent' => false,
			'validate' => 'color',
		),

		array(
			'id' => 'local_layout--boxed',
			'type' => 'select',
			'title' => esc_html__('Normal or boxed', 'avenue'),
			'options' => array(
				'normal' => esc_html__('Normal', 'avenue'),
				'boxed' => esc_html__('Boxed', 'avenue'),
				'boxed_laterals' => esc_html__('Boxed only lateral margins', 'avenue'),
				'bordered' => esc_html__('Bordered', 'avenue'),
			),
			'default' => '',
		),

			array(
				'id' => 'local_layout--border',
				'type' => 'border',
				'title' => esc_html__('Layout border', 'avenue'),
				'subtitle' => esc_html__('Select a custom border to be applied in the viewport/window.', 'avenue'),
				'all' => false,
				'style' => false,
			),

		array(
			'id' => 'local_layout--sidebars',
			'type' => 'image_select',
			'title' => esc_html__( 'Sidebars', 'avenue' ),
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
			'id' => 'local_layout--header_width',
			'type' => 'select',
			'title' => esc_html__('Header container type', 'avenue'),
			'subtitle' => esc_html__('Define container configuration to be used, it can be normal, expanded or compact.', 'avenue'),
			'options' => array(
				'expanded' => esc_html__('Expanded', 'avenue'),
				'normal' => esc_html__('Normal', 'avenue'),
				'compact' => esc_html__('Compact', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_layout--content_width',
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
			'id' => 'local_layout--footer_width',
			'type' => 'select',
			'title' => esc_html__('Footer container type', 'avenue'),
			'subtitle' => esc_html__('Define container configuration to be used, it can be normal, expanded or compact.', 'avenue'),
			'options' => array(
				'expanded' => esc_html__('Expanded', 'avenue'),
				'normal' => esc_html__('Normal', 'avenue'),
				'compact' => esc_html__('Compact', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_general_styles--bg',
			'type' => 'background',
			'title' => esc_html__('Body background', 'avenue'),
			'subtitle' => esc_html__('Body background with image, color and other options. Usually visible only when using boxed layout. Background image will be replaced on background pattern if you chose pattern in the next option.', 'avenue'),
		),
	),
);
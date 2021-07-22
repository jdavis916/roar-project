<?php
Redux::setSection( $opt_name, array(
	'id' => 'sec_layout',
	'title' => esc_html__('Layout', 'avenue'),
	'icon' => 'el el-website',
	'fields' => array(
		array(
			'id' => 'layout--boxed',
			'type' => 'select',
			'title' => esc_html__('Normal or boxed', 'avenue'),
			'desc' => esc_html__('See that this configuration is valid to the whole website, but you can overwrite it locally in a page, for example.', 'avenue'),
			'options' => array(
				'normal' => esc_html__('Normal', 'avenue'),
				'boxed' => esc_html__('Boxed', 'avenue'),
				'boxed_laterals' => esc_html__('Boxed only lateral margins', 'avenue'),
				'bordered' => esc_html__('Bordered', 'avenue'),
			),
			'default' => 'normal',
			'validate' => 'not_empty',
		),

			array(
				'id' => 'layout--border',
				'type' => 'border',
				'title' => esc_html__('Layout border', 'avenue'),
				'subtitle' => esc_html__('Select a custom border to be applied in the viewport/window.', 'avenue'),
				'all' => false,
				'style' => false,
				'required' => array('layout--boxed', '=', 'bordered'),
			),

		array(
			'id' => 'layout--sidebars',
			'type' => 'image_select',
			'title' => esc_html__( 'Sidebars', 'avenue' ),
			'desc' => esc_html__('See that this layout is valid to the whole website, but you can overwrite it locally in a page, for example.', 'avenue'),
			'options' => array(
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
			'default' => 'without',
		),

		array(
			'id' => 'layout--header_width',
			'type' => 'select',
			'title' => esc_html__('Header container type', 'avenue'),
			'subtitle' => esc_html__('Define container configuration to be used, it can be normal, expanded or compact.', 'avenue'),
			'options' => array(
				'expanded' => esc_html__('Expanded', 'avenue'),
				'normal' => esc_html__('Normal', 'avenue'),
				'compact' => esc_html__('Compact', 'avenue'),
			),
			'default' => 'normal',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'layout--content_width',
			'type' => 'select',
			'title' => esc_html__('Content container type', 'avenue'),
			'subtitle' => esc_html__('Define container configuration to be used, it can be normal, expanded or compact.', 'avenue'),
			'options' => array(
				'expanded' => esc_html__('Expanded', 'avenue'),
				'normal' => esc_html__('Normal', 'avenue'),
				'compact' => esc_html__('Compact', 'avenue'),
			),
			'default' => 'normal',
			'validate' => 'not_empty',
		),

		array(
			'id' => 'layout--footer_width',
			'type' => 'select',
			'title' => esc_html__('Footer container type', 'avenue'),
			'subtitle' => esc_html__('Define container configuration to be used, it can be normal, expanded or compact.', 'avenue'),
			'options' => array(
				'expanded' => esc_html__('Expanded', 'avenue'),
				'normal' => esc_html__('Normal', 'avenue'),
				'compact' => esc_html__('Compact', 'avenue'),
			),
			'default' => 'normal',
			'validate' => 'not_empty',
		),
	)
) );
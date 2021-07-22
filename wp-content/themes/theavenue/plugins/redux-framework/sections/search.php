<?php
Redux::setSection( $opt_name, array(
	'id' => 'sec_search',
	'title' => esc_html__('Search', 'avenue'),
	'desc' => esc_html__('Change search results template and configurations.', 'avenue'),
	'icon' => 'el el-search',
	'fields' => array(
		array(
			'id' => 'search--post_type',
			'type' => 'button_set',
			'title' => esc_html__('Search in post types', 'avenue'),
			'options' => array(
				'all' => esc_html__('All', 'avenue'),
				'post' => esc_html__('Only in posts', 'avenue'),
				'product' => esc_html__('Only in products', 'avenue'),
				'project' => esc_html__('Only in projects', 'avenue'),
			),
			'default' => 'all',
		),

		array(
			'id' => 'search--layout--sidebars',
			'type' => 'image_select',
			'title' => esc_html__( 'Sidebars in search results', 'avenue' ),
			'subtitle' => esc_html__( 'Select the layout to be used in search results.', 'avenue' ),
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
				),
				'both' => array(
					'alt' => 'both sidebars',
					'img' => get_template_directory_uri() . '/images/sidebars/3cm.png'
				),
				'both_left' => array(
					'alt' => 'both sidebars at left',
					'img' => get_template_directory_uri() . '/images/sidebars/3cl.png'
				),
				'both_right' => array(
					'alt' => 'both sidebars at right',
					'img' => get_template_directory_uri() . '/images/sidebars/3cr.png'
				)
			),
			'default' => '',
		),

		array(
			'id' => 'search--layout--content_width',
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
			'id' => 'search--columns',
			'type' => 'slider',
			'title' => esc_html__('Columns', 'avenue'),
			'subtitle' => esc_html__('Define columns number at shop.', 'avenue'),
			'default' => '3',
			'min' => '1',
			'step' => '1',
			'max' => '4',
		),

		array(
			'id' => 'search--title_wrapper_section',
			'type' => 'section',
			'title' => esc_html__('Title wrapper settings at search results', 'avenue'),
			'indent' => true,
		),


			array(
				'id' => 'search--title_wrapper_styles--padding',
				'type' => 'spacing',
				'mode' => 'padding',
				'title' => esc_html__('Title wrapper padding', 'avenue'),
				'right' => false,
				'left' => false,
				'units' => 'px',
			),

			array(
				'id' => 'search--title_wrapper_styles--align',
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
			'id' => 'search--title_wrapper_section__end',
			'type' => 'section',
			'indent' => false,
		),
	)
) );
<?php
Redux::setSection( $opt_name, array(
	'id' => 'sec_single_project',
	'title' => esc_html__('Single project', 'avenue'),
	'desc' => esc_html__('Change single project templates.', 'avenue'),
	'icon' => 'el el-idea-alt',
	'fields' => array(
		array(
			'id' => 'single_project--layout--sidebars',
			'type' => 'image_select',
			'title' => esc_html__('Sidebars in single project', 'avenue'),
			'subtitle' => esc_html__('Select the layout to be used in  single project.', 'avenue'),
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
			'id' => 'single_project--layout--content_width',
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
			'id' => 'single_project--nav',
			'type' => 'switch',
			'title' => esc_html__('Single project navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be displayed below content.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'single_project--nav__fixed',
			'type' => 'switch',
			'title' => esc_html__('Fixed single project navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be fixed in the middle of browser window.', 'avenue'),
			'default' => 0,
			'required' => array('single_project--nav', '=', 1),
		),
	)
) );
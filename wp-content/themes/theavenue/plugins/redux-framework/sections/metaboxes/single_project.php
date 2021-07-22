<?php
$boxSections[] = array(
	'title' => esc_html__('Projects', 'avenue'),
	'desc' => esc_html__('Change projects templates and configurations.', 'avenue'),
	'fields' => array(
		array(
			'id' => 'local_single_project--double_width',
			'type' => 'switch',
			'title' => esc_html__('Double width on projects list', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'local_single_project--double_height',
			'type' => 'switch',
			'title' => esc_html__('Double height on projects list', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'local_single_project--nav',
			'type' => 'button_set',
			'title' => esc_html__('Single project navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be displayed below content.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_project--nav__fixed',
			'type' => 'button_set',
			'title' => esc_html__('Fixed single project navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be fixed in the middle of browser window.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),
	)
);
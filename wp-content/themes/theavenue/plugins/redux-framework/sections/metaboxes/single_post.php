<?php
$boxSections[] = array(
	'title' => esc_html__('Posts', 'avenue'),
	'desc' => esc_html__('Change posts templates and configurations.', 'avenue'),
	'fields' => array(
		array(
			'id' => 'local_single_post--double_width',
			'type' => 'switch',
			'title' => esc_html__('Double width on posts list', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'local_single_post--featured_image',
			'type' => 'button_set',
			'title' => esc_html__('Featured image', 'avenue'),
			'subtitle' => esc_html__('If on, featured image will be displayed at single post before content.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_post--categories',
			'type' => 'button_set',
			'title' => esc_html__('Categories', 'avenue'),
			'subtitle' => esc_html__('If on, categories will be displayed.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_post--author',
			'type' => 'button_set',
			'title' => esc_html__('Author', 'avenue'),
			'subtitle' => esc_html__('If on, the author will be displayed in title wrapper.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_post--share',
			'type' => 'button_set',
			'title' => esc_html__('Social share', 'avenue'),
			'subtitle' => esc_html__('If on, social share icons will be displayed in title wrapper.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_post--tags',
			'type' => 'button_set',
			'title' => esc_html__('Tags after content', 'avenue'),
			'subtitle' => esc_html__('If on, the tags will be displayed after post content.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_post--nav',
			'type' => 'button_set',
			'title' => esc_html__('Post navigation', 'avenue'),
			'subtitle' => esc_html__('If on, navigation will be displayed below content.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_post--nav__fixed',
			'type' => 'button_set',
			'title' => esc_html__('Fixed post navigation', 'avenue'),
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
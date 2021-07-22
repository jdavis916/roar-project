<?php
$boxSections[] = array(
	'title' => esc_html__('Bottom footer', 'avenue'),
	'desc' => esc_html__('Change the bottom footer section configuration.', 'avenue'),
	'fields' => array(
		array(
			'id' => 'local_bottom_footer',
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
	),
);
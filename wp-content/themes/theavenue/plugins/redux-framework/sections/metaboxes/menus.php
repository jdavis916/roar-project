<?php
$boxSections[] = array(
	'title' => esc_html__('Menus', 'avenue'),
	'desc' => esc_html__('Replace the menus to be displayed in the avaliable areas.', 'avenue'),
	'fields' => array(
		array(
			'id' => 'local_menu--top_header',
			'type' => 'select',
			'title' => esc_html__('Top header menu', 'avenue'),
			'desc' => esc_html__('Select a menu to overwrite the top header menu location.', 'avenue'),
			'data' => 'menus',
			'default' => '',
		),

		array(
			'id' => 'local_menu--main',
			'type' => 'select',
			'title' => esc_html__('Main menu', 'avenue'),
			'desc' => esc_html__('Select a menu to overwrite the header menu location.', 'avenue'),
			'data' => 'menus',
			'default' => '',
		),

		array(
			'id' => 'local_menu--additional',
			'type' => 'select',
			'title' => esc_html__('Additional header menu', 'avenue'),
			'desc' => esc_html__('Select a menu to overwrite the additional header menu location.', 'avenue'),
			'data' => 'menus',
			'default' => '',
		),

		array(
			'id' => 'local_menu--popup',
			'type' => 'select',
			'title' => esc_html__('Popup/Mobile menu', 'avenue'),
			'desc' => esc_html__('Select a menu to overwrite the popup menu location.', 'avenue'),
			'data' => 'menus',
			'default' => '',
		),

		array(
			'id' => 'local_menu--bottom_footer',
			'type' => 'select',
			'title' => esc_html__('Bottom footer menu', 'avenue'),
			'desc' => esc_html__('Select a menu to overwrite the bottom footer menu location.', 'avenue'),
			'data' => 'menus',
			'default' => '',
		),
	),
);
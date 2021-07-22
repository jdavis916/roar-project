<?php
$boxSections[] = array(
	'title' => esc_html__('Single product', 'avenue'),
	'desc' => esc_html__('Change single product templates and configurations.', 'avenue'),
	'fields' => array(
		array(
			'id' => 'local_products--catalog_mode',
			'type' => 'button_set',
			'title' => esc_html__('Enable catalog mode?', 'avenue'),
			'subtitle' => esc_html__('If on, Add to Cart buttons will not be displayed to users.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_product--extra_tab',
			'type' => 'button_set',
			'title' => esc_html__('Enable extra tab?', 'avenue'),
			'subtitle' => esc_html__('If on, an additional global tab will be displayed in products tabs.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_product--share',
			'type' => 'button_set',
			'title' => esc_html__('Enable share?', 'avenue'),
			'subtitle' => esc_html__('If on, share icons below product details will be displayed.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),

		array(
			'id' => 'local_single_product--related_products',
			'type' => 'button_set',
			'title' => esc_html__('Enable related products?', 'avenue'),
			'subtitle' => esc_html__('If on, related products will be displayed.', 'avenue'),
			'options' => array(
				'1' => esc_html__('On', 'avenue'),
				'' => esc_html__('Default', 'avenue'),
				'0' => esc_html__('Off', 'avenue'),
			),
			'default' => '',
		),
	)
);

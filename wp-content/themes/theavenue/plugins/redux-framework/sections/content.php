<?php
Redux::setSection( $opt_name, array(
	'id' => 'main_sec_content',
	'title' => esc_html__('Content', 'avenue'),
	'icon' => 'el el-align-left',
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_content',
	'title' => esc_html__('Content settings', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id'=>'content--dynamic_area__before',
			'type' => 'select',
			'title' => esc_html__('Dynamic area before content', 'avenue'),
			'subtitle' => esc_html__('Select the page which content will be loaded and displayed before content.', 'avenue'),
			'data' => 'pages',
			'default' => '',
		),

		array(
			'id'=>'content--dynamic_area__after',
			'type' => 'select',
			'title' => esc_html__('Dynamic area after content', 'avenue'),
			'subtitle' => esc_html__('Select the page which content will be loaded and displayed after content.', 'avenue'),
			'data' => 'pages',
			'default' => '',
		),
	)
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_content_styles',
	'title' => esc_html__('Content styles', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'content_styles--border',
			'type' => 'border',
			'title' => esc_html__('Content border', 'avenue'),
			'subtitle' => esc_html__('Select a custom border to be applied in the content.', 'avenue'),
			'all' => false,
			'left' => false,
			'right' => false,
		),

		array(
			'id' => 'content_styles--padding',
			'type' => 'spacing',
			'mode' => 'padding',
			'title' => esc_html__('Content padding', 'avenue'),
			'right' => false,
			'left' => false,
			'units' => 'px',
		),
	)
) );
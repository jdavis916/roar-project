<?php
Redux::setSection( $opt_name, array(
	'id' => 'main_sec_bottom_footer',
	'title' => esc_html__('Bottom footer', 'avenue'),
	'icon' => 'el el-chevron-down',
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_bottom_footer',
	'title' => esc_html__('Bottom footer settings', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'bottom_footer',
			'type' => 'switch',
			'title' => esc_html__('Enable this layout part?', 'avenue'),
			'subtitle' => esc_html__('If on, this layout part will be displayed.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'bottom_footer--left_cols_sm',
			'type' => 'slider',
			'title' => esc_html__('Left area columns', 'avenue'),
			'subtitle' => esc_html__('Define columns number of bottom footer left area.', 'avenue'),
			'default' => '6',
			'min' => '0',
			'step' => '1',
			'max' => '12',
		),

		array(
			'id' => 'bottom_footer--right_cols_sm',
			'type' => 'slider',
			'title' => esc_html__('Right area columns', 'avenue'),
			'subtitle' => esc_html__('Define columns number of bottom footer right area.', 'avenue'),
			'default' => '6',
			'min' => '0',
			'step' => '1',
			'max' => '12',
		),

		array(
			'id' => 'bottom_footer--menu',
			'type' => 'switch',
			'title' => esc_html__('Menu', 'avenue'),
			'subtitle' => esc_html__('If on, menu will be displayed.', 'avenue'),
			'default' => 0,
		),

			array(
				'id' => 'bottom_footer--menu_left',
				'type' => 'switch',
				'title' => esc_html__('Menu at left area', 'avenue'),
				'subtitle' => esc_html__('If on, menu will display at left area of bottom footer.', 'avenue'),
				'default' => 0,
				'required' => array('bottom_footer--menu', '=', 1),
			),

		array(
			'id' => 'bottom_footer--text',
			'type' => 'switch',
			'title' => esc_html__('Text module', 'avenue'),
			'subtitle' => esc_html__('If on, a rich text module will be displayed.', 'avenue'),
			'default' => 1,
		),

			array(
				'id' => 'bottom_footer--text_content',
				'type' => 'editor',
				'title' => esc_html__('Text module content', 'avenue'),
				'subtitle' => esc_html__('Place any text to be displayed in bottom footer.', 'avenue'),
				'default' => 'All rights reserved. Powered by <a href="http://avenue.themes.tvda.pw/">Avenue Theme</a>.',
				'required' => array('bottom_footer--text', '=', 1),
			),

		array(
			'id' => 'bottom_footer--social',
			'type' => 'switch',
			'title' => esc_html__('Social module', 'avenue'),
			'subtitle' => esc_html__('If on, a social icon module will be displayed.', 'avenue'),
			'default' => 0,
		),

			array(
				'id' => 'bottom_footer--social_links',
				'type' => 'sortable',
				'mode' => 'checkbox',
				'title' => esc_html__('Social links', 'avenue'),
				'subtitle' => esc_html__('Enable social links to be displayed.', 'avenue'),
				'options' => get_social_links(),
				'required' => array('bottom_footer--social', '=', 1),
			),

		array(
			'id' => 'bottom_footer--wpml_modules_section',
			'type' => 'section',
			'title' => esc_html__('WPML modules', 'avenue'),
			'indent' => true,
		),

			array(
				'id' => 'bottom_footer--wpml_lang',
				'type' => 'switch',
				'title' => esc_html__('WPML language flags', 'avenue'),
				'subtitle' => esc_html__('If on, the avaliable languages flags will be displayed. Only works with WPML activated.', 'avenue'),
				'default' => 0,
			),

			array(
				'id' => 'bottom_footer--wpml_currency',
				'type' => 'switch',
				'title' => esc_html__('WPML shop currencies', 'avenue'),
				'subtitle' => esc_html__('If on, the avaliable currencies flags will be displayed. Only works with WPML + WooCommerce Multilingual activated.', 'avenue'),
				'default' => 0,
			),

		array(
			'id' => 'bottom_footer--wpml_modules_section__end',
			'type' => 'section',
			'indent' => false,
		),
	)
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_bottom_footer_styles',
	'title' => esc_html__('Bottom footer styles', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'bottom_footer_styles--first_align',
			'type' => 'button_set',
			'title' => esc_html__('First area align', 'avenue'),
			'options' => array(
				'left' => esc_html__('Left', 'avenue'),
				'center' => esc_html__('Center', 'avenue'),
				'right' => esc_html__('Right', 'avenue'),
			),
			'default' => 'left',
		),

		array(
			'id' => 'bottom_footer_styles--second_align',
			'type' => 'button_set',
			'title' => esc_html__('Second area align', 'avenue'),
			'options' => array(
				'left' => esc_html__('Left', 'avenue'),
				'center' => esc_html__('Center', 'avenue'),
				'right' => esc_html__('Right', 'avenue'),
			),
			'default' => 'right',
		),

		array(
			'id' => 'bottom_footer_styles--border',
			'type' => 'border',
			'title' => esc_html__('Bottom footer border', 'avenue'),
			'subtitle' => esc_html__('Select a custom border to be applied in the bottom footer.', 'avenue'),
			'all' => false,
			'left' => false,
			'right' => false,
		),

		array(
			'id' => 'bottom_footer_styles--padding',
			'type' => 'spacing',
			'mode' => 'padding',
			'title' => esc_html__('Bottom footer padding', 'avenue'),
			'right' => false,
			'left' => false,
			'units' => 'px',
		),

		array(
			'id' => 'bottom_footer_styles--bg',
			'type' => 'background',
			'title' => esc_html__('Bottom footer background', 'avenue'),
			'subtitle' => esc_html__('Background image will be replaced on background pattern if you chose pattern in the next option.', 'avenue'),
		),

		array(
			'id' => 'bottom_footer_styles--patterns',
			'type' => 'select_image',
			'title' => esc_html__('Bottom footer background pattern', 'avenue'),
			'subtitle' => esc_html__('Select a predefined background pattern. It will replace background image in previous option.', 'avenue'),
			'options' => $background_patterns,
			'default' => '',
		),

		array(
			'id' => 'bottom_footer_styles--font',
			'type' => 'typography',
			'title' => esc_html__('Bottom footer typography', 'avenue'),
			'google' => true,
			'font-backup' => true,
			'letter-spacing' => true,
			'text-transform' => true,
			'subsets' => true,
			'text-align' => false,
			'all_styles' => true,
		),

		array(
			'id' => 'bottom_footer_styles--font__custom_family',
			'type' => 'text',
			'title' => esc_html__('Bottom footer typography: custom font family', 'avenue'),
			'subtitle' => esc_html__('You can use here your Typekit fonts.', 'avenue'),
			'default' => '',
			'placeholder' => '"proxima-nova", Arial, Helvetica, sans-serif',
			'validate' => 'no_html',
		),
	)
) );
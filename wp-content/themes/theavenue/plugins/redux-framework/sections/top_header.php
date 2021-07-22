<?php
Redux::setSection( $opt_name, array(
	'id' => 'main_sec_top_header',
	'title' => esc_html__('Top header', 'avenue'),
	'icon' => 'el el-chevron-up',
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_top_header',
	'title' => esc_html__('Top header settings', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'top_header',
			'type' => 'switch',
			'title' => esc_html__('Enable this layout part?', 'avenue'),
			'subtitle' => esc_html__('If on, this layout part will be displayed.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'top_header--left_cols_sm',
			'type' => 'slider',
			'title' => esc_html__('Left area columns', 'avenue'),
			'subtitle' => esc_html__('Define columns number of top header left area.', 'avenue'),
			'default' => '4',
			'min' => '0',
			'step' => '1',
			'max' => '12',
		),

		array(
			'id' => 'top_header--right_cols_sm',
			'type' => 'slider',
			'title' => esc_html__('Right area columns', 'avenue'),
			'subtitle' => esc_html__('Define columns number of top header right area.', 'avenue'),
			'default' => '8',
			'min' => '0',
			'step' => '1',
			'max' => '12',
		),

		array(
			'id' => 'top_header--menu',
			'type' => 'switch',
			'title' => esc_html__('Menu', 'avenue'),
			'subtitle' => esc_html__('If on, menu will be displayed.', 'avenue'),
			'default' => 0,
		),

			array(
				'id' => 'top_header--menu_left',
				'type' => 'switch',
				'title' => esc_html__('Menu at left area', 'avenue'),
				'subtitle' => esc_html__('If on, menu will display at left area of top header.', 'avenue'),
				'default' => 0,
				'required' => array('top_header--menu', '=', 1),
			),

		array(
			'id' => 'top_header--login_ajax',
			'type' => 'switch',
			'title' => esc_html__('Login With Ajax module', 'avenue'),
			'subtitle' => esc_html__('If on, a Login With Ajax module will be displayed. Requires Login With Ajax plugin activated.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'top_header--wishlist',
			'type' => 'switch',
			'title' => esc_html__('Wishlist module', 'avenue'),
			'subtitle' => esc_html__('If on, a wishlist link will be displayed. Requires YITH Woocommerce Wishlist plugin activated.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'top_header--woo_cart',
			'type' => 'switch',
			'title' => esc_html__('Minicart', 'avenue'),
			'subtitle' => esc_html__('If on, a WooCommerce minicart will be displayed. Requires WooCommerce plugin activated.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'top_header--search',
			'type' => 'switch',
			'title' => esc_html__('Search module', 'avenue'),
			'subtitle' => esc_html__('If on, a search module will be displayed.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'top_header--text',
			'type' => 'switch',
			'title' => esc_html__('Text module', 'avenue'),
			'subtitle' => esc_html__('If on, a rich text module will be displayed.', 'avenue'),
			'default' => 0,
		),

			array(
				'id' => 'top_header--text_content',
				'type' => 'editor',
				'title' => esc_html__('Text module content', 'avenue'),
				'subtitle' => esc_html__('Place any text to be displayed in top header.', 'avenue'),
				'default' => '9854-888-021 | New York, NY',
				'required' => array('top_header--text', '=', 1),
			),

		array(
			'id' => 'top_header--social',
			'type' => 'switch',
			'title' => esc_html__('Social module', 'avenue'),
			'subtitle' => esc_html__('If on, a social icon module will be displayed.', 'avenue'),
			'default' => 0,
		),

			array(
				'id' => 'top_header--social_links',
				'type' => 'sortable',
				'mode' => 'checkbox',
				'title' => esc_html__('Social links', 'avenue'),
				'subtitle' => esc_html__('Enable social links to be displayed.', 'avenue'),
				'options' => get_social_links(),
				'required' => array('top_header--social', '=', 1),
			),

		array(
			'id' => 'top_header--wpml_modules_section',
			'type' => 'section',
			'title' => esc_html__('WPML modules', 'avenue'),
			'indent' => true,
		),

			array(
				'id' => 'top_header--wpml_lang',
				'type' => 'switch',
				'title' => esc_html__('WPML language flags', 'avenue'),
				'subtitle' => esc_html__('If on, the avaliable languages flags will be displayed. Only works with WPML activated.', 'avenue'),
				'default' => 0,
			),

			array(
				'id' => 'top_header--wpml_currency',
				'type' => 'switch',
				'title' => esc_html__('WPML shop currencies', 'avenue'),
				'subtitle' => esc_html__('If on, the avaliable currencies flags will be displayed. Only works with WPML + WooCommerce Multilingual activated.', 'avenue'),
				'default' => 0,
			),

		array(
			'id' => 'top_header--wpml_modules_section__end',
			'type' => 'section',
			'indent' => false,
		),
	)
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_top_header_styles',
	'title' => esc_html__('Top header styles', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'top_header_styles--border',
			'type' => 'border',
			'title' => esc_html__('Top header border', 'avenue'),
			'subtitle' => esc_html__('Select a custom border to be applied in the top header.', 'avenue'),
			'all' => false,
			'left' => false,
			'right' => false,
		),

		array(
			'id' => 'top_header_styles--padding',
			'type' => 'spacing',
			'mode' => 'padding',
			'title' => esc_html__('Top header padding', 'avenue'),
			'left' => false,
			'right' => false,
			'units' => 'px',
		),

		array(
			'id' => 'top_header_styles--bg',
			'type' => 'background',
			'title' => esc_html__('Top header background', 'avenue'),
			'subtitle' => esc_html__('Background image will be replaced on background pattern if you chose pattern in the next option.', 'avenue'),
		),

		array(
			'id' => 'top_header_styles--font',
			'type' => 'typography',
			'title' => esc_html__('Top header typography', 'avenue'),
			'google' => true,
			'font-backup' => true,
			'letter-spacing' => true,
			'text-transform' => true,
			'subsets' => true,
			'text-align' => false,
			'all_styles' => true,
		),

		array(
			'id' => 'top_header_styles--font__custom_family',
			'type' => 'text',
			'title' => esc_html__('Top header typography: custom font family', 'avenue'),
			'subtitle' => esc_html__('You can use here your Typekit fonts.', 'avenue'),
			'default' => '',
			'placeholder' => '"proxima-nova", Arial, Helvetica, sans-serif',
			'validate' => 'no_html',
		),
	)
) );
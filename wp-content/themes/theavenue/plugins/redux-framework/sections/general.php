<?php
Redux::setSection( $opt_name, array(
	'id' => 'main_sec_general',
	'title' => esc_html__('General', 'avenue'),
	'icon' => 'el el-dashboard',
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_general',
	'title' => esc_html__('General settings', 'avenue'),
	'desc' => esc_html__('Configure easily the basic theme\'s settings.', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'general--page_comments',
			'type' => 'switch',
			'title' => esc_html__('Comments in pages', 'avenue'),
			'subtitle' => esc_html__('If on, the comment form will be avaliable in all pages.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'general--responsiveness',
			'type' => 'switch',
			'title' => esc_html__('Responsive layout', 'avenue'),
			'subtitle' => esc_html__('If on, the website will adapt in smaller devices like tablets or smartphones.', 'avenue'),
			'default' => 1,
		),

		array(
			'id' => 'general--wp_version',
			'type' => 'switch',
			'title' => esc_html__('Meta tags in head about wordpress version', 'avenue'),
			'subtitle' => esc_html__('If on, meta tags will be show in all pages.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'general--wlwmanifest',
			'type' => 'switch',
			'title' => esc_html__('WLW manifest link in head', 'avenue'),
			'subtitle' => esc_html__('WLW manifest link is the resource file needed to enable tagging support for Windows Live Writer.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'general--rsd',
			'type' => 'switch',
			'title' => esc_html__('RSD link in head', 'avenue'),
			'subtitle' => esc_html__('RSD link is used by blog clients, enable if you use blog clients for wordpress.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'general--preloader',
			'type' => 'switch',
			'title' => esc_html__('Loader effect', 'avenue'),
			'subtitle' => esc_html__('If on, a loader will appear before loading the page.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'general--go_to_top',
			'type' => 'switch',
			'title' => esc_html__('"Go to top" button', 'avenue'),
			'subtitle' => esc_html__('If on, "Go to top" button will be visible at bottom right corner of viewport/window.', 'avenue'),
			'default' => 0,
		),

		array(
			'id' => 'general--typekit_kit_id',
			'type' => 'text',
			'title' => esc_html__('Typekit Kit ID', 'avenue'),
			'subtitle' => esc_html__('Define Kit ID, if you want use Typekit fonts.', 'avenue'),
			'default' => '',
			'validate' => 'no_html',
		),
	)
) );

Redux::setSection( $opt_name, array(
	'id' => 'sec_general_styles',
	'title' => esc_html__('General styles', 'avenue'),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'general_styles--accent',
			'type' => 'color',
			'title' => esc_html__('Accent color', 'avenue'),
			'subtitle' => esc_html__('Pick an accent color to overwrite the default from the theme. Usually used for links and buttons.', 'avenue'),
			'transparent' => false,
			'validate' => 'color',
		),

		array(
			'id' => 'general_styles--font',
			'type' => 'typography',
			'title' => esc_html__('Base font', 'avenue'),
			'subtitle' => esc_html__('Font used in the content in general, usually overwrite by local layout fonts, but used in paragraphs, lists and others.', 'avenue'),
			'google' => true,
			'font-backup' => true,
			'letter-spacing' => true,
			'text-transform' => true,
			'subsets' => true,
			'text-align' => false,
			'all_styles' => true,
		),

		array(
			'id' => 'general_styles--font__custom_family',
			'type' => 'text',
			'title' => esc_html__('Base font: custom font family', 'avenue'),
			'subtitle' => esc_html__('You can use here your Typekit fonts.', 'avenue'),
			'default' => '',
			'placeholder' => '"proxima-nova", Arial, Helvetica, sans-serif',
			'validate' => 'no_html',
		),

		array(
			'id' => 'general_styles--font_second',
			'type' => 'typography',
			'title' => esc_html__('Second font', 'avenue'),
			'subtitle' => esc_html__('For menus, inputs, buttons, titles and heading elements.', 'avenue'),
			'google' => true,
			'font-backup' => true,
			'letter-spacing' => true,
			'text-transform' => true,
			'subsets' => true,
			'text-align' => false,
			'all_styles' => true,
		),

		array(
			'id' => 'general_styles--font_second__custom_family',
			'type' => 'text',
			'title' => esc_html__('Second font: custom font family', 'avenue'),
			'subtitle' => esc_html__('You can use here your Typekit fonts.', 'avenue'),
			'default' => '',
			'placeholder' => '"proxima-nova", Arial, Helvetica, sans-serif',
			'validate' => 'no_html',
		),

		array(
			'id' => 'general_styles--bg',
			'type' => 'background',
			'title' => esc_html__('Body background', 'avenue'),
			'subtitle' => esc_html__('Body background with image, color and other options. Usually visible only when using boxed layout. Background image will be replaced on background pattern if you chose pattern in the next option.', 'avenue'),
		),

		array(
			'id' => 'general_styles--patterns',
			'type' => 'select_image',
			'title' => esc_html__('Body background pattern', 'avenue'),
			'subtitle' => esc_html__('Select a predefined background pattern. It will replace background image in previous option.', 'avenue'),
			'options' => $background_patterns,
			'default' => '',
		),
	)
) );
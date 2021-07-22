<?php
$boxSections[] = array(
	'title' => esc_html__('Custom CSS/JS', 'avenue'),
	'desc' => 'Easily add custom CSS and JS to your page.',
	'fields' => array(
		array(
			'id' => 'local_custom--css',
			'type' => 'ace_editor',
			'title' => esc_html__('CSS code', 'avenue'),
			'subtitle' => esc_html__('Insert your custom CSS code here. It will be displayed only in this page.', 'avenue'),
			'mode' => 'css',
			'theme' => 'monokai',
		),

		array(
			'id' => 'local_custom--js',
			'type' => 'ace_editor',
			'title' => esc_html__('JS code', 'avenue'),
			'subtitle' => esc_html__('Insert your custom JS code here, e.g. Google Analytics code or whatever you want. It will be displayed only in this page.', 'avenue'),
			'mode' => 'javascript',
			'theme' => 'monokai',
		),

		array(
			'id' => 'local_custom--head_html',
			'type' => 'ace_editor',
			'title' => esc_html__('Head link tags', 'avenue'),
			'subtitle' => esc_html__('Insert your custom tags to be displayed in the head, e.g. Google Fonts <link> tags and others.', 'avenue'),
			'mode' => 'html',
			'theme' => 'monokai',
		),
		array(
			'id' => 'local_custom--footer_html',
			'type' => 'ace_editor',
			'title' => esc_html__('HTML code', 'avenue'),
			'subtitle' => esc_html__('Insert your custom HTML to be append after footer.', 'avenue'),
			'mode' => 'html',
			'theme' => 'monokai',
		),
	),
);

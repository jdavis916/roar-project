<?php
/**
 * avenue functions and definitions
 *
 * @package avenue
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
	$content_width = 1170; /* pixels */
}


if (!function_exists('avenue_setup')) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function avenue_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on avenue, use a find and replace
		 * to change 'avenue' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'avenue', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'top_header' => esc_html__( 'Top header menu', 'avenue' ),
			'main' => esc_html__( 'Main menu', 'avenue' ),
			'additional' => esc_html__( 'Additional header menu', 'avenue' ),
			'popup' => esc_html__( 'Popup/Mobile menu', 'avenue' ),
			'bottom_footer' => esc_html__( 'Bottom footer menu', 'avenue' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio'
		) );

		// Declare WooCommerce support
		add_theme_support( 'woocommerce' );
	}
} // avenue_setup
add_action('after_setup_theme', 'avenue_setup');


/**
 * Register image sizes.
 */
add_action('after_switch_theme', 'avenue_activation_theme', 10 , 2);
function avenue_activation_theme($oldname, $oldtheme=false) {
	update_option('medium_size_w',510);
	update_option('medium_size_h', 510);

	update_option('large_size_w', 900);
	update_option('large_size_h', 900);

	update_option('shop_thumbnail_image_size', array('width'=>90, 'height'=>115, 'crop' => false));
	update_option('shop_catalog_image_size', array('width'=>400, 'height'=>510, 'crop' => true));
	update_option('shop_single_image_size', array('width'=>580, 'height'=>740, 'crop' => false));
	update_option('woocommerce_enable_lightbox', false);
}

add_image_size('square_medium__crop', 510, 510, true);
add_image_size('square_large__crop', 900, 900, true);
add_image_size('rectangle_medium__crop', 510, 340, true);
add_image_size('rectangle_large__crop', 900, 600, true);

add_filter('image_size_names_choose', 'avenue_custom_img_sizes');
function avenue_custom_img_sizes($sizes) {
	return array_merge($sizes, array(
		'square_medium__crop' => esc_html__('Square Medium With Crop', 'avenue'),
		'square_large__crop' => esc_html__('Square Large With Crop', 'avenue'),
		'rectangle_medium__crop' => esc_html__('Rectangle Medium With Crop', 'avenue'),
		'rectangle_large__crop' => esc_html__('Rectangle Large With Crop', 'avenue'),
		'shop_thumbnail' => esc_html__('Product Thumbnails', 'avenue'),
		'shop_catalog' => esc_html__('Catalog Images', 'avenue'),
		'shop_single' => esc_html__('Single Product Image', 'avenue'),
	));
}

function get_image_sizes($size = '') {
	global $_wp_additional_image_sizes;

	$sizes = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach($get_intermediate_image_sizes as $_size) {
		if (in_array($_size, array('thumbnail', 'medium', 'large'))) {
			$sizes[$_size] = array(
				'width'  => get_option($_size . '_size_w'),
				'height' => get_option($_size . '_size_h'),
				'crop'   => (bool) get_option($_size . '_crop'),
			);
		} elseif (isset($_wp_additional_image_sizes[$_size])) {
			$sizes[$_size] = array(
				'width'  => $_wp_additional_image_sizes[$_size]['width'],
				'height' => $_wp_additional_image_sizes[$_size]['height'],
				'crop'   => $_wp_additional_image_sizes[$_size]['crop']
			);
		}
	}

	// Get only 1 size if found
	if ($size) {
		if (isset($sizes[$size])) {
			return $sizes[$size];
		} else {
			return false;
		}
	}

	return $sizes;
}

function get_image_size_names() {
	$size_names = array();
	$sizes = get_image_sizes();
	$names = apply_filters( 'image_size_names_choose', array(
		'thumbnail' => esc_html__('Thumbnail', 'avenue'),
		'medium'    => esc_html__('Medium', 'avenue'),
		'large'     => esc_html__('Large', 'avenue'),
		'full'      => esc_html__('Full Size', 'avenue'),
	) );

	$size_names['full'] = $names['full'];

	foreach ($sizes as $id => $size) {
		$size_names[$id] = $names[$id] . ' ' . $size['width'] . '×' . $size['height'];
	}

	return $size_names;
}

function get_intermediate_size_image_src($file, $width, $height, $crop = false) {
	if ($width || $height) {
		$editor = wp_get_image_editor($file);

		if (is_wp_error($editor) || is_wp_error($editor->resize($width, $height, $crop)))
			return false;

		$resized_file = $editor->save();

		if (!is_wp_error($resized_file) && $resized_file) {
			$upload_dir = wp_upload_dir();
			return str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $resized_file['path']);
		}
	}
	return false;
}


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
add_action('widgets_init', 'avenue_widgets_init');
function avenue_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar left', 'avenue' ),
		'id'            => 'sidebar_left',
		'description'   => esc_html__( 'Widgets displayed at left side of content.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget_h">',
		'after_title'   => '</h5>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar right', 'avenue' ),
		'id'            => 'sidebar_right',
		'description'   => esc_html__( 'Widgets displayed at right side of content.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget_h">',
		'after_title'   => '</h5>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer #1 column', 'avenue' ),
		'id'            => 'footer_1',
		'description'   => esc_html__( 'Widgets displayed at footer.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget_h">',
		'after_title'   => '</h6>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer #2 column', 'avenue' ),
		'id'            => 'footer_2',
		'description'   => esc_html__( 'Widgets displayed at footer.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget_h">',
		'after_title'   => '</h6>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer #3 column', 'avenue' ),
		'id'            => 'footer_3',
		'description'   => esc_html__( 'Widgets displayed at footer.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget_h">',
		'after_title'   => '</h6>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer #4 column', 'avenue' ),
		'id'            => 'footer_4',
		'description'   => esc_html__( 'Widgets displayed at footer.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget_h">',
		'after_title'   => '</h6>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer #5 column', 'avenue' ),
		'id'            => 'footer_5',
		'description'   => esc_html__( 'Widgets displayed at footer.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget_h">',
		'after_title'   => '</h6>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer #6 column', 'avenue' ),
		'id'            => 'footer_6',
		'description'   => esc_html__( 'Widgets displayed at footer.', 'avenue' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget_h">',
		'after_title'   => '</h6>',
	) );
}


add_filter('media_view_settings', 'avenue_media_view_settings');
function avenue_media_view_settings($settings) {
	// Need for avenue_gallery_shortcode() below
	$settings['galleryDefaults']['columns'] = 1;
	$settings['galleryDefaults']['size'] = 'medium';
	$settings['galleryDefaults']['link'] = 'file';
	return $settings;
}

add_filter('post_gallery', 'avenue_gallery_shortcode', 10, 4);
function avenue_gallery_shortcode($output = '', $attr, $content = false, $tag = false) {
	$post = get_post();
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'columns'    => 1,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );

	if (!is_singular()) {
		$atts['size'] = get_theme_option('posts--img_size');
	}

	$id = intval($atts['id']);

	if (!empty($atts['include'])) {
		$_attachments = get_posts(array(
			'include' => $atts['include'],
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $atts['order'],
			'orderby' => $atts['orderby']
		));

		$attachments = array();
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif (!empty($atts['exclude'])) {
		$attachments = get_children(array(
			'post_parent' => $id,
			'exclude' => $atts['exclude'],
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $atts['order'],
			'orderby' => $atts['orderby']
		));
	} else {
		$attachments = get_children(array(
			'post_parent' => $id,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $atts['order'],
			'orderby' => $atts['orderby']
		));
	}

	if (empty($attachments)) {
		return '';
	}

	if (is_feed()) {
		$output = '\n';
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . '\n';
		}
		return $output;
	}

	$selector = "gallery-$content";

	$output .= "<div id='$selector' class='flexslider gallery'><ul class='slides'>";

	$i = 0;
	foreach ($attachments as $id => $attachment) {

		$attr = (trim($attachment->post_excerpt)) ? array("aria-describedby" => "$selector-$id") : '';

		if (!empty($atts['link']) && 'post' === $atts['link']) {

			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );

		} elseif (!empty($atts['link']) && 'none' === $atts['link']) {

			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );

		} else {

			$image_meta = wp_get_attachment_image_src( $id, 'full' );

			$image = wp_get_attachment_image( $id, $atts['size'], false, $attr );

			$image_output = "<a
				href='$image_meta[0]'
				data-img-width='$image_meta[1]'
				data-img-height='$image_meta[2]'
				data-img-index='$i'
				data-pswp-uid='$content'
				class='js-pswp-img-lk'
			>$image</a>";

		}

		$i++;

		$output .= '<li>';
		$output .= $image_output;
		$output .= '</li>';
	}

	$output .= '</ul></div>';

	$columns = intval($atts['columns']);

	$direction_nav = 'true';

	if ($i <= $columns) {
		$direction_nav = 'false';
	}

	$output .= "
		<script>
			(function($) {
				$(document).ready(function() {
					$('#{$selector}').flexslider({
						animation: 'slide',
						slideshow: false,
						animationLoop: false,
						directionNav: {$direction_nav},
						controlNav: false,
						itemWidth: 200,
						minItems: {$columns},
						maxItems: {$columns}
					});
				});
			})(jQuery);
		</script>
	";

	return $output;
}


function get_social_links() {
	// don't forget add brand colors
	return array(
		'link'          => '<i class=\'fa fa-lg fa-link\'></i> Custom Link',
		'envelope'      => '<i class=\'fa fa-lg fa-envelope\'></i> Mail',
		'facebook'      => '<i class=\'fa fa-lg fa-facebook\'></i> Facebook',
		'twitter'       => '<i class=\'fa fa-lg fa-twitter\'></i> Twitter',
		'instagram'     => '<i class=\'fa fa-lg fa-instagram\'></i> Instagram',
		'vk'            => '<i class=\'fa fa-lg fa-vk\'></i> VK',
		'pinterest'     => '<i class=\'fa fa-lg fa-pinterest\'></i> Pinterest',
		'linkedin'      => '<i class=\'fa fa-lg fa-linkedin\'></i> LinkedIn',
		'dribbble'      => '<i class=\'fa fa-lg fa-dribbble\'></i> Dribbble',
		'behance'       => '<i class=\'fa fa-lg fa-behance\'></i> Behance',
		'google-plus'   => '<i class=\'fa fa-lg fa-google-plus\'></i> Google+',
		'youtube'       => '<i class=\'fa fa-lg fa-youtube\'></i> YouTube',
		'vimeo-square'  => '<i class=\'fa fa-lg fa-vimeo-square\'></i> Vimeo',
		'flickr'        => '<i class=\'fa fa-lg fa-flickr\'></i> Flickr',
		'tumblr'        => '<i class=\'fa fa-lg fa-tumblr\'></i> Tumblr',
		'foursquare'    => '<i class=\'fa fa-lg fa-foursquare\'></i> FourSquare',
		'wordpress'     => '<i class=\'fa fa-lg fa-wordpress\'></i> WordPress',
		'stumbleupon'   => '<i class=\'fa fa-lg fa-stumbleupon\'></i> StumbleUpon',
		'soundcloud'    => '<i class=\'fa fa-lg fa-soundcloud\'></i> SoundCloud',
		'vine'          => '<i class=\'fa fa-lg fa-vine\'></i> Vine',
		'skype'         => '<i class=\'fa fa-lg fa-skype\'></i> Skype',
		'github'        => '<i class=\'fa fa-lg fa-github\'></i> GitHub',
		'bitbucket'     => '<i class=\'fa fa-lg fa-bitbucket\'></i> Bitbucket',
		'twitch'        => '<i class=\'fa fa-lg fa-twitch\'></i> Twitch',
		'weibo'         => '<i class=\'fa fa-lg fa-weibo\'></i> Weibo',
		'tencent-weibo' => '<i class=\'fa fa-lg fa-tencent-weibo\'></i> Tecent Weibo',
		'renren'        => '<i class=\'fa fa-lg fa-renren\'></i> RenRen',
		'xing'          => '<i class=\'fa fa-lg fa-xing\'></i> Xing',
	);
}


/*
 * TGM Plugin Activation.
 */
get_template_part( 'plugins/tgm-plugin-activation/init' );


/*
 * Load Redux Framework extensions and config.
 */
if (class_exists('Redux')) {
	get_template_part( 'plugins/redux-framework/extensions-config' );
	get_template_part( 'plugins/redux-framework/extensions-loader' );
	get_template_part( 'plugins/redux-framework/config' );
} else {
	get_template_part( 'plugins/redux-framework/default-options' );
}


get_template_part( 'inc/helpers/template-tags' );

get_template_part( 'inc/helpers/modules' );

get_template_part( 'inc/helpers/post-formats' );


/*
 * Shop settings.
 */
get_template_part( 'woocommerce/index' );


/*
 * Visual Composer settings.
 */
get_template_part( 'plugins/js_composer/index' );


/*
 * Slider Revolution settings.
 */
if (function_exists('set_revslider_as_theme')) {
	add_action('init', 'avenue_revslider_settings');
	function avenue_revslider_settings() {
		set_revslider_as_theme();
	}
}


/*
 * Enqueue scripts and styles.
 */
add_action('wp_enqueue_scripts', 'avenue_scripts', 99);
function avenue_scripts() {

	wp_enqueue_script( 'jquery-ui-tabs' );

	wp_dequeue_style( 'woocommerce_frontend_styles' );
	wp_dequeue_style( 'woocommerce_fancybox_styles' );
	wp_dequeue_style( 'woocommerce_chosen_styles' );
	wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	wp_dequeue_style( 'select2' );
	wp_dequeue_style( 'yith-wcwl-font-awesome' );
	wp_dequeue_style( 'sb_instagram_icons' );
	wp_dequeue_style( 'jquery-selectBox' );
	wp_dequeue_style( 'yith-wcwl-main' );
	wp_dequeue_style( 'mc4wp-form-basic' );
	wp_deregister_style( 'login-with-ajax' );
	wp_deregister_style( 'font-awesome' );
	wp_deregister_style( 'nivo-slider-theme' );

	function avenue_google_fonts_url() {
		$font_url = '';

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Google fonts: on or off', 'avenue' ) ) {
			$font_url = add_query_arg( 'family', urlencode( 'Open Sans:300,400,500,600,700' ), '//fonts.googleapis.com/css' );
		}
		return $font_url;
	}

	wp_enqueue_style( 'avenue_google_fonts', avenue_google_fonts_url() );
	wp_enqueue_style( 'avenue_style', get_stylesheet_uri() );

	ob_start();
	get_template_part( 'inc/styles' );
	$styles = ob_get_contents();
	ob_end_clean();
	wp_add_inline_style( 'avenue_style', $styles );

	wp_add_inline_style( 'avenue_style', get_theme_option('custom--css', false) );
	wp_add_inline_style( 'avenue_style', get_theme_option('local_custom--css', false) );

	wp_dequeue_script( 'prettyPhoto' );
	wp_dequeue_script( 'prettyPhoto-init' );
	wp_dequeue_script( 'select2' );

	wp_enqueue_script('wc-add-to-cart-variation', false, array(), false, true ); // need for quick view

	$template_dir_uri = get_template_directory_uri();

	// wp_register_script( 'requestAnimationFrame', $template_dir_uri . '/scripts/vendor/requestAnimationFrame/requestAnimationFrame.js', array('jquery'), false, true );
	// wp_register_script( 'smooth-scroll', $template_dir_uri . '/scripts/vendor/jquery-smooth-scroll/jquery.smooth-scroll.min.js', array('jquery'), false, true );
	wp_register_script( 'smooth-scroll_and_requestAnimationFrame', $template_dir_uri . '/scripts/vendor/jquery.smooth-scroll_and_requestAnimationFrame.min.js', array('jquery'), false, true );
	wp_register_script( 'flexslider', $template_dir_uri . '/scripts/vendor/flexslider/jquery.flexslider-min.js', array('jquery'), false, true );
	wp_register_script( 'photoswipe', $template_dir_uri . '/scripts/vendor/photoswipe/dist/photoswipe.min.js', array('jquery'), false, true );
	wp_register_script( 'photoswipeui', $template_dir_uri . '/scripts/vendor/photoswipe/dist/photoswipe-ui-default.min.js', array('jquery', 'photoswipe'), false, true );
	wp_register_script( 'isotope', $template_dir_uri . '/scripts/vendor/isotope/dist/isotope.pkgd.min.js', array('jquery'), false, true );
	// wp_enqueue_script( 'avenue_main', $template_dir_uri . '/scripts/local/main.js', array( 'smooth-scroll','requestAnimationFrame', 'jquery-ui-tabs', 'jquery', 'flexslider', 'photoswipe', 'photoswipeui', 'isotope' ), false, true );
	wp_enqueue_script( 'avenue_main', $template_dir_uri . '/scripts/local/main.js', array( 'smooth-scroll_and_requestAnimationFrame', 'jquery-ui-tabs', 'jquery', 'flexslider', 'photoswipe', 'photoswipeui', 'isotope' ), false, true );
	wp_enqueue_script( 'avenue_main_additional', $template_dir_uri . '/scripts/local/main-additional.js', array( 'avenue_main' ), false, true );

	wp_localize_script(
		'avenue_main',
		'ajaxurl',
		array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('avenue-nonce')
		)
	);

	$custom_js = '(function($) {
		' . get_theme_option('custom--js', false) . '
		' . get_theme_option('local_custom--js', false) . '
	})(jQuery);';
	wp_add_inline_script( 'avenue_main', $custom_js );

}

add_action('wp_head', 'avenue_custom_head_html', 999);
function avenue_custom_head_html() {
	echo get_theme_option('custom--head_html', false);
	echo get_theme_option('local_custom--head_html', false);
}

add_action('wp_footer', 'avenue_custom_footer_html', 999);
function avenue_custom_footer_html() {
	echo get_theme_option('custom--footer_html', false);
	echo get_theme_option('local_custom--footer_html', false);
}


add_action('admin_enqueue_scripts', 'avenue_admin_scripts');
function avenue_admin_scripts() {
	wp_enqueue_style( 'font_awesome', get_template_directory_uri() . '/scripts/vendor/fontawesome/css/font-awesome.min.css' );
	wp_add_inline_style( 'font_awesome', '.updated.redux-message.redux-notice.notice.is-dismissible.redux-notice,.rAds,.update-nag.bsf-update-nag{display:none;height:0;width:0;overflow:hidden;opacity:0;visibility:hidden;}' );
}


if (!get_theme_option('general--wp_version')) {
	remove_action( 'wp_head', 'wp_generator' );
}
if (!get_theme_option('general--wlwmanifest')) {
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
if (!get_theme_option('general--rsd')) {
	remove_action( 'wp_head', 'rsd_link' );
}


/*
 * Posts.
 */
add_filter( 'the_content_more_link', 'remove_more_link' );
function remove_more_link($link) {
	$link = '';
	return $link;
}

add_filter('excerpt_length', 'avenue_excerpt_length', 999);
function avenue_excerpt_length($length) {
	return 20;
}

add_filter('excerpt_more', 'avenue_excerpt_more', 999);
function avenue_excerpt_more() {
	return '...';
}

/* Filter HTTP Request */
add_filter( 'http_request_args', 'avenue_disable_theme_update', 5, 2 );
 
/**
 * How to disable WordPress.org theme update
 * Useful for theme shop, or custom theme for client with the same theme slug as wp.org theme.
 * @author David Chandra <david@shellcreeper.com>
 */
function avenue_disable_theme_update( $r, $url ){
	/* Array of theme slug (folder) to exclude */
	$themes = array(
		'avenue',
	);
 
	/* Bail, if not using WP 3.7+, before that it's using serialize data */
	global $wp_version;
	if ( version_compare( $wp_version, '3.7', '<' ) ){
		return $r;
	}
 
	/* Bail, if not theme update check. */
	if ( false === strpos( $url, 'api.wordpress.org/themes/update-check' ) ){
		return $r;
	}
 
	/* Remove themes */
	$r_body = wp_remote_retrieve_body( $r );
	if( isset( $r_body['themes'] ) ){
		$r_themes = json_decode( $r_body['themes'], true );
		foreach( $themes as $theme ){
			unset( $r_themes['themes'][$theme] );
		}
		$r['body']['themes'] = json_encode( $r_themes );
	}
 
	return $r;
}
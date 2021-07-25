<?php
/**
 * Plugin Name: Blog Designer Pack Pro
 * Plugin URI: https://premium.infornweb.com/news-blog-designer-pack-pro/
 * Version: 1.0.3
 * Description: Display posts on your website in various layouts with various designs.
 * Text Domain: blog-designer-pack
 * Domain Path: /languages/
 * Author: Infornweb
 * Author URI: https://premium.infornweb.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( function_exists( 'bdp_fs' ) ) {
	bdp_fs()->set_basename( true, __FILE__ );
}

if ( ! class_exists( 'Blog_Designer_Pack' ) )  :

	/**
	 * Main Class
	 * @package Blog Designer Pack Pro
	 * @version	1.0
	 */
	final class Blog_Designer_Pack {

		// Instance
		private static $instance;
		
		/**
		 * Script Object.
		 *
		 * @package Blog Designer Pack Pro
	 	 * @version	1.0
		 */
		public $scripts;

		/**
		 * Main Blog Designer Pack Pro Instance.
		 *
		 * Ensures only one instance of Blog_Designer_Pack is loaded or can be loaded.
		 *
		 * @package Blog Designer Pack Pro
	 	 * @version	1.0
		 */
		public static function instance() {
			
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blog_Designer_Pack ) ) {
				self::$instance = new Blog_Designer_Pack();
				self::$instance->setup_constants();

				// For translation
				add_action( 'plugins_loaded', array( self::$instance, 'bdpp_plugins_loaded' ) );

				self::$instance->includes(); // Including required files
				self::$instance->init_hooks();

				self::$instance->scripts = new BDPP_Scripts(); // Script Class
			}
			return self::$instance;
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param string      $name  Constant name.
		 * @param string|bool $value Constant value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Setup plugin constants
		 * Basic plugin definitions
		 * 
		 * @package Blog Designer Pack Pro
		 * @since 1.0
		 */
		private function setup_constants() {

			$this->define( 'BDPP_VERSION', '1.0.3' ); // Version of plugin
			$this->define( 'BDPP_FILE', __FILE__ );
			$this->define( 'BDPP_DIR', dirname( __FILE__ ) );
			$this->define( 'BDPP_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'BDPP_BASENAME', basename( BDPP_DIR ) );
			$this->define( 'BDPP_META_PREFIX', '_bdp_' );
			$this->define( 'BDPP_POST_TYPE', 'post' );
			$this->define( 'BDPP_CAT', 'category' );
		}

		/**
		 * Load Localisation files
		 *
		 * @package Blog Designer Pack Pro
		 * @since 1.0
		 */
		public function bdpp_load_textdomain() {

			global $wp_version;
			
			// Set filter for plugin's languages directory.
			$bdpp_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$bdpp_lang_dir = apply_filters( 'bdpp_languages_directory', $bdpp_lang_dir );
			
			// Traditional WordPress plugin locale filter.
		    $get_locale = get_locale();

		    if ( $wp_version >= 4.7 ) {
		        $get_locale = get_user_locale();
		    }

			// Traditional WordPress plugin locale filter.
			$locale	= apply_filters( 'plugin_locale',  get_locale(), 'blog-designer-pack' );
			$mofile	= sprintf( '%1$s-%2$s.mo', 'blog-designer-pack', $locale );
			
			// Setup paths to current locale file
			$mofile_local	= $bdpp_lang_dir . $mofile;
			$mofile_global	= WP_LANG_DIR . '/plugins/' . BDPP_BASENAME . '/' . $mofile;
			
			if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/blog-designer-pack-pro folder
				
				load_textdomain( 'blog-designer-pack', $mofile_global );
				
			} else { // Load the default language files
				load_plugin_textdomain( 'blog-designer-pack', false, $bdpp_lang_dir );
			}
		}

		/**
		 * Do stuff once all the plugin has been loaded
		 *
		 * @package Blog Designer Pack Pro
		 * @since 1.0
		 */
		public function bdpp_plugins_loaded() {
			$this->bdpp_load_textdomain();

			$this->define( 'BDPP_SCREEN_ID', sanitize_title(__('Blog Designer Pack', 'blog-designer-pack')) );

			// Visual Composer Page Builder Support
			if( class_exists('Vc_Manager') ) {
				include_once( BDPP_DIR . '/includes/admin/shortcode-support/vc-shortcode.php' );
			}

			// If Elementor Page Builder is Installed
			if( defined('ELEMENTOR_PLUGIN_BASE') ) {
				require_once( BDPP_DIR . '/includes/widgets/shortcodes/bdpp-shortcode-widgets.php' );
			}
		}

		/**
		 * Include required files
		 *
		 * @package Blog Designer Pack Pro
		 * @since 1.0
		 */
		private function includes() {

			global $bdpp_options, $bdpp_styles_data;

			// Including freemius file
			include_once( BDPP_DIR . '/freemius.php' );

			// Including common functions file
			include_once( BDPP_DIR . '/includes/bdpp-functions.php' );
			bdpp_common_sett(); // To set plugin setting identity

			// Style Manager Functions
			require_once( BDPP_DIR . '/includes/style-manager/bdpp-style-functions.php' );

			// Plugin Settings
			require_once( BDPP_DIR . '/includes/admin/settings/bdpp-register-settings.php' );
			$bdpp_options = bdpp_get_settings(); // Gettings plugin settings

			// Including template function file
			require_once( BDPP_DIR . '/includes/bdpp-template-functions.php' );

			// Class Script
			require_once( BDPP_DIR . '/includes/class-bdpp-scripts.php' );

			// Class Public
			require_once( BDPP_DIR . '/includes/class-bdpp-public.php' );

			// Class Admin
			require_once( BDPP_DIR . '/includes/admin/class-bdpp-admin.php' );

			// Class Metabox
			require_once( BDPP_DIR . '/includes/admin/class-bdpp-metabox.php' );

			// Plugin shortcodes
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-grid.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-list.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-gridbox.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-slider.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-carousel.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-gridbox-slider.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-masonry.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-timeline.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-post-ticker.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-taxonomy-grid.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-taxonomy-slider.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/misc/bdpp-creative-1.php' );
			require_once( BDPP_DIR . '/includes/shortcodes/bdpp-shrt-tmpl.php' );

			// Shortcode Supports
			include_once( BDPP_DIR . '/includes/admin/shortcode-support/shortcode-fields.php' );

			// Widget Class
			require_once( BDPP_DIR . '/includes/widgets/class-bdpp-widgets.php' );

			// For Admin Side Only
			if ( is_admin() ) {

				// Class Taxonomy
				require_once( BDPP_DIR . '/includes/admin/class-bdpp-taxonomy.php' );

				include_once( BDPP_DIR . '/includes/admin/settings/bdpp-general-settings.php' );
				include_once( BDPP_DIR . '/includes/admin/settings/bdpp-trending-settings.php' );
				include_once( BDPP_DIR . '/includes/admin/settings/bdpp-taxonomy-settings.php' );
				include_once( BDPP_DIR . '/includes/admin/settings/bdpp-sharing-settings.php' );
				include_once( BDPP_DIR . '/includes/admin/settings/bdpp-css-settings.php' );
				include_once( BDPP_DIR . '/includes/admin/settings/bdpp-misc-settings.php' );
			}

			// Plugin installation file
			require_once BDPP_DIR . '/includes/class-bdpp-install.php';
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @package Blog Designer Pack Pro
		 * @since 1.0
		 */
		private function init_hooks() {
			register_activation_hook( BDPP_FILE, array( 'BDPP_Install', 'install' ) );
			add_action( 'after_setup_theme', array( $this, 'bdpp_setup_environment' ) );
			add_action( 'init', array( $this, 'bdpp_init_processes' ) );
		}

		/**
		 * Ensure theme and server variable compatibility and setup image sizes.
		 *
		 * @package Blog Designer Pack Pro
		 * @since 1.0
		 */
		public function bdpp_setup_environment() {

			// Support Post Thumbnails
			if ( ! current_theme_supports( 'post-thumbnails' ) ) {
				add_theme_support( 'post-thumbnails' );
			}
			add_post_type_support( 'post', array( 'thumbnail', 'page-attributes' ) );
		}

		/**
		 * Prior Init Processes
		 *
		 * @package Blog Designer Pack Pro
		 * @since 1.0
		 */
		public function bdpp_init_processes() {
			add_image_size( 'bdpp-medium', 640, 480, true );
		}
	}

endif; // End if class_exists check.

/**
 * The main function for that returns Blog_Designer_Pack
 *
 * Example: <?php $bdpp = BDPP(); ?>
 *
 * @since 1.0
 * @return object|Blog_Designer_Pack The one true Blog_Designer_Pack Instance.
 */
function BDPP() {
	return Blog_Designer_Pack::instance();
}

// Get Plugin Running
BDPP();
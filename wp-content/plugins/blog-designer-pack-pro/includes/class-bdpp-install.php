<?php
/**
 * Installation Class
 *
 * Handles to manage front end process of plugin
 * 
 * @package Blog Designer Pack Pro
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BDPP_Install {

	/**
	 * Plugin Setup (On Activation)
	 * Does the initial setup.
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	public static function install() {

		// Get plugin settings
		$bdpp_opts = get_option('bdpp_opts');

		// Update plugin settings if they are not set
		if( empty( $bdpp_opts ) ) {
			bdpp_default_settings();

			update_option( 'bdpp_version', BDPP_VERSION );
		}

		// Deactivate free version
		if( is_plugin_active('blog-designer-pack/blog-designer-pack.php') ) {
			add_action( 'update_option_active_plugins', array( 'BDPP_Install', 'bdpp_deactivate_lite_version' ) );
		}

		// Clear the permalinks
		flush_rewrite_rules();
	}

	/**
	 * Deactivate free plugin
	 * 
	 * @package Blog Designer Pack Pro
	 * @since 1.0
	 */
	public static function bdpp_deactivate_lite_version() {
		deactivate_plugins('blog-designer-pack/blog-designer-pack.php', true);
	}
}
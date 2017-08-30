<?php
/**
 * Plugin Name: Give - Addon Boilerplate
 * Plugin URI:  https://givewp.com
 * Description: A demo Addon to serve as a boilerplate for devs to better understand how to extend the Give Donation plugin for WordPress.
 * Version:     1.0
 * Author:      WordImpress, LLC
 * Author URI:  https://wordimpress.com
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: giveboilerplate
 */


/*
 * Our Globals for easy Reference.
 * You'll want to make sure you replace "GIVE_ADDON_BOILERPLATE"
 * with your own prefix throughout this whole plugin.
 *
 * Functions are prefixed with "give_boilerplate" and should be replaced as well.
 *
 * The text domain is giveboilerplate and should be replaced as well.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Give_Addon_Boilerplate
 */
final class Give_Addon_Boilerplate {
	/**
	 * Instance.
	 *
	 * @since
	 * @access static
	 * @var Give_Addon_Boilerplate
	 */
	static private $instance;

	/**
	 * Singleton pattern.
	 *
	 * @since
	 * @access private
	 */
	private function __construct() {
	}


	/**
	 * Get instance.
	 *
	 * @since
	 * @access static
	 *
	 * @return Give_Addon_Boilerplate
	 */
	static function get_instance() {
		if ( null === static::$instance ) {
			self::$instance = new Give_Addon_Boilerplate();
			self::$instance->setup();
		}

		return self::$instance;
	}


	/**
	 * Setup
	 *
	 * @since
	 * @access private
	 */
	private function setup() {
		self::$instance->setup_constants();

		register_activation_hook( __FILE__, array( $this, 'install' ) );
		add_action( 'give_init', array( $this, 'init' ), 10, 1 );
	}


	/**
	 * Setup constants
	 *
	 * @since
	 * @access private
	 */
	private function setup_constants() {
		// Defines Addon directory for easy reference.
		if ( ! defined( 'GIVE_ADDON_BOILERPLATE_DIR' ) ) {
			define( 'GIVE_ADDON_BOILERPLATE_DIR', trailingslashit( dirname( __FILE__ ) ) );
		}

		// Defines Addon Basename.
		if ( ! defined( 'GIVE_ADDON_BOILERPLATE_BASENAME' ) ) {
			define( 'GIVE_ADDON_BOILERPLATE_BASENAME', plugin_basename( __FILE__ ) );
		}

		// Defins Addon Version number for easy reference.
		if ( ! defined( 'GIVE_ADDON_BOILERPLATE_VERSION' ) ) {
			define( 'GIVE_ADDON_BOILERPLATE_VERSION', '1.0' );
		}

		// Defines the minimum Version this Addon requires to be activated.
		if ( ! defined( 'GIVE_ADDON_BOILERPLATE_MIN_GIVE_VER' ) ) {
			define( 'GIVE_ADDON_BOILERPLATE_MIN_GIVE_VER', '1.7' );
		}

		if ( ! defined( 'GIVE_ADDON_BOILERPLATE_MIN_GIVE_VERSION' ) ) {
			// Set it to latest.
			define( 'GIVE_ADDON_BOILERPLATE_MIN_GIVE_VERSION', '1.8.13' );
		}
	}


	/**
	 * Plugin installation
	 *
	 * @since
	 * @access public
	 */
	public function install() {

	}

	/**
	 * Plugin installation
	 *
	 * @since
	 * @access public
	 *
	 * @param Give $give
	 */
	public function init( $give ) {
		// Bailout
		if ( ! self::$instance->check_environment( $give ) ) {
			return;
		}

		self::$instance->load_files();
		self::$instance->setup_hooks();
		self::$instance->load_license();
	}


	/**
	 * Check plugin environment
	 *
	 * @since
	 * @access private
	 *
	 * @param Give $give
	 *
	 * @return bool
	 */
	private function check_environment( $give ) {
		// Min. Give. plugin version.
		if ( defined( 'GIVE_VERSION' ) && version_compare( GIVE_VERSION, GIVE_ADDON_BOILERPLATE_MIN_GIVE_VERSION, '<' ) ) {
			require_once GIVE_ADDON_BOILERPLATE_DIR . 'inc/misc-functions.php';

			// Show admin notice.
			add_action( 'admin_notices', '__give_addon_boilerplate_dependency_notice' );

			// Load plugin helper functions.
			if( ! function_exists( 'deactivate_plugins') ) {
				require_once ABSPATH . '/wp-admin/includes/plugin.php';
			}

			// Deactivate plugin.
			deactivate_plugins( GIVE_ADDON_BOILERPLATE_BASENAME );

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			return false;
		}

		return true;
	}


	/**
	 * Load plugin files.
	 *
	 * @since
	 * @access private
	 */
	private function load_files() {
		require_once GIVE_ADDON_BOILERPLATE_DIR . 'inc/misc-functions.php';

		if ( is_admin() ) {
			require_once GIVE_ADDON_BOILERPLATE_DIR . 'inc/admin/settings.php';
		}
	}


	/**
	 * Setup hooks
	 *
	 * @since
	 * @access private
	 */
	private function setup_hooks() {
		// Filters
		add_filter( 'plugin_action_links_' . GIVE_ADDON_BOILERPLATE_BASENAME, '__give_addon_boilerplate_plugin_row_meta', 10, 2 );

		// Actions
		add_action( 'admin_init', '__give_addon_boilerplate_activation_banner' );
	}


	/**
	 * Load license
	 *
	 * @since
	 * @access private
	 */
	private function load_license() {
		new Give_License(
			__FILE__,
			'Give Addon Boilerplate',
			GIVE_ADDON_BOILERPLATE_VERSION,
			'WordImpress',
			'give_addon_boilerplate_license_key'
		);
	}
}

/**
 * The main function responsible for returning the one true Give_Addon_Boilerplate instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $recurring = Give_Addon_Boilerplate(); ?>
 *
 * @since 1.0
 *
 * @return Give_Addon_Boilerplate|bool
 */
function Give_Addon_Boilerplate() {
	return Give_Addon_Boilerplate::get_instance();
}

Give_Addon_Boilerplate();

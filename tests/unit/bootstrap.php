<?php

/**
 * Give Unit Tests Bootstrap
 *
 * @unreleased
 */
class ADDON_CONSTANT_Unit_Tests_Bootstrap {

	/** @var \Give_Unit_Tests_Bootstrap instance */
	protected static $instance = NULL;

	/** @var string directory where wordpress-tests-lib    is installed */
	public $wp_tests_dir;

	/** @var string testing directory */
	public $tests_dir;

	/** @var string plugin directory */
	public $plugin_dir;

	/** @var string give directory */
	public $give_dir;

	/**
	 * Give_RD_Unit_Tests_Bootstrap constructor.
	 *
	 * Setup the unit testing environment
	 */
	public function __construct() {

		ini_set( 'display_errors', 'on' );
		error_reporting( E_ALL );

		// Prevent give_die() from stopping tests.
		if ( ! defined( 'GIVE_UNIT_TESTS' ) ) {
			define( 'GIVE_UNIT_TESTS', TRUE );
		}

		$this->tests_dir    = dirname( __FILE__ );
		$this->plugin_dir   = dirname( $this->tests_dir );
		$this->give_dir     = dirname( dirname( $this->plugin_dir ) ) . '/give';
		$this->wp_tests_dir = getenv( 'WP_TESTS_DIR' ) ? getenv( 'WP_TESTS_DIR' ) : '/tmp/wordpress-tests-lib';

		// Load test function so tests_add_filter() is available
		require_once( "{$this->wp_tests_dir}/includes/functions.php" );

		// Run bootstrap.php in this file only.
		$GLOBALS['manual_bootstrap'] = FALSE;

		// Load Give
        if( file_exists( "{$this->give_dir}/tests/unit/bootstrap.php" ) ) {
            require_once("{$this->give_dir}/tests/unit/bootstrap.php");
        } else {
            require_once("{$this->wp_tests_dir}/give/tests/unit/bootstrap.php");
        }

		// Load plugin
		tests_add_filter( 'muplugins_loaded', array( $this, 'load_plugin' ) );

		// Install plugin
		tests_add_filter( 'init', array( $this, 'install_plugin' ) );

		// Load the WP testing environment
		require_once( "{$this->wp_tests_dir}/includes/bootstrap.php" );

		// Load Give testing framework
		$this->includes();
	}

	/**
	 * Load recurring itself.
	 */
	public function load_plugin() {
		require_once( dirname($this->plugin_dir) . "/ADDON_ID.php" );
	}

	/**
	 * Install recurring.
	 */
	public function install_plugin() {

		echo 'Installing ADDON_DOMAIN...' . PHP_EOL;

		// give_{addon}_install();
	}

	/**
	 * Load Give-specific test cases
	 *
	 * @since 1.4
	 */
	public function includes() {
		Give_Unit_Tests_Bootstrap::instance()->includes();

		require_once( $this->tests_dir . '/helpers.php' );

		// test cases
		// require_once( $this->tests_dir . '/framework/class-{testcase}.php' );

		//Helpers
		// require_once( $this->tests_dir . '/framework/helpers/class-{helper}.php' );
	}

	/**
	 * Get the single class instance.
	 *
	 * @since 1.4
	 * @return Give_Unit_Tests_Bootstrap
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

ADDON_CONSTANT_Unit_Tests_Bootstrap::instance();

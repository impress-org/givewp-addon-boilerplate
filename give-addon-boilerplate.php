<?php
/**
 * Plugin Name: 	Give - Addon Boilerplate
 * Plugin URI: 		https://givewp.com
 * Description: 	A demo Addon to serve as a boilerplate for devs to better understand how to extend the Give Donation plugin for WordPress.
 * Version: 		1.0
 * Author: 			WordImpress, LLC
 * Author URI: 		https://wordimpress.com
 * License:      	GNU General Public License v2 or later
 * License URI:  	http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:		giveboilerplate
 *
 */

/* Our Globals for easy Reference.
 * You'll want to make sure you replace "GIVE_ADDON_BOILERPLATE"
 * with your own prefix throughout this whole plugin.
 *
 * Functions are prefixed with "give_boilerplate" and should be replaced as well.
 *
 * The text domain is giveboilerplate and should be replaced as well.
 */

// Defines Addon directory for easy reference
if ( ! defined( 'GIVE_ADDON_BOILERPLATE_DIR' ) ) {
    define( 'GIVE_ADDON_BOILERPLATE_DIR', dirname(__FILE__) );
}

// Defines Addon Basename
if ( ! defined( 'GIVE_ADDON_BOILERPLATE_BASENAME' ) ) {
    define( 'GIVE_ADDON_BOILERPLATE_BASENAME', plugin_basename( __FILE__ ) );
}

// Defins Addon Version number for easy reference
if ( ! defined( 'GIVE_ADDON_BOILERPLATE_VERSION' ) ) {
    define( 'GIVE_ADDON_BOILERPLATE_VERSION', '1.0' );
}

// Defines the minimum Version this Addon requires to be activated
if ( ! defined( 'GIVE_ADDON_BOILERPLATE_MIN_GIVE_VER' ) ) {
    define( 'GIVE_ADDON_BOILERPLATE_MIN_GIVE_VER', '1.7' );
}

// We want to check some things upon activation so we'll use this action to run everything first
add_action( 'plugins_loaded', 'give_boilerplate_includes' );

function give_boilerplate_includes() {

    // This triggers the Add-on Activation Banner, checks the minimum Give version
    include( GIVE_ADDON_BOILERPLATE_DIR . '/admin/plugin-activation.php');

    // This checks whether Give is activated and stops the plugin from running if Give is not active
    if ( !class_exists('Give') ) {
        return false;
    }

    // Now that minimum version is checked, activate banner is triggered
    // And we know Give is active, we can load up all our Add-on files
    include( GIVE_ADDON_BOILERPLATE_DIR . '/inc/give-addon-boilerplate-metabox.php' );

}
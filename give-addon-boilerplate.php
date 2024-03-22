<?php
namespace GiveAddon;

use GiveAddon\Addon\Activation;
use GiveAddon\Addon\Environment;
use GiveAddon\Domain\AddonServiceProvider;
use GiveAddon\FormExtension\FormExtensionServiceProvider;

/**
 * Plugin Name:         ADDON_NAME
 * Plugin URI:          https://givewp.com/addons/BOILERPLATE/
 * Description:         ADDON_DESCRIPTION
 * Version:             1.0.0
 * Requires at least:   4.9
 * Requires PHP:        5.6
 * Author:              GiveWP
 * Author URI:          https://givewp.com/
 * Text Domain:         ADDON_TEXTDOMAIN
 * Domain Path:         /languages
 */
defined('ABSPATH') or exit;

// Add-on name
define('ADDON_CONSTANT_NAME', 'ADDON_NAME');

// Versions
define('ADDON_CONSTANT_VERSION', '1.0.0');
define('ADDON_CONSTANT_MIN_GIVE_VERSION', '2.8.0');

// Add-on paths
define('ADDON_CONSTANT_FILE', __FILE__);
define('ADDON_CONSTANT_DIR', plugin_dir_path(ADDON_CONSTANT_FILE));
define('ADDON_CONSTANT_URL', plugin_dir_url(ADDON_CONSTANT_FILE));
define('ADDON_CONSTANT_BASENAME', plugin_basename(ADDON_CONSTANT_FILE));

require 'vendor/autoload.php';

// Activate add-on hook.
register_activation_hook(ADDON_CONSTANT_FILE, [Activation::class, 'activateAddon']);

// Deactivate add-on hook.
register_deactivation_hook(ADDON_CONSTANT_FILE, [Activation::class, 'deactivateAddon']);

// Uninstall add-on hook.
register_uninstall_hook(ADDON_CONSTANT_FILE, [Activation::class, 'uninstallAddon']);

// Register the add-on service provider with the GiveWP core.
add_action(
    'before_give_init',
    function () {
        // Check Give min required version.
        if (Environment::giveMinRequiredVersionCheck()) {
            give()->registerServiceProvider(AddonServiceProvider::class);
            give()->registerServiceProvider(FormExtensionServiceProvider::class);
        }
    }
);

// Check to make sure GiveWP core is installed and compatible with this add-on.
add_action('admin_init', [Environment::class, 'checkEnvironment']);

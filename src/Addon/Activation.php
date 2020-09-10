<?php
namespace GiveAddon\Addon;

/**
 * Example of a helper class responsible for registering and handling add-on activation hooks.
 *
 * @package     GiveAddon\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Activation {

	/**
	 * Register add-on activation actions.
	 */
	public static function registerActions() {
		// Activate add-on hook.
		register_activation_hook(
			ADDON_CONSTANT_FILE,
			[
				Activation::class,
				'activateAddon',
			]
		);
		// Deactivate add-on hook.
		register_deactivation_hook(
			ADDON_CONSTANT_FILE,
			[
				Activation::class,
				'deactivateAddon',
			]
		);
		// Uninstall add-on hook.
		register_uninstall_hook(
			ADDON_CONSTANT_FILE,
			[
				Activation::class,
				'uninstallAddon',
			]
		);
	}

	/**
	 * Activate add-on action hook.
	 *
	 * @return void
	 */
	public static function activateAddon() {

	}

	/**
	 * Deactivate add-on action hook.
	 *
	 * @return void
	 */
	public static function deactivateAddon() {

	}

	/**
	 * Uninstall add-on action hook.
	 *
	 * @return void
	 */
	public static function uninstallAddon() {

	}
}

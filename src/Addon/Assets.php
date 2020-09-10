<?php
namespace GiveAddon\Addon;

/**
 * Helper class responsible for loading add-on assets.
 *
 * @package     GiveAddon\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Assets {

	/**
	 * Load add-on backend assets.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function loadBackendAssets() {
		wp_enqueue_style(
			'give-addon-boilerplate-style-backend',
			ADDON_CONSTANT_URL . 'public/css/give-addon-admin.css',
			[],
			GIVE_VERSION
		);

		wp_enqueue_script(
			'give-addon-boilerplate-script-backend',
			ADDON_CONSTANT_URL . 'public/js/give-addon-admin.js',
			[],
			GIVE_VERSION,
			true
		);
	}

	/**
	 * Load add-on front-end assets.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function loadFrontendAssets() {
		wp_enqueue_style(
			'give-addon-boilerplate-style-frontend',
			ADDON_CONSTANT_URL . 'public/css/give-addon.css',
			[],
			GIVE_VERSION
		);

		wp_enqueue_script(
			'give-addon-boilerplate-script-frontend',
			ADDON_CONSTANT_URL . 'public/js/give-addon.js',
			[],
			GIVE_VERSION,
			true
		);
	}
}

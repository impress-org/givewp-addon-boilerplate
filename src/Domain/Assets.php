<?php
namespace GiveAddon\Domain;

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
			'ADDON_ID-style-backend',
			ADDON_CONSTANT_URL . 'public/css/ADDON_ID-admin.css',
			[],
			ADDON_CONSTANT_VERSION
		);

		wp_enqueue_script(
			'ADDON_ID-script-backend',
			ADDON_CONSTANT_URL . 'public/js/ADDON_ID-admin.js',
			[],
			ADDON_CONSTANT_VERSION,
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
			'ADDON_ID-style-frontend',
			ADDON_CONSTANT_URL . 'public/css/ADDON_ID.css',
			[],
			ADDON_CONSTANT_VERSION
		);

		wp_enqueue_script(
			'ADDON_ID-script-frontend',
			ADDON_CONSTANT_URL . 'public/js/ADDON_ID.js',
			[],
			ADDON_CONSTANT_VERSION,
			true
		);
	}
}

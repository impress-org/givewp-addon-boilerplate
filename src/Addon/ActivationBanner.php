<?php

namespace GiveAddon\Addon;

/**
 * Helper class responsible for showing add-on Activation Banner.
 *
 * @package     GiveAddon\Addon\Helpers
 * @copyright   Copyright (c) 2020, GiveWP
 */
class ActivationBanner {

	/**
	 * Show activation banner
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function show() {
		// Only runs on admin.
		$args = [
			'file'              => ADDON_CONSTANT_FILE,
			'name'              => ADDON_CONSTANT_NAME,
			'version'           => ADDON_CONSTANT_VERSION,
			'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=give-addon-boilerplate' ),
			'documentation_url' => 'https://givewp.com/documentation/add-ons/boilerplate/',
			'support_url'       => 'https://givewp.com/support/',
			'testing'           => false, // Never leave true.
		];

		new \Give_Addon_Activation_Banner( $args );
	}
}

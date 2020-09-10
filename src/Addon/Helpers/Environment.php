<?php

namespace GiveAddon\Addon\Helpers;

/**
 * Helper class responsible for checking the add-on environment.
 *
 * @package     GiveAddon\Addon\Helpers
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Environment {

	/**
	 * Check eneviroment.
	 *
	 * @return void
	 */
	public static function checkEnviroment() {
		// Check is GiveWP active
		if ( ! static::isGiveActive() ) {
			add_action( 'admin_notices', [ Notices::class, 'giveInactive' ] );
			return;
		}
		// Check min required version
		if ( ! static::giveMinRequiredVersionCheck() ) {
			add_action( 'admin_notices', [ Notices::class, 'giveVersionError' ] );
		}
	}

	/**
	 * Check min required version of GiveWP.
	 *
	 * @return bool
	 */
	public static function giveMinRequiredVersionCheck() {
		if (
			defined( 'GIVE_VERSION' ) &&
			version_compare( GIVE_VERSION, ADDON_CONSTANT_MIN_GIVE_VERSION, '>=' )
		) {
			return true;
		}

		return false;
	}

	/**
	 * Check if GiveWP is active.
	 *
	 * @return bool
	 */
	public static function isGiveActive() {
		return defined( 'GIVE_VERSION' );
	}
}

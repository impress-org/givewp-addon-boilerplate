<?php

namespace GiveAddon\Addon\Helpers;

/**
 * Helper class responsible for showing add-on notices.
 *
 * @package     GiveAddon\Addon\Helpers
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Notices {

	/**
	 * GiveWP min required version notice.
	 */
	public static function giveVersionError() {
		Give()->notices->register_notice(
			[
				'id'          => 'give-activation-error',
				'type'        => 'error',
				'description' => View::load( 'admin/notices/give-version-error' ),
				'show'        => true,
			]
		);
	}

	/**
	 * GiveWP inactive notice.
	 */
	public static function giveInactive() {
		echo View::load( 'admin/notices/give-inactive' );
	}
}

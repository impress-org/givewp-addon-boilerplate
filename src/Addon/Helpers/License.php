<?php

namespace GiveAddon\Addon\Helpers;

class License {

	/**
	 * Check add-on license.
	 *
	 * @return void
	 */
	public function check() {
		new \Give_License(
			ADDON_CONSTANT_FILE,
			ADDON_CONSTANT_NAME,
			ADDON_CONSTANT_VERSION,
			'GiveWP'
		);
	}
}

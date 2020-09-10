<?php

namespace GiveAddon\Addon\Helpers;
/**
 * Helper class responsible for loading add-on translations.
 *
 * @package     GiveAddon\Addon\Helpers
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Language {
	/**
	 * Load language.
	 *
	 * @return void
	 */
	public static function load() {

		// Set filter for plugin's languages directory.
		$langDir = apply_filters(
			sprintf( '%s_languages_directory', 'ADDON_TEXTDOMAIN' ),
			dirname( ADDON_CONSTANT_BASENAME ) . '/languages/'
		);

		// Traditional WordPress plugin locale filter.
		$locale = apply_filters( 'plugin_locale', get_locale(), 'ADDON_TEXTDOMAIN' );
		$moFile = sprintf( '%1$s-%2$s.mo', 'ADDON_TEXTDOMAIN', $locale );

		// Setup paths to current locale file.
		$moFileLocal  = $langDir . $moFile;
		$moFileGlobal = WP_LANG_DIR . 'ADDON_TEXTDOMAIN' . $moFile;

		if ( file_exists( $moFileGlobal ) ) {
			// Look in global /wp-content/languages/TEXTDOMAIN folder.
			load_textdomain( 'ADDON_TEXTDOMAIN', $moFileGlobal );
		} elseif ( file_exists( $moFileLocal ) ) {
			// Look in local /wp-content/plugins/TEXTDOMAIN/languages/ folder.
			load_textdomain( 'ADDON_TEXTDOMAIN', $moFileLocal );
		} else {
			// Load the default language files.
			load_plugin_textdomain( 'ADDON_TEXTDOMAIN', false, $langDir );
		}
	}
}

<?php

namespace GiveAddon\Addon\Helpers;

use InvalidArgumentException;

/**
 * Helper class responsible for loading add-on views.
 *
 * @package     GiveAddon\Addon\Helpers
 * @copyright   Copyright (c) 2020, GiveWP
 */
class View {

	/**
	 * @param string $view
	 * @param array $templateParams Arguments for template.
	 * @param bool $echo
	 *
	 * @throws InvalidArgumentException if template file not exist
	 *
	 * @since 1.0.0
	 * @return string|void
	 */
	public static function load( $view, $templateParams = [], $echo = false ) {
		$template = ADDON_CONSTANT_DIR . 'src/Addon/resources/views/' . $view . '.php';

		if ( ! file_exists( $template ) ) {
			throw new InvalidArgumentException( "View template file {$template} not exist" );
		}

		ob_start();
		include $template;
		$content = ob_get_clean();

		if ( ! $echo ) {
			return $content;
		}

		echo $content;
	}

	/**
	 * @param string $view
	 * @param array $vars
	 *
	 * @since 1.0.0
	 */
	public static function render( $view, $vars = [] ) {
		static::load( $view, $vars, true );
	}
}

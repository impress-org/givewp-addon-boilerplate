<?php

namespace GiveAddon\Addon;

class Links {
	/**
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function __invoke( $actions ) {
		$newActions = array(
			'settings' => sprintf(
				'<a href="%1$s">%2$s</a>',
				admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=ADDON_TEXTDOMAIN' ),
				__( 'Settings', 'ADDON_TEXTDOMAIN' )
			),
		);

		return array_merge( $newActions, $actions );
	}
}

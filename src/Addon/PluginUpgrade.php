<?php

namespace GiveAddon\Addon\Helpers;

/**
 * Class PluginUpgrade
 * @package GiveAddon\Infrastructure
 *
 * @unreleased
 */
class PluginUpgrade {
    /**
     * @unreleased
     */
    public function storePluginUpgradeVersion() {
        $pluginVersion = preg_replace( '/[^0-9.].*/', '', get_option( 'give_addon_version' ) );

        // Is Fresh install?
        if ( ! $pluginVersion ) {
            $pluginVersion = '1.0.0';
        }

        if ( version_compare( $pluginVersion, ADDON_CONSTANT_VERSION, '<' ) ) {
            update_option(
                'give_addon_version',
                preg_replace( '/[^0-9.].*/', '',
                    ADDON_CONSTANT_VERSION
                )
            );

            update_option(
                'give_addon_version_upgraded_from',
                $pluginVersion,
                false
            );
        }
    }

    /**
     * @unreleased
     */
    public function completeAllMigrationsOnFreshInstall() {
        $pluginVersion = preg_replace( '/[^0-9.].*/', '', get_option( 'give_addon_version' ) );

        // Is fresh install?
        if ( $pluginVersion ) {
            return $this;
        }

        $updates = [];

        foreach ( $updates as $update ) {
            give_set_upgrade_complete( $update );
        }
    }
}


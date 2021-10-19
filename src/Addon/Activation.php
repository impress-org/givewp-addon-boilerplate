<?php

namespace GiveAddon\Addon;

use GiveAddon\Addon\Helpers\PluginUpgrade;

/**
 * Example of a helper class responsible for registering and handling add-on activation hooks.
 *
 * @package     GiveAddon\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Activation {
    /**
     * Activate add-on action hook.
     *
     * @since 1.0.0
     * @return void
     */
    public static function activateAddon() {
        give( PluginUpgrade::class )->completeAllMigrationsOnFreshInstall();
    }

    /**
     * Deactivate add-on action hook.
     *
     * @since 1.0.0
     * @return void
     */
    public static function deactivateAddon() {
    }

    /**
     * Uninstall add-on action hook.
     *
     * @since 1.0.0
     * @return void
     */
    public static function uninstallAddon() {
    }
}

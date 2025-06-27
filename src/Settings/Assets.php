<?php

namespace GiveAddon\Settings;

/**
 * Helper class responsible for loading add-on assets.
 *
 * @package     GiveAddon\Settings
 * @copyright   Copyright (c) 2020, GiveWP
 */
class Assets
{

    /**
     * Load add-on backend assets.
     *
     * @since 1.0.0
     * @return void
     */
    public static function loadBackendAssets()
    {
        wp_enqueue_style('givewp-design-system-foundation');

        wp_enqueue_style(
            'ADDON_ID-settings-style',
            ADDON_CONSTANT_URL . 'build/admin.css',
            [],
            ADDON_CONSTANT_VERSION
        );

        wp_enqueue_script(
            'ADDON_ID-settings-script',
            ADDON_CONSTANT_URL . 'build/admin.js',
            [],
            ADDON_CONSTANT_VERSION,
            true
        );

        $object = [
            'locale' => str_replace('_', '-', get_locale()),
            'imageUrl' => ADDON_CONSTANT_URL . 'public/images/',
        ];

        wp_localize_script(
            'ADDON_ID-settings-script',
            'GiveAddon',
            $object
        );

        if (isset($_GET['tab']) && 'ADDON_ID-settings-page-app' === $_GET['tab']) {
            wp_enqueue_script(
                'ADDON_ID-settings-app',
                ADDON_CONSTANT_URL . 'build/settings.js',
                [],
                ADDON_CONSTANT_VERSION,
                true
            );

            wp_localize_script(
                'ADDON_ID-settings-app',
                'GiveAddon',
                $object
            );
        }
    }

    /**
     * Load add-on front-end assets.
     *
     * @since 1.0.0
     * @return void
     */
    public static function loadFrontendAssets()
    {

        // Load frontend assets.
    }
}

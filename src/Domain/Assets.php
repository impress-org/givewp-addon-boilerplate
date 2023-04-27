<?php

namespace GiveAddon\Domain;

/**
 * Helper class responsible for loading add-on assets.
 *
 * @package     GiveAddon\Addon
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
            'ADDON_ID-style-backend',
            ADDON_CONSTANT_URL . 'public/css/ADDON_ID-admin.css',
            [],
            ADDON_CONSTANT_VERSION
        );

        wp_enqueue_script(
            'ADDON_ID-script-backend',
            ADDON_CONSTANT_URL . 'public/js/ADDON_ID-admin.js',
            [],
            ADDON_CONSTANT_VERSION,
            true
        );

        $object = [
            'locale' => str_replace('_', '-', get_locale()),
            'imageUrl' => ADDON_CONSTANT_URL . 'public/images/',
        ];

        wp_localize_script(
            'ADDON_ID-script-backend',
            'GiveAddon',
            $object
        );

        if (isset($_GET['tab']) && 'ADDON_ID-settings-app' === $_GET['tab']) {
            wp_enqueue_script(
                'ADDON_ID-settings-app',
                ADDON_CONSTANT_URL . 'public/js/settings-page-app.js',
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
        wp_enqueue_style('givewp-design-system-foundation');

        wp_enqueue_style(
            'ADDON_ID-style-frontend',
            ADDON_CONSTANT_URL . 'public/css/ADDON_ID.css',
            [],
            ADDON_CONSTANT_VERSION
        );

        wp_enqueue_script(
            'ADDON_ID-script-frontend',
            ADDON_CONSTANT_URL . 'public/js/ADDON_ID.js',
            [],
            ADDON_CONSTANT_VERSION,
            true
        );

        wp_localize_script(
            'ADDON_ID-script-frontend',
            'GiveAddon',
            [
                'locale' => str_replace('_', '-', get_locale()),
                'imageUrl' => ADDON_CONSTANT_URL . 'public/images/',
            ]
        );
    }
}

<?php

namespace GiveAddon\Settings;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider as ServiceProviderInterface;
use GiveAddon\Addon\ActivationBanner;
use GiveAddon\Addon\License;
use GiveAddon\Settings\Helpers\SettingsPage;
use GiveAddon\Settings\SettingsPage as AddonSettingsPage;

/**
 * Example of a service provider responsible for add-on initialization.
 *
 * @package     GiveAddon\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register()
    {

    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        if (is_admin()){
            $this->loadBackend();
        }
    }

    /**
     * Load add-on backend assets.
     *
     * @return void
     * @since 1.0.0
     */
    private function loadBackend()
    {
        // Register settings page
        SettingsPage::registerPage(AddonSettingsPage::class);

        /**
         * Example of how to register an empty settings page to be used by a React App.
         */
        SettingsPage::registerPage(SettingsPageApp::class);

        // Load backend assets.
        Hooks::addAction('admin_enqueue_scripts', Assets::class, 'loadBackendAssets');
        /**
         * Example of how to extend an existing settings page.
         */
        // Remove settings page section.
        SettingsPage::removePageSection('general', 'access-control');
        // Add new settings page section.
        SettingsPage::addPageSection('general', 'new-section', 'New Access Control Section');
        // Add page settings.
        SettingsPage::addSettings(
            'general',
            'new-section',
            [
                [
                    'name' => __('Custom Setting Field', 'ADDON_TEXTDOMAIN'),
                    'id' => 'custom_setting_field',
                    'desc' => __(
                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ',
                        'ADDON_TEXTDOMAIN'
                    ),
                    'type' => 'text',
                ],
            ]
        );
    }
}

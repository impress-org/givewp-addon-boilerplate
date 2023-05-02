<?php

namespace GiveAddon\Domain;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider;
use GiveAddon\Addon\Activation;
use GiveAddon\Addon\ActivationBanner;
use GiveAddon\Addon\Language;
use GiveAddon\Addon\License;
use GiveAddon\Addon\Links;
use GiveAddon\Domain\Helpers\SettingsPage;
use GiveAddon\Domain\SettingsPage as AddonSettingsPage;

/**
 * Example of a service provider responsible for add-on initialization.
 *
 * @package     GiveAddon\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class AddonServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        give()->singleton(Activation::class);
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        // Load add-on translations.
        Hooks::addAction('init', Language::class, 'load');
        // Load add-on links.
        Hooks::addFilter('plugin_action_links_' . ADDON_CONSTANT_BASENAME, Links::class);

        is_admin()
            ? $this->loadBackend()
            : $this->loadFrontend();
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

        Hooks::addAction('admin_init', License::class, 'check');
        Hooks::addAction('admin_init', ActivationBanner::class, 'show', 20);
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

    /**
     * Load add-on front-end assets.
     *
     * @return void
     * @since 1.0.0
     */
    private function loadFrontend()
    {
        // Load front-end assets.
        Hooks::addAction('wp_enqueue_scripts', Assets::class, 'loadFrontendAssets');
    }
}

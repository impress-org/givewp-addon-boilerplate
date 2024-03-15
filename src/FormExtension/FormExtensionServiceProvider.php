<?php

namespace GiveAddon\Domain;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider;
use GiveAddon\FormExtension\FormBuilder\Actions\LoadFormBuilderAssets;

/**
 * Example of a service provider responsible for Form Extension initialization.
 *
 * @package     GiveAddon\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class FormExtensionServiceProvider implements ServiceProvider
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
        // Load add-on translations.
        //Hooks::addAction('init', Language::class, 'load');
        // Load add-on links.
        //Hooks::addFilter('plugin_action_links_' . ADDON_CONSTANT_BASENAME, Links::class);

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
        Hooks::addAction('givewp_form_builder_enqueue_scripts', LoadFormBuilderAssets::class, '__invoke', 10, 2);
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
        //Hooks::addAction('wp_enqueue_scripts', Assets::class, 'loadFrontendAssets');
    }
}

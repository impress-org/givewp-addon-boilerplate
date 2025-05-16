<?php

namespace GiveAddon\Domain;

use Give\Helpers\Hooks;
use GiveAddon\Addon\Activation;
use GiveAddon\Addon\ActivationBanner;
use GiveAddon\Addon\Language;
use GiveAddon\Addon\License;
use GiveAddon\Addon\Links;
use Give\ServiceProviders\ServiceProvider as ServiceProviderInterface;

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
        Hooks::addAction('admin_init', License::class, 'check');
        Hooks::addAction('admin_init', ActivationBanner::class, 'show', 20);

        // Load backend assets.
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
    }
}

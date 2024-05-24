<?php

namespace GiveAddon\FormExtension;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider;
use GiveAddon\FormExtension\DonationForm\Actions\ConvertDonationFormBlocksToFieldsApi;
use GiveAddon\FormExtension\FormBuilder\Actions\LoadFormBuilderAssets;

/**
 * @since 1.0.0
 */
class FormExtensionServiceProvider implements ServiceProvider
{
    /**
     * @since 1.0.0
     */
    public function register()
    {

    }

    /**
     * @since 1.0.0
     */
    public function boot()
    {
        Hooks::addAction('givewp_form_builder_enqueue_scripts', LoadFormBuilderAssets::class, '__invoke', 10, 2);
        Hooks::addFilter(
            'givewp_donation_form_block_render',
            ConvertDonationFormBlocksToFieldsApi::class,
            '__invoke',
            10,
            4
        );
    }
}

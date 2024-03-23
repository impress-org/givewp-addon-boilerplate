<?php

namespace GiveAddon\FormExtension\FormBuilder\Actions;

use Give\Framework\Support\Facades\Scripts\ScriptAsset;
use GiveAddon\FormExtension\FormBuilder\ViewModels\GiveAddonViewModel;

/**
 * @since 1.0.0
 */
class LoadFormBuilderAssets
{
    /**
     * @since 1.0.0
     */
    public function __invoke()
    {
        $assets = ScriptAsset::get(trailingslashit(ADDON_CONSTANT_URL) . '/build/GiveAddonFormBuilderExtension.asset.php');
        $globalStylePath = trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonFormBuilderExtensionGlobalStyle.css';
        $stylePath = trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonFormBuilderExtension.css';
        $scriptPath = trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonFormBuilderExtension.js';

        if (file_exists($globalStylePath)) {
            wp_enqueue_style(
                'givewp-form-extension-ADDON_ID-global-style',
                $globalStylePath,
                [],
                $assets['version']
            );
        }

        if (file_exists($stylePath)) {
            wp_enqueue_style(
                'givewp-form-extension-ADDON_ID-style',
                $stylePath,
                [],
                $assets['version']
            );
        }

        wp_enqueue_script(
            'givewp-form-extension-ADDON_ID',
            $scriptPath,
            $assets['dependencies'],
            $assets['version'],
            true
        );

        wp_localize_script('givewp-form-extension-ADDON_ID', 'GiveAddonFormBuilder',
            give(GiveAddonViewModel::class)->exports());
    }
}

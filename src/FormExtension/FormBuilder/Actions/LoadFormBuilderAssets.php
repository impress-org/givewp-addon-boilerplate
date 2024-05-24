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
        /**
         * This global path refers to the compiled version of the 'FormExtension/FormBuilder/resources/css/index.scss' style
         */
        $globalStylePath = ADDON_CONSTANT_DIR . 'build/GiveAddonFormBuilderExtensionGlobalStyle.css';
        $globalStyleUrl = trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonFormBuilderExtensionGlobalStyle.css';

        /**
         * This path refers to the compiled version of the '.module.scss' files present in the 'FormExtension/FormBuilder/resources/js/index.tsx' script
         *
         * When the 'FormExtension/FormBuilder/resources/js/index.tsx' file loads some component that uses '.module.scss'
         * and it gets compiled with WP Scripts, then a .js file is generated in the build folder alongside a style file
         * with the same entry name but with the .css extension.
         */
        $cssModuleStylePath = ADDON_CONSTANT_DIR . 'build/GiveAddonFormBuilderExtension.css';
        $cssModuleStyleUrl = trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonFormBuilderExtension.css';

        /**
         * This global path refers to the compiled version of the 'FormExtension/FormBuilder/resources/js/index.tsx' script
         */
        $scriptUrl = trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonFormBuilderExtension.js';
        $assets = ScriptAsset::get(trailingslashit(ADDON_CONSTANT_URL) . '/build/GiveAddonFormBuilderExtension.asset.php');

        if (file_exists($globalStylePath)) {
            wp_enqueue_style(
                'givewp-form-extension-ADDON_ID-global-style',
                $globalStyleUrl,
                [],
                $assets['version']
            );
       }

        if (file_exists($cssModuleStylePath)) {
            wp_enqueue_style(
                'givewp-form-extension-ADDON_ID-style',
                $cssModuleStyleUrl,
                [],
                $assets['version']
            );
        }

        wp_enqueue_script(
            'givewp-form-extension-ADDON_ID',
            $scriptUrl,
            $assets['dependencies'],
            $assets['version'],
            true
        );

        wp_localize_script('givewp-form-extension-ADDON_ID', 'GiveAddonFormBuilder',
            give(GiveAddonViewModel::class)->exports());
    }
}

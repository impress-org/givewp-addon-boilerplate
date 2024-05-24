import ColorsSampleBlock from './Blocks/ColorsSampleBlock';
import {getGiveCoreFormBuilderWindowData} from './window';
import {__} from '@wordpress/i18n';
import GiveAddonSettings from './settings';

const {form} = getGiveCoreFormBuilderWindowData();

/**
 * Register sample blocks
 *
 * @since 1.0.0
 */
form.blocks.register(ColorsSampleBlock.name, ColorsSampleBlock.settings);

/**
 * Register sample settings
 *
 * @since 1.0.0
 */
const addGiveAddonSettings = (settings) => {
    return [
        ...settings,
        {
            name: __('Give Addon Settings Sample', 'ADDON_TEXTDOMAIN'),
            path: 'ADDON_TEXTDOMAIN-settings',
            element: GiveAddonSettings,
        },
    ];
};

wp.hooks.addFilter('givewp_form_builder_settings_additional_routes', 'ADDON_TEXTDOMAIN-settings', addGiveAddonSettings);

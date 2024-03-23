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
            name: __('Give Addon Settings', 'ADDON_TEXTDOMAIN'),
            path: 'give-addon-settings',
            element: GiveAddonSettings,
        },
    ];
};

wp.hooks.addFilter('givewp_form_builder_settings_additional_routes', 'give-addon-settings', addGiveAddonSettings);

import type {BlockConfiguration} from '@wordpress/blocks';
import {__} from '@wordpress/i18n';
import {getGiveAddonFormBuilderWindowData} from '../../window';

const {colors} = getGiveAddonFormBuilderWindowData();

const metadata: BlockConfiguration = {
    name: 'givewp/colors-sample-block',
    title: __('Colors Sample Block', 'ADDON_TEXTDOMAIN'),
    description: __("Set the primary color to customize the donor's swags.", 'ADDON_TEXTDOMAIN'),
    category: 'addons',
    icon: 'yes',
    supports: {
        multiple: false,
    },
    attributes: {
        label: {
            type: 'string',
            default: __('Choose the primary color to use in your swags.', 'ADDON_TEXTDOMAIN'),
        },
        color: {
            type: 'array',
            default: colors[0],
        },
        options: {
            type: 'array',
            default: colors,
        },
    },
};

export default metadata;

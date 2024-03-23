import {PanelRow, ToggleControl} from '@wordpress/components';
import {__} from '@wordpress/i18n';
import {SettingsSection} from '@givewp/form-builder-library';
import {getGiveAddonFormBuilderWindowData} from '../window';
import {createInterpolateElement} from '@wordpress/element';
import {GiveAddonSettingsProps} from '../types/GiveAddonSettingsProps';

/**
 * @since 1.0.0
 */
export default function GiveAddonSettings({settings, setSettings}) {
    const addonSettings: GiveAddonSettingsProps = settings.addonSettings ?? {};
    const {globalOptionsUrl} = getGiveAddonFormBuilderWindowData();

    const updateAddonSettings = (property: string, value: any) => {
        setSettings({
            addonSettings: {
                ...addonSettings,
                [property]: value,
            },
        });
    };

    const customizePdfReceiptsDescription = createInterpolateElement(
        __('Uses <a>global settings</a> when disabled.', 'ADDON_TEXTDOMAIN'),
        {
            a: <a href={globalOptionsUrl} target="_blank" />,
        }
    );

    return (
        <div className={'give-form-settings__pdf-receipts'}>
            <SettingsSection
                title={__('Give Addon Settings', 'ADDON_TEXTDOMAIN')}
                description={__(
                    'This allows you to customize the Add-on settings for just this donation form.',
                    'ADDON_TEXTDOMAIN'
                )}
            >
                <PanelRow className={'no-extra-gap'}>
                    <ToggleControl
                        label={__('Customize Settings', 'ADDON_TEXTDOMAIN')}
                        help={customizePdfReceiptsDescription}
                        checked={addonSettings.enable === 'enabled'}
                        onChange={(value) => {
                            updateAddonSettings('enable', value ? 'enabled' : 'global');
                        }}
                    />
                </PanelRow>
            </SettingsSection>

            {addonSettings.enable === 'enabled' && <p>Your custom settings goes here...</p>}
        </div>
    );
}

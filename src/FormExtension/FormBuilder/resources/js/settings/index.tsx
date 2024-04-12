import {PanelRow, ToggleControl} from '@wordpress/components';
import {__} from '@wordpress/i18n';
import {SettingsSection} from '@givewp/form-builder-library';
import {getGiveAddonFormBuilderWindowData} from '../window';
import {createInterpolateElement} from '@wordpress/element';
import {GiveAddonSettingsProps} from '../types/GiveAddonSettingsProps';
import CustomSettings from './CustomSettings';

/**
 * @since 1.0.0
 */
export default function GiveAddonSettings({settings, setSettings}) {
    console.log('settings: ', settings);
    const addonSettings: GiveAddonSettingsProps = settings.addonSettings ?? {};
    const {globalOptionsUrl} = getGiveAddonFormBuilderWindowData();

    /**
     * This is just a sample demonstrating how to start a Form settings extension, but the values will NOT be updated
     * because there is no "addonSettings" attribute defined in the core form settings. At this moment, there is no way
     * to extend the default form settings without changing the core codebase. In the future, we can change this sample
     * to support updates if a way to extend the form settings is implemented in the core.
     */
    const updateAddonSettings = (property: string, value: any) => {
        setSettings({
            addonSettings: {
                ...addonSettings,
                [property]: value,
            },
        });
    };

    const globalSettingsHelperText = createInterpolateElement(
        __('Uses <a>global settings</a> when disabled.', 'ADDON_TEXTDOMAIN'),
        {
            a: <a href={globalOptionsUrl} target="_blank" />,
        }
    );

    return (
        <div className={'give-form-settings__addon-settings'}>
            <SettingsSection
                title={__('Give Addon Settings Sample', 'ADDON_TEXTDOMAIN')}
                description={__(
                    'This allows you to customize the Add-on settings for just this donation form.',
                    'ADDON_TEXTDOMAIN'
                )}
            >
                <PanelRow className={'no-extra-gap'}>
                    <ToggleControl
                        label={__('Customize Settings', 'ADDON_TEXTDOMAIN')}
                        help={globalSettingsHelperText}
                        checked={addonSettings.enable === 'enabled'}
                        onChange={(value) => {
                            updateAddonSettings('enable', value ? 'enabled' : 'global');
                        }}
                    />
                </PanelRow>
            </SettingsSection>

            {addonSettings.enable === 'enabled' ? (
                <CustomSettings addonSettings={addonSettings} updateAddonSettings={updateAddonSettings} />
            ) : (
                <p>
                    <strong>IMPORTANT:</strong> This is just a sample demonstrating how to start a Form settings
                    extension, but the values will NOT be updated because there is no "addonSettings" attribute defined
                    in the core form settings. At this moment, there is no way to extend the default form settings
                    without changing the core codebase. In the future, we can change this sample to support updates if a
                    way to extend the form settings is implemented in the core.
                </p>
            )}
        </div>
    );
}

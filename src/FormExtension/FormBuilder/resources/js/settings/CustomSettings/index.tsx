import {
    Button,
    ColorPalette,
    PanelRow,
    RadioControl,
    SelectControl,
    TextareaControl,
    TextControl,
} from '@wordpress/components';
import {__} from '@wordpress/i18n';
import {ClassicEditor, SettingsSection} from '@givewp/form-builder-library';
import {useRef} from 'react';
import {customSettingsProps} from '../../types/CustomSettingsProps';
import {getGiveAddonFormBuilderWindowData} from '../../window';
import ImageUpload from '../../components/ImageUpload';
import CopyToClipboardButton from '../../components/CopyToClipboardButton';

const CustomSettings = ({addonSettings, updateAddonSettings}: customSettingsProps) => {
    const donationFormID = new URLSearchParams(window.location.search).get('donationFormID');
    const {sampleTags, previewUrl} = getGiveAddonFormBuilderWindowData();
    const templateTagsRef = useRef<HTMLUListElement>(null);

    const colors = [
        {name: '', color: '#000000'},
        {name: '', color: '#FFFFFF'},
        {name: '', color: '#1E8CBE'},
        {name: '', color: '#f9e3ca'},
        {name: '', color: '#9fd0f8'},
        {name: '', color: '#4492dd'},
        {name: '', color: '#9058d8'},
        {name: '', color: '#f6f6f6'},
        {name: '', color: '#00451d'},
        {name: '', color: '#adb8c2'},
        {name: '', color: '#e792a7'},
        {name: '', color: '#bd3d36'},
        {name: '', color: '#eb712e'},
        {name: '', color: '#f1bb40'},
        {name: '', color: '#95dab7'},
        {name: '', color: '#63cc8a'},
    ];

    return (
        <>
            <SettingsSection
                title={__('Custom Settings', 'ADDON_TEXTDOMAIN')}
                description={__('Description For Custom Settings.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow>
                    <p>Your #1 custom option goes here...</p>
                </PanelRow>
                <PanelRow>
                    <p>Your #2 custom option goes here...</p>
                </PanelRow>
                <PanelRow>
                    <p>Your #3 custom option goes here...</p>
                </PanelRow>
            </SettingsSection>

            <SettingsSection
                title={__('Radio Option Sample', 'ADDON_TEXTDOMAIN')}
                description={__('Description For Radio Option Sample.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow>
                    <RadioControl
                        className="radio-control--pdf-builder-options"
                        label={__('Radio Option Sample', 'ADDON_TEXTDOMAIN')}
                        hideLabelFromVision={true}
                        selected={addonSettings.radioOptionSample ?? 'option_1'}
                        options={[
                            {label: __('Option 1', 'ADDON_TEXTDOMAIN'), value: 'option_1'},
                            {label: __('Option 2', 'ADDON_TEXTDOMAIN'), value: 'option_2'},
                        ]}
                        onChange={(value: string) => updateAddonSettings('radioOptionSample', value)}
                    />
                </PanelRow>
            </SettingsSection>

            <SettingsSection
                title={__('Color Picker Sample', 'ADDON_TEXTDOMAIN')}
                description={__('Description for Color Picker Sample.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow>
                    <ColorPalette
                        colors={colors}
                        value={addonSettings.colorPickerOptionSample ?? '#1E8CBE'}
                        onChange={(value: string) => updateAddonSettings('colorPickerOptionSample', value)}
                    />
                </PanelRow>
            </SettingsSection>

            <SettingsSection
                title={__('Select Option Sample', 'ADDON_TEXTDOMAIN')}
                description={__('Description For Select Option Sample.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow>
                    <SelectControl
                        label={__('Select one option:', 'ADDON_TEXTDOMAIN')}
                        help={__('This is just a sample description.', 'ADDON_TEXTDOMAIN')}
                        options={[
                            {label: __('Option 1', 'ADDON_TEXTDOMAIN'), value: 'option_1'},
                            {label: __('Option 2', 'ADDON_TEXTDOMAIN'), value: 'option_2'},
                            {label: __('Option 3', 'ADDON_TEXTDOMAIN'), value: 'option_3'},
                            {label: __('Option 4', 'ADDON_TEXTDOMAIN'), value: 'option_4'},
                        ]}
                        value={addonSettings.selectOptionSample}
                        onChange={(value: string) => {
                            updateAddonSettings('selectOptionSample', value);
                        }}
                    />
                </PanelRow>
            </SettingsSection>

            <SettingsSection
                title={__('Text Option Sample', 'ADDON_TEXTDOMAIN')}
                description={__('Description For Text Option Sample.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow>
                    <TextControl
                        label={__('Write something:', 'ADDON_TEXTDOMAIN')}
                        help={__('This is just a sample description.', 'ADDON_TEXTDOMAIN')}
                        value={addonSettings.textOptionSample}
                        onChange={(value: string) => updateAddonSettings('textOptionSample', value)}
                    />
                </PanelRow>
            </SettingsSection>

            <SettingsSection
                title={__('Textarea Option Sample', 'ADDON_TEXTDOMAIN')}
                description={__('Description For Textarea Option Sample.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow>
                    <TextareaControl
                        label={__('Write something:', 'ADDON_TEXTDOMAIN')}
                        help={__('This is just a sample description.', 'ADDON_TEXTDOMAIN')}
                        value={addonSettings.textareaOptionSample}
                        onChange={(value: string) => updateAddonSettings('textareaOptionSample', value)}
                    />
                </PanelRow>
            </SettingsSection>

            <SettingsSection
                title={__('Image Selector Option Sample', 'ADDON_TEXTDOMAIN')}
                description={__('Description Image Selector Option Sample.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow className={'pdf-builder-settings__logo_upload'}>
                    <ImageUpload
                        value={addonSettings.imageSelectorOptionSample}
                        onChange={(value: string) => updateAddonSettings('imageSelectorOptionSample', value)}
                    />
                </PanelRow>
            </SettingsSection>

            <SettingsSection
                title={__('Classic Editor Option Sample', 'ADDON_TEXTDOMAIN')}
                description={__('Description For Classic Editor Option Sample.', 'ADDON_TEXTDOMAIN')}
            >
                <ClassicEditor
                    id={'givewp-addon-settings-classic-editor-sample'}
                    label={__('Add your reach text here:', 'ADDON_TEXTDOMAIN')}
                    content={addonSettings.classicEditorOptionSample}
                    setContent={(value) => updateAddonSettings('classicEditorOptionSample', value)}
                />
            </SettingsSection>

            <SettingsSection
                title={__('Sample Tags', 'ADDON_TEXTDOMAIN')}
                description={__('Description Sample Tags.', 'ADDON_TEXTDOMAIN')}
            >
                <PanelRow>
                    <ul className={'pdf-builder-settings-template-tags'} ref={templateTagsRef}>
                        {sampleTags.map((tag) => (
                            <li key={tag.tag}>
                                <strong>{'{' + tag.tag + '}'}</strong>
                                <p style={{fontSize: '.75rem'}}>{tag.desc}</p>
                                <CopyToClipboardButton textToCopy={'{' + tag.tag + '}'} />
                            </li>
                        ))}
                    </ul>
                </PanelRow>
            </SettingsSection>

            <Button
                className={'pdf-builder-settings__pdf-builder-btn'}
                variant={'secondary'}
                onClick={() =>
                    window.open(previewUrl + '&donationFormID=' + donationFormID, '_blank', 'noopener,noreferrer')
                }
            >
                {__('Preview Template Sample', 'ADDON_TEXTDOMAIN')}
            </Button>
        </>
    );
};

export default CustomSettings;

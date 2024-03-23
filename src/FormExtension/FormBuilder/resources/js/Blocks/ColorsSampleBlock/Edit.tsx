import {InspectorControls} from '@wordpress/block-editor';
import {BlockEditProps} from '@wordpress/blocks';
import {PanelBody, PanelRow, SelectControl, TextControl} from '@wordpress/components';
import {__} from '@wordpress/i18n';
import {OptionsPanel} from '@givewp/form-builder-library';
import {OptionProps} from '@givewp/form-builder-library/build/OptionsPanel/types';
import {getGiveAddonFormBuilderWindowData} from '../../window';
import {createInterpolateElement} from '@wordpress/element';
import {useEffect, useState} from 'react';
import {colorProps} from '../../types/colorProps';

const filterCheckedOptions = (options: OptionProps[]) => options.filter((option) => option.checked === true);

const mergeOptionsWithColors = (options: OptionProps[], colors: colorProps[]) => {
    const validOptions = options
        .map((option) => {
            const color = colors.find((color) => color.value === option.value);

            if (color) {
                return option;
            }
        })
        .filter((option) => option);

    const newOptions = colors
        .map((color) => {
            const option = options.find((option) => option.value === color.value);

            if (typeof option === 'undefined') {
                delete color.isDefault;
                return color as OptionProps;
            }
        })
        .filter((color) => color);

    if (newOptions.length > 0) {
        return validOptions.concat(newOptions);
    }

    return validOptions;
};

/**
 * @unreleased
 */
export default function Edit({attributes, setAttributes}: BlockEditProps<any>) {
    const {colors, colorSettingsUrl} = getGiveAddonFormBuilderWindowData();
    const {label, options} = attributes;
    const [donorSelectOptions, setDonorSelectOptions] = useState(filterCheckedOptions(options));
    const [isAdminChoice, setIsAdminChoice] = useState(donorSelectOptions.length === 1);

    useEffect(() => {
        /**
         * This logic ensures that the Default Color will always be checked when none is,
         * it happens when a Color previously used as default in the form is deleted.
         */
        const enabledOptions = filterCheckedOptions(mergeOptionsWithColors(options, colors));
        if (enabledOptions.length === 0) {
            options.find(
                (option: OptionProps) => option.value === colors.find((fund: colorProps) => fund.isDefault).value
            ).checked = true;
            setIsAdminChoice(true);
        } else {
            setIsAdminChoice(enabledOptions.length === 1);
        }

        setDonorSelectOptions(filterCheckedOptions(options));
    }, [options]);

    return (
        <>
            <SelectControl
                disabled={isAdminChoice}
                label={label}
                options={donorSelectOptions}
                onChange={(value: string) => setAttributes({fund: value})}
                help={
                    isAdminChoice &&
                    __(
                        "This field won't appear in the donation form if only one color is selected. To enable color selection, add or select more colors in the block setting",
                        'ADDON_TEXTDOMAIN'
                    )
                }
            />
            <InspectorControls>
                <PanelBody title={__('Colors - Sample Block', 'ADDON_TEXTDOMAIN')} initialOpen={true}>
                    <PanelRow>
                        <TextControl
                            label={__('Label', 'ADDON_TEXTDOMAIN')}
                            placeholder={label}
                            required={true}
                            className={'give-is-required'}
                            value={label}
                            onChange={(value: string) => setAttributes({label: value})}
                        />
                    </PanelRow>
                    <>
                        <OptionsPanel
                            multiple={true}
                            options={mergeOptionsWithColors(options, colors)}
                            setOptions={(newOptions: any) => setAttributes({options: newOptions})}
                            label={__('Funds', 'ADDON_TEXTDOMAIN')}
                            readOnly={true}
                            disableSoloCheckedOption={true}
                        />
                    </>

                    <p>
                        {createInterpolateElement(
                            __(
                                'Select colors to designate for this donation form. You can add or edit your colors in the <a>colors settings.</a>',
                                'ADDON_TEXTDOMAIN'
                            ),
                            {
                                a: <a href={colorSettingsUrl} />,
                            }
                        )}
                    </p>
                </PanelBody>
            </InspectorControls>
        </>
    );
}

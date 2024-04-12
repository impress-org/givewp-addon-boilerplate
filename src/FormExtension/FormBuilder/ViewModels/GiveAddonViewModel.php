<?php

namespace GiveAddon\FormExtension\FormBuilder\ViewModels;

/**
 * @since 1.0.0
 */
class GiveAddonViewModel
{
    /**
     * @since 1.0.0
     */
    public function exports(): array
    {
        $colorsArray = [
            [
                'value' => 'black',
                'label' => 'Black',
                'checked' => true,
                'isDefault' => true,
            ],
            [
                'value' => 'red',
                'label' => 'Red',
                'checked' => true,
                'isDefault' => false,
            ],
            [
                'value' => 'green',
                'label' => 'Green',
                'checked' => false,
                'isDefault' => false,
            ]
        ];

        $sampleTags = [
            ['tag' => 'sitename', 'desc' => __('Site Name', 'give-addon-receipts')],
            ['tag' => 'today', 'desc' => __('Date of Receipt Generation', 'give-addon-receipts')],
            ['tag' => 'date', 'desc' => __('Receipt Date', 'give-addon-receipts')],
        ];

        return [
            'colors' => $colorsArray,
            'colorSettingsUrl' => esc_url_raw(admin_url('edit.php?post_type=give_forms&page=give-addon-color-settings')),
            'globalOptionsUrl' => esc_url_raw(admin_url('edit.php?post_type=give_forms&page=give-settings&tab=give-addon-global-settings')),
            'sampleTags' => $sampleTags,
            'previewUrl' => esc_url_raw(admin_url('edit.php?post_type=give_forms&page=givewp-form-builder'))
        ];
    }
}

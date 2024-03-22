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

        return [
            'colors' => $colorsArray,
            'colorSettingsUrl' => esc_url_raw(admin_url('edit.php?post_type=give_forms&page=give-color-settings')),
        ];
    }
}

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
        return [
            'sampleOption1' => 'value1',
            'sampleOption2' => 'value2',
            'sampleOption3' => 'value3',
        ];
    }
}

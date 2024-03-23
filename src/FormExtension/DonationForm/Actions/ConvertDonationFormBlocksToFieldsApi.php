<?php

namespace GiveAddon\FormExtension\DonationForm\Actions;

use Give\Framework\Blocks\BlockModel;
use Give\Framework\FieldsAPI\Contracts\Node;
use Give\Framework\FieldsAPI\Exceptions\EmptyNameException;
use Give\Framework\FieldsAPI\Field;
use Give\Framework\FieldsAPI\Hidden;
use Give\Framework\FieldsAPI\Select;
use GiveAddon\FormExtension\DonationForm\ValueObjects\ColorField;

/**
 * @unreleased
 */
class ConvertDonationFormBlocksToFieldsApi
{
    /**
     * Converts the Sample Blocks to the form in GiveWP Field API fields
     *
     * @unreleased
     *
     * @throws EmptyNameException
     */
    public function __invoke(?Node $node, BlockModel $block, int $index, int $formId): ?Field
    {
        if ($block->name === 'givewp/colors-sample-block') {
            if ($this->isAdminChoice($block)) {
                $field = Hidden::make(ColorField::COLOR_ID)
                    ->defaultValue($this->getDefaultValue($block));
            } else {
                $field = Select::make(ColorField::COLOR_ID)
                    ->tap(function ($field) use ($block) {
                        $this->setFieldOptions($field, $block);
                    });
            }

            return $field;
        }

        return null;
    }

    /**
     * @unreleased
     */
    private function setFieldOptions(Select $field, BlockModel $block)
    {
        $field->options(...$this->getValidOptions($block));
    }

    /**
     * @unreleased
     */
    private function isAdminChoice(BlockModel $block): bool
    {
        return count($this->getValidOptions($block)) <= 1;
    }

    /**
     * @unreleased
     */
    private function getValidOptions(BlockModel $block): array
    {
        $options = [];
        foreach ($block->getAttribute('options') as $option) {
            if ($option['checked']) {
                $options[] = [$option['value'], $option['label']];
            }
        }

        return $options;
    }

    /**
     * @unreleased
     */
    private function getDefaultValue(BlockModel $block): array
    {
        $validOptions = $this->getValidOptions($block);
        if (count($validOptions) === 1) {
            $defaultValue = [
                'value' => $validOptions[0][0],
                'label' => $validOptions[0][1],
                'checked' => true,
                'isDefault' => $validOptions[0][3],
            ];
        } else {
            $defaultValue = [
                'value' => 'black',
                'label' => 'Black',
                'checked' => true,
                'isDefault' => true,
            ];
        }

        return $defaultValue;
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Plugin;

use Magento\Catalog\Model\Config;
use Magento\Eav\Model\Entity\Attribute;
use Opengento\CatalogSortOrder\Model\Config\SortOrder as SortOrderConfig;
use Opengento\CatalogSortOrder\Model\SortOrder\Direction;
use Opengento\CatalogSortOrder\Model\SortOrder\Option;

class UpdateSortOrderLabel
{
    public function __construct(private SortOrderConfig $sortOrderConfig) {}

    public function afterGetAttributeUsedForSortByArray(Config $subject, array $options): array
    {
        if ($this->sortOrderConfig->isEnabled()) {
            $attributesForSortBy = $subject->getAttributesUsedForSortBy();
            $options = [];
            foreach ($this->sortOrderConfig->getSortOptions() as $option) {
                $attribute = $attributesForSortBy[$option->code] ?? null;
                if ($option->includeDirection) {
                    foreach (Direction::cases() as $direction) {
                        $options[$direction->appendValue($option->code)] = $direction->prependLabel(
                            $this->resolveLabel($attribute, $option)
                        );
                    }
                } else {
                    $options[$option->code] = $this->resolveLabel($attribute, $option);
                }
            }
        }

        return $options;
    }

    private function resolveLabel(?Attribute $attribute, Option $option): string
    {
        return $option->label ?: $attribute?->getStoreLabel() ?? $option->code;
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Provider;

use Magento\Catalog\Model\Config;
use Magento\Eav\Model\Entity\Attribute;
use Opengento\CatalogSortOrder\Model\Config\SortOrder as SortOrderConfig;
use Opengento\CatalogSortOrder\Model\SortOrder\Direction;
use Opengento\CatalogSortOrder\Model\SortOrder\Option;

class SortOrders
{
    private ?array $options = null;

    public function __construct(
        private SortOrderConfig $sortOrderConfig,
        private Config $catalogConfig
    ) {}

    public function getOptions(): array
    {
        return $this->options ??= $this->createOptions();
    }

    private function createOptions(): array
    {
        $attributesForSortBy = $this->catalogConfig->getAttributesUsedForSortBy();
        $availableOrders = [];
        foreach ($this->sortOrderConfig->getSortOptions() as $option) {
            $attribute = $attributesForSortBy[$option->code] ?? null;
            if ($option->includeDirection) {
                foreach (Direction::cases() as $direction) {
                    $availableOrders[$direction->appendValue($option->code)] = $direction->prependLabel(
                        $this->resolveLabel($attribute, $option)
                    );
                }
            } else {
                $availableOrders[$option->code] = $this->resolveLabel($attribute, $option);
            }
        }

        return $availableOrders;
    }

    private function resolveLabel(?Attribute $attribute, Option $option): string
    {
        return $option->label ?: $attribute?->getStoreLabel() ?? $option->code;
    }
}

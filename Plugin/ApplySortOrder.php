<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Plugin;

use Magento\Catalog\Block\Product\ProductList\Toolbar;
use Magento\Catalog\Model\Config;
use Magento\Eav\Model\Entity\Attribute;
use Opengento\CatalogSortOrder\Model\Config\SortOrder as SortOrderConfig;
use Opengento\CatalogSortOrder\Model\SortOrder\Direction;
use Opengento\CatalogSortOrder\Model\SortOrder\Option;

use function array_intersect_key;
use function array_pad;
use function explode;

class ApplySortOrder
{
    public function __construct(
        private SortOrderConfig $sortOrderConfig,
        private Config $catalogConfig
    ) {}

    public function beforeGetAvailableOrders(Toolbar $subject): array
    {
        if ($this->sortOrderConfig->isEnabled() && !$subject->hasData('_grid_advanced_available_orders_isset')) {
            $subject->setData('_grid_advanced_available_orders_init', true);
            $subject->setAvailableOrders([]);
        }

        return [];
    }

    public function beforeSetAvailableOrders(Toolbar $subject, array $orders): array
    {
        if ($this->sortOrderConfig->isEnabled()) {
            $orders = $this->sortOrderConfig->isCategoryOrdersOverridden() || $subject->hasData('_grid_advanced_available_orders_init')
                ? $this->createSortByOptions()
                : array_intersect_key($this->createSortByOptions(), $orders);
            $subject->setData('_grid_advanced_available_orders_isset', true);
        }

        return [$orders];
    }

    public function afterIsOrderCurrent(Toolbar $subject, bool $result, string $order): bool
    {
        return $result ?: $order === $subject->getData('_current_grid_advanced_order');
    }

    public function beforeGetCurrentDirection(Toolbar $subject): array
    {
        $subject->getCurrentOrder();

        return [];
    }

    public function afterGetCurrentOrder(Toolbar $subject, string $result): string
    {
        if ($this->sortOrderConfig->isEnabled()) {
            $subject->setData('_current_grid_advanced_order', $result);
            [$result, $direction] = array_pad(explode(Direction::SEPARATOR, $result, 2), 2, null);
            if ($direction !== null) {
                $subject->setData('_current_grid_direction', $direction);
            }
        }

        return $result;
    }

    private function createSortByOptions(): array
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

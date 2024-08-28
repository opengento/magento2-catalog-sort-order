<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Plugin;

use Magento\Catalog\Block\Product\ProductList\Toolbar;
use Opengento\CatalogSortOrder\Model\Config\SortOrder as SortOrderConfig;
use Opengento\CatalogSortOrder\Model\SortOrder\Direction;

use function array_pad;
use function explode;

class ApplySortOrder
{
    public function __construct(private SortOrderConfig $sortOrderConfig) {}

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
}

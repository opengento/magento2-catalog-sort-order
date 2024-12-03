<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Plugin;

use Magento\Catalog\Helper\Product\ProductList;
use Opengento\CatalogSortOrder\Model\Config\SortOrder as SortOrderConfig;
use Opengento\CatalogSortOrder\Model\SortOrder\Direction;
use Opengento\CatalogSortOrder\Provider\SortOrders;

class ResolveDefaultSort
{
    public function __construct(
        private SortOrders $sortOrders,
        private SortOrderConfig $sortOrderConfig
    ) {}

    public function afterGetDefaultSortField(ProductList $subject, ?string $result): ?string
    {
        if ($result && $this->sortOrderConfig->isEnabled()) {
            $options = $this->sortOrders->getOptions();
            foreach (Direction::cases() as $direction) {
                $sort = $direction->appendValue($result);
                if (isset($options[$sort])) {
                    return $sort;
                }
            }
        }

        return $result;
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

use Opengento\CatalogSortOrder\Model\SortOrder\Option;

use function array_map;
use function array_values;
use function is_array;

class SortOrder
{
    private const CONFIG_PATH_ADVANCED_SORT_STATUS = 'catalog/frontend/advanced_sort_by_status';
    private const CONFIG_PATH_ADVANCED_SORT_OPTIONS = 'catalog/frontend/advanced_sort_by_options';

    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private SerializerInterface $serializer
    ) {}

    public function isEnabled(string|int|null $scopeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_PATH_ADVANCED_SORT_STATUS,
            ScopeInterface::SCOPE_STORE,
            $scopeId
        );
    }

    /**
     * @return Option[]
     */
    public function getSortOptions(string|int|null $scopeId = null): array
    {
        $options = $this->scopeConfig->getValue(
            self::CONFIG_PATH_ADVANCED_SORT_OPTIONS,
            ScopeInterface::SCOPE_STORE,
            $scopeId
        );
        if (!is_array($options)) {
            $options = $this->serializer->unserialize($options ?: '{}');
        }

        return array_values(
            array_map(
                static fn (array $option): Option => new Option(
                    (string)$option['attribute_code'],
                    (string)$option['attribute_label'],
                    (bool)$option['include_direction']
                ),
                $options
            )
        );
    }
}

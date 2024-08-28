<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Model\SortOrder;

readonly class Option
{
    public function __construct(
        public string $code,
        public string $label,
        public bool $includeDirection
    ) {}
}

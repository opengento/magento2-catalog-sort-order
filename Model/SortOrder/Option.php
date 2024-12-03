<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Model\SortOrder;

class Option
{
    public function __construct(
        public readonly string $code,
        public readonly string $label,
        public readonly bool $includeDirection
    ) {}
}

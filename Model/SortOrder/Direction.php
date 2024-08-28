<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Model\SortOrder;

use Magento\Framework\Phrase;

use function str_replace;
use function trim;

enum Direction: string
{
    private const ASC = 'asc';
    private const DESC = 'desc';

    public const SEPARATOR = '|';

    private const LABELS = [
        self::ASC => 'Ascending',
        self::DESC => 'Descending',
    ];

    case Asc = self::ASC;
    case Desc = self::DESC;

    public function getLabel(): Phrase
    {
        return new Phrase(self::LABELS[$this->value] ?? $this->name);
    }

    public function prependLabel(string $label): string
    {
        return $this->getLabel() . ' ' . $label;
    }

    public function truncateLabel(string $label): string
    {
        return trim(str_replace($label, $this->getLabel(), ''));
    }

    public function appendValue(string $value): string
    {
        return $value . self::SEPARATOR . $this->value;
    }

    public function truncateValue(string $value): string
    {
        return trim(str_replace($value, $this->value . self::SEPARATOR, ''));
    }
}

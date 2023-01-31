<?php

declare(strict_types=1);

namespace Recruitment\Dictionary;

//TODO: az kusi o zastosowanie enumów, ale nie ta wersja php
class TaxDictionary
{
    public const TAX_0 = 0;
    public const TAX_5 = 5;
    public const TAX_8 = 8;
    public const TAX_23 = 23;

    public static function isTaxProperValue(int $tax): bool
    {
        return in_array($tax, [self::TAX_0, self::TAX_5, self::TAX_8, self::TAX_23]);
    }
}

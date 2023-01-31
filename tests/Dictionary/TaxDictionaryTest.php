<?php

declare(strict_types=1);

namespace Recruitment\Tests\Dictionary;

use PHPUnit\Framework\TestCase;
use Recruitment\Dictionary\TaxDictionary;

class TaxDictionaryTest extends TestCase
{
    /**
     * @test
     * @dataProvider getCorrectTaxes
     */
    public function itReturnsTrueForProvidedTaxes(int $tax): void
    {
        $this->assertTrue(TaxDictionary::isTaxProperValue($tax));
    }

    public function getCorrectTaxes(): array
    {
        return [
            [0],
            [5],
            [8],
            [23],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Recruitment\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Recruitment\Dictionary\TaxDictionary;
use Recruitment\Entity\Item;
use Recruitment\Tests\ProductBuilder;
use Recruitment\Utils\ItemCalculator;

class ItemCalculatorTest extends TestCase
{
    use ProductBuilder;

    /**
     * @test
     * @dataProvider getDataForValuesWithQuantity
     */
    public function itReturnsProperValueDueToQuantity(int $basedPrice, int $quantity, int $calculatedPrice): void
    {
        $itemCalculator = new ItemCalculator();

        $product = $this->buildTestProduct(1, $basedPrice, TaxDictionary::TAX_23);
        $item = new Item($product, $quantity);
        $this->assertEquals($calculatedPrice, $itemCalculator->getTotalPrice($item));
    }

    /**
     * @test
     * @dataProvider getDataForValuesWithQuantityAndTax
     */
    public function itReturnsProperValueDueToQuantityAndTax($basedPrice, int $quantity, int $tax, int $calculatedPrice): void
    {
        $itemCalculator = new ItemCalculator();

        $product = $this->buildTestProduct(1, $basedPrice, $tax);
        $item = new Item($product, $quantity);
        $this->assertEquals($calculatedPrice, $itemCalculator->getTotalPriceGross($item));
    }

    public function getDataForValuesWithQuantity(): array
    {
        return [
            [10000, 1, 10000],
            [10000, 2, 20000],
        ];
    }

    public function getDataForValuesWithQuantityAndTax(): array
    {
        return [
            [10000, 1, 0, 10000],
            [10000, 2, 0, 20000],
            [10000, 1, 5, 10500],
            [10000, 2, 5, 21000],
            [10000, 1, 8, 10800],
            [10000, 2, 8, 21600],
            [10000, 1, 23, 12300],
            [10000, 2, 23, 24600],
        ];
    }

}

<?php

declare(strict_types=1);

namespace Recruitment\Tests\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Recruitment\Entity\Exception\InvalidTaxValueException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;
use Recruitment\Entity\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function itThrowsExceptionForInvalidUnitPrice(): void
    {
        $this->expectException(InvalidUnitPriceException::class);
        $product = new Product();
        $product->setUnitPrice(0);
    }

    /**
     * @test
     * @dataProvider getIncorrectTaxes
     */
    public function itThrowExceptionForInvalidTaxValue(int $tax): void
    {
        $this->expectException(InvalidTaxValueException::class);
        $product = new Product();
        $product->setTax($tax);
    }

    /**
     * @test
     */
    public function itThrowsExceptionForInvalidMinimumQuantity(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product();
        $product->setMinimumQuantity(0);
    }

    public function getIncorrectTaxes(): array
    {
        return [
            [1],
            [2],
            [50],
            [66],
        ];
    }
}

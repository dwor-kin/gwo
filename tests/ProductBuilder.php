<?php

declare(strict_types=1);

namespace Recruitment\Tests;

use Recruitment\Entity\Product;

trait ProductBuilder
{
    protected function buildTestProduct(int $id, int $price, int $tax): Product
    {
        return (new Product())->setId($id)->setUnitPrice($price)->setTax($tax);
    }
}

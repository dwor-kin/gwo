<?php

declare(strict_types=1);

namespace Recruitment\Utils;

use Recruitment\Entity\Item;

class ItemCalculator implements ItemCalculatorInterface
{
    public function getTotalPrice(Item $item): int
    {
        return $item->getProduct()->getUnitPrice() * $item->getQuantity();
    }

    public function getTotalPriceGross(Item $item): int
    {
        $brutto = ($item->getProduct()->getUnitPrice() * $item->getQuantity() * $item->getProduct()->getTax()) / 100;

        return ($item->getProduct()->getUnitPrice() * $item->getQuantity()) + $brutto;
    }
}

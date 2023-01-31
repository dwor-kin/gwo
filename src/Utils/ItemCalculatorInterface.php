<?php

declare(strict_types=1);

namespace Recruitment\Utils;

use Recruitment\Entity\Item;

interface ItemCalculatorInterface
{
    public function getTotalPrice(Item $item): int;
    public function getTotalPriceGross(Item $item): int;
}

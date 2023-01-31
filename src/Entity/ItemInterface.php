<?php

declare(strict_types=1);

namespace Recruitment\Entity;

interface ItemInterface
{
    public function getProduct(): ProductInterface;
    public function getQuantity(): int;
    public function setQuantity(int $quantity): void;
}

<?php

declare(strict_types=1);

namespace Recruitment\Entity;

interface ProductInterface
{
    public function setId(int $id): ProductInterface;
    public function getId(): ?int;
    public function setTax(int $tax): ProductInterface;
    public function getTax(): int;
    public function getUnitPrice(): int;
    public function setUnitPrice(int $unitPrice): ProductInterface;
    public function setMinimumQuantity(int $minimumQuantity): ProductInterface;
    public function getMinimumQuantity(): int;
}

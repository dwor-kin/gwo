<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Entity\Item;
use Recruitment\Entity\ItemInterface;
use Recruitment\Entity\OrderInterface;
use Recruitment\Entity\ProductInterface;

interface CartInterface
{
    public function addProduct(ProductInterface $product, int $quantity): CartInterface;

    /**
     * @return ItemInterface[]
     */
    public function getItems(): array;

    public function getItem(int $index): ItemInterface;

    public function getTotalPrice(): int;

    public function getTotalPriceGross(): int;

    public function setQuantity(ProductInterface $product, int $quantity): void;

    public function removeProduct(ProductInterface $product): void;

    public function checkout(int $orderNumber): OrderInterface;
}

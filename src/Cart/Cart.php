<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use OutOfBoundsException;
use Recruitment\Entity\Item;
use Recruitment\Entity\ItemInterface;
use Recruitment\Entity\Order;
use Recruitment\Entity\OrderInterface;
use Recruitment\Entity\ProductInterface;
use Recruitment\Utils\ItemCalculator;
use Recruitment\Utils\ItemCalculatorInterface;

class Cart implements CartInterface
{
    private const DEFAULT_QUANTITY = 1;

    /**
     * @var Item[]
     */
    private $items = [];

    /**
     * @var ItemCalculatorInterface $itemCalculator
     */
    private $itemCalculator;

    public function __construct(ItemCalculatorInterface $itemCalculator)
    {
        $this->itemCalculator = $itemCalculator;
    }

    public function addProduct(ProductInterface $product, int $quantity = self::DEFAULT_QUANTITY): CartInterface
    {
        $index = $this->findProductInCartItem($product);

        if (null !== $index) {
            $this->items[$index]->setQuantity($this->items[$index]->getQuantity() + $quantity);
        } else {
            $this->items[] = new Item($product, $quantity);
        }

        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getItem(int $index): ItemInterface
    {
        if (!array_key_exists($index, $this->items)) {
            throw new OutOfBoundsException();
        }

        return $this->items[$index];
    }

    public function getTotalPrice(): int
    {
        $sum = 0;

        foreach ($this->items as $item) {
            $sum += $this->itemCalculator->getTotalPrice($item);
        }

        return $sum;
    }

    public function getTotalPriceGross(): int
    {
        $sum = 0;

        foreach ($this->items as $item) {
            $sum += $this->itemCalculator->getTotalPriceGross($item);
        }

        return $sum;
    }

    public function setQuantity(ProductInterface $product, int $quantity): void
    {
        $id = $product->getId();

        $items = array_filter($this->items, static function ($item) use ($id) {
            return $item->getProduct()->getId() === $id;
        });

        if ($items) {
            $item = array_shift($items);
            $item->setQuantity($quantity);
        } else {
            $this->items[] = new Item($product, $quantity);
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        $id = $product->getId();
        $this->items = array_filter($this->items, static function ($item) use ($id) {
            return $item->getProduct()->getId() !== $id;
        });
        sort($this->items);
    }

    public function checkout(int $orderNumber): OrderInterface
    {
        $cart = clone $this;
        $order = new Order(new ItemCalculator(), $cart, $orderNumber);
        $this->items = [];

        return $order;
    }

    private function findProductInCartItem(ProductInterface $product): ?int
    {
        foreach ($this->items as $index => $item) {
            if ($item->getProduct() === $product) {
                return $index;
            }
        }

        return null;
    }
}

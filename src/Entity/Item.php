<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use InvalidArgumentException;
use Recruitment\Cart\Exception\QuantityTooLowException;

class Item implements ItemInterface
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    public function __construct(ProductInterface $product, int $quantity)
    {
        if ($quantity < $product->getMinimumQuantity()) {
            throw new InvalidArgumentException();
        }

        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): void
    {
        if ($quantity < $this->quantity) {
            throw new QuantityTooLowException();
        }
        $this->quantity = $quantity;
    }
}

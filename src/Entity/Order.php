<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Cart\CartInterface;
use Recruitment\Utils\ItemCalculatorInterface;

class Order implements OrderInterface
{
    /**
     * @var ItemCalculatorInterface
     */
    private $itemCalculator;

    /**
     * @var CartInterface
     */
    private $cart;

    /**
     * @var int
     */
    private $orderNumber;

    public function __construct(ItemCalculatorInterface $itemCalculator, CartInterface $cart, int $orderNumber)
    {
        $this->itemCalculator = $itemCalculator;
        $this->cart = $cart;
        $this->orderNumber = $orderNumber;
    }
    public function getDataForView(): array
    {
        $items = [];

        foreach ($this->cart->getItems() as $item) {
            $items[] = [
                'id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'total_price_netto' => $this->itemCalculator->getTotalPrice($item),
                'tax' => $item->getProduct()->getTax() . '%',
                'total_price_brutto' => $this->itemCalculator->getTotalPriceGross($item)
            ];
        }

        return [
            'id' => $this->orderNumber,
            'items' => $items,
            'total_price_netto' => $this->cart->getTotalPrice(),
            'total_price_brutto' => $this->cart->getTotalPriceGross(),
        ];
    }
}

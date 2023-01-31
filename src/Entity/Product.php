<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use InvalidArgumentException;
use Recruitment\Dictionary\TaxDictionary;
use Recruitment\Entity\Exception\InvalidTaxValueException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product implements ProductInterface
{
    private const INVALID_UNIT_PRICE_VALUE = 0;
    private const INCORRECT_MINIMUM_QUANTITY = 0;

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @var int
     */
    private $unitPrice;

    /**
     * @var int
     */
    private $minimumQuantity = 1;

    /**
     * @var int
     */
    private $tax = 0;

    public function setId(int $id): ProductInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTax(int $tax): ProductInterface
    {
        if (!TaxDictionary::isTaxProperValue($tax)) {
            throw new InvalidTaxValueException();
        }

        $this->tax = $tax;

        return $this;
    }

    public function getTax(): int
    {
        return $this->tax;
    }

    public function setUnitPrice(int $unitPrice): ProductInterface
    {
        if (self::INVALID_UNIT_PRICE_VALUE === $unitPrice) {
            throw new InvalidUnitPriceException();
        }

        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function setMinimumQuantity(int $minimumQuantity): ProductInterface
    {
        if (self::INCORRECT_MINIMUM_QUANTITY === $minimumQuantity) {
            throw new InvalidArgumentException();
        }

        $this->minimumQuantity = $minimumQuantity;

        return $this;
    }

    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }
}

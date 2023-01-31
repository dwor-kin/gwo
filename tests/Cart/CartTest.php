<?php

declare(strict_types=1);

namespace Recruitment\Tests\Cart;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Recruitment\Cart\Cart;
use Recruitment\Dictionary\TaxDictionary;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;
use Recruitment\Tests\ProductBuilder;
use Recruitment\Utils\ItemCalculator;

class CartTest extends TestCase
{
    use ProductBuilder;

    /**
     * @test
     */
    public function itAddsOneProduct(): void
    {
        $product = $this->buildTestProduct(1, 15000, TaxDictionary::TAX_23);

        $cart = new Cart(new ItemCalculator());
        $cart->addProduct($product, 1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertEquals($product, $cart->getItem(0)->getProduct());
    }

    /**
     * @test
     */
    public function itRemovesExistingProduct(): void
    {
        $product1 = $this->buildTestProduct(1, 15000, TaxDictionary::TAX_23);
        $product2 = $this->buildTestProduct(2, 10000, TaxDictionary::TAX_23);

        $cart = new Cart(new ItemCalculator());
        $cart->addProduct($product1, 1)
            ->addProduct($product2, 1);
        $cart->removeProduct($product1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(10000, $cart->getTotalPrice());
        $this->assertEquals($product2, $cart->getItem(0)->getProduct());
    }

    /**
     * @test
     */
    public function itIncreasesQuantityWhenAddingAnExistingProduct(): void
    {
        $product = $this->buildTestProduct(1, 15000, TaxDictionary::TAX_23);

        $cart = new Cart(new ItemCalculator());
        $cart->addProduct($product, 1)
            ->addProduct($product, 2);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(45000, $cart->getTotalPrice());
    }

    /**
     * @test
     */
    public function itUpdatesQuantityOfAnExistingItem(): void
    {
        $product = $this->buildTestProduct(1, 15000, TaxDictionary::TAX_23);

        $cart = new Cart(new ItemCalculator());
        $cart->addProduct($product, 1)
            ->setQuantity($product, 2);

        $this->assertEquals(30000, $cart->getTotalPrice());
        $this->assertEquals(2, $cart->getItem(0)->getQuantity());
    }

    /**
     * @test
     */
    public function itAddsANewItemWhileSettingQuantityForNonExistentItem(): void
    {
        $product = $this->buildTestProduct(1, 15000, TaxDictionary::TAX_23);

        $cart = new Cart(new ItemCalculator());
        $cart->setQuantity($product, 1);

        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertCount(1, $cart->getItems());
    }

    /**
     * @test
     * @dataProvider getNonExistentItemIndexes
     */
    public function itThrowsExceptionWhileGettingNonExistentItem(int $index): void
    {
        $this->expectException(OutOfBoundsException::class);
        $product = $this->buildTestProduct(1, 15000, TaxDictionary::TAX_23);

        $cart = new Cart(new ItemCalculator());
        $cart->addProduct($product, 1);
        $cart->getItem($index);
    }

    /**
     * @test
     */
    public function removingNonExistentItemDoesNotRaiseException(): void
    {
        $cart = new Cart(new ItemCalculator());
        $cart->addProduct($this->buildTestProduct(1, 15000, TaxDictionary::TAX_23));
        $cart->removeProduct(new Product());

        $this->assertCount(1, $cart->getItems());
    }

    /**
     * @test
     */
    public function itClearsCartAfterCheckout(): void
    {
        $cart = new Cart(new ItemCalculator());
        $cart->addProduct($this->buildTestProduct(1, 15000, TaxDictionary::TAX_23));
        $cart->addProduct($this->buildTestProduct(2, 10000, TaxDictionary::TAX_23), 2);

        $order = $cart->checkout(7);

        $this->assertCount(0, $cart->getItems());
        $this->assertEquals(0, $cart->getTotalPrice());
        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(['id' => 7, 'items' => [
            ['id' => 1, 'quantity' => 1, 'total_price_netto' => 15000, 'tax' => '23%', 'total_price_brutto' => 18450],
            ['id' => 2, 'quantity' => 2, 'total_price_netto' => 20000, 'tax' => '23%', 'total_price_brutto' => 24600],
        ], 'total_price_netto' => 35000, 'total_price_brutto' => 43050], $order->getDataForView());
    }

    public function getNonExistentItemIndexes(): array
    {
        return [
            [PHP_INT_MIN],
            [-1],
            [1],
            [PHP_INT_MAX],
        ];
    }
}

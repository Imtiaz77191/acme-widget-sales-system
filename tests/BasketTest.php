<?php

use PHPUnit\Framework\TestCase;

require 'Basket.php';

class BasketTest extends TestCase
{
    private array $products;
    private array $deliveryRules;
    private array $offers;

    protected function setUp(): void
    {
        $this->products = [
            'R01' => ['price' => 32.95],
            'G01' => ['price' => 24.95],
            'B01' => ['price' => 7.95],
        ];

        $this->deliveryRules = [
            50 => 4.95,
            90 => 2.95,
        ];

        $this->offers = [
            'R01' => 'buy_one_get_second_half_price',
        ];
    }

    public function testBasketTotal()
    {
        $basket = new Basket($this->products, $this->deliveryRules, $this->offers);

        $basket->add('B01');
        $basket->add('G01');
        $this->assertEquals(37.85, $basket->total());

        $basket = new Basket($this->products, $this->deliveryRules, $this->offers);
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(54.37, $basket->total());

        $basket = new Basket($this->products, $this->deliveryRules, $this->offers);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(98.27, $basket->total());
    }
}

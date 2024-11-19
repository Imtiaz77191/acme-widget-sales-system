<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Basket.php';

class BasketTest extends TestCase
{
    private $catalog;
    private $deliveryRules;
    private $offers;

    protected function setUp(): void
    {
        $this->catalog = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95,
        ];
        $this->deliveryRules = [
            50 => 4.95,
            90 => 2.95,
            PHP_INT_MAX => 0.0,
        ];
        $this->offers = [
            'R01' => function (float $price, int $count): float {
                $pairs = intdiv($count, 2);
                $remainder = $count % 2;
                return $pairs * ($price + $price / 2) + $remainder * $price;
            },
        ];
    }

    public function testTotalWithExample1(): void
    {
        $basket = new Basket($this->catalog, $this->deliveryRules, $this->offers);
        $basket->add('B01');
        $basket->add('G01');
        $this->assertEquals(37.85, $basket->total());
    }

    public function testTotalWithExample2(): void
    {
        $basket = new Basket($this->catalog, $this->deliveryRules, $this->offers);
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(54.37, $basket->total());
    }

    public function testTotalWithExample3(): void
    {
        $basket = new Basket($this->catalog, $this->deliveryRules, $this->offers);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(98.27, $basket->total());
    }
}

<?php

class Basket
{
    private array $products;
    private array $deliveryRules;
    private array $offers;
    private array $basket = [];

    public function __construct(array $products, array $deliveryRules, array $offers)
    {
        $this->products = $products;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add(string $productCode): void
    {
        if (!isset($this->products[$productCode])) {
            throw new InvalidArgumentException("Product code $productCode does not exist.");
        }
        $this->basket[] = $productCode;
    }

    public function total(): float
    {
        $subtotal = $this->calculateSubtotal();
        $subtotal = $this->applyOffers($subtotal);
        $delivery = $this->calculateDelivery($subtotal);

        return round($subtotal + $delivery, 2);
    }

    private function calculateSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->basket as $code) {
            $subtotal += $this->products[$code]['price'];
        }
        return $subtotal;
    }

    private function applyOffers(float $subtotal): float
    {
        $redWidgetCount = count(array_filter($this->basket, fn($code) => $code === 'R01'));

        if ($redWidgetCount > 1) {
            $offerDiscount = floor($redWidgetCount / 2) * ($this->products['R01']['price'] / 2);
            $subtotal -= $offerDiscount;
        }

        return $subtotal;
    }

    private function calculateDelivery(float $subtotal): float
    {
        foreach ($this->deliveryRules as $threshold => $cost) {
            if ($subtotal < $threshold) {
                return $cost;
            }
        }
        return 0.0; // Free delivery for orders $90 or more
    }
}

// Define the products, delivery rules, and offers
$products = [
    'R01' => ['price' => 32.95],
    'G01' => ['price' => 24.95],
    'B01' => ['price' => 7.95],
];

$deliveryRules = [
    50 => 4.95,
    90 => 2.95,
];

$offers = [
    'R01' => 'buy_one_get_second_half_price',
];

// Create a new Basket instance
$basket = new Basket($products, $deliveryRules, $offers);

// Add some test products to the basket
$basket->add('B01'); // Blue Widget
$basket->add('G01'); // Green Widget

// Display the total cost of the basket
echo 'Basket Total: $' . $basket->total();

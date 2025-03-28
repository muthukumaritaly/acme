<?php
require 'vendor/autoload.php';

use Acme\Basket;
use Acme\Model\Product;
use Acme\Service\DeliveryCalculator;

// Create product catalog
$catalog = [
    new Product('B01', 'Blue Widget', 24.95),
    new Product('G01', 'Green Widget', 12.90),
    new Product('R01', 'Red Widget', 32.95),
];

// Mock Delivery Calculator (Modify if needed)
$deliveryCalculator = new DeliveryCalculator();

// Test Cases
$testCases = [
    [['B01', 'G01']],         // Expected: Subtotal: 37.85, Discount: 0.00, Final Total: 37.85
    [['R01', 'R01']],         // Expected: Subtotal: 65.90, Discount: 16.48, Final Total: 49.42
    [['R01', 'G01']],         // Expected: Subtotal: 57.90, Discount: 0.00, Final Total: 57.90
    [['B01', 'B01', 'R01', 'R01', 'R01']], // Expected: Subtotal: 146.75, Discount: 16.48, Final Total: 130.27
];

foreach ($testCases as $case) {
    $basket = new Basket($catalog, $deliveryCalculator);
    
    foreach ($case[0] as $productCode) {
        $basket->add($productCode);
    }

    $subtotal = $basket->calculateSubtotal();
    $discount = $basket->calculateDiscount();
    $total = $basket->total();

    echo "Products: " . implode(", ", $case[0]) . "\n";
    echo "Subtotal: " . number_format($subtotal, 2) . "\n";
    echo "Discount: " . number_format($discount, 2) . "\n";
    echo "Final Total: " . number_format($total, 2) . "\n";
    echo "--------------------------------------\n";
}
?>

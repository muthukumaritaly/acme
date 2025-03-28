<?php

declare(strict_types=1);

namespace Acme\Service;

class DeliveryCalculator
{
    public function calculate(float $subtotal): float
    {
        if ($subtotal >= 90) {
            return 0.00; // Free delivery
        } elseif ($subtotal >= 50) {
            return 2.95; // Discounted delivery
        } else {
            return 4.95; // Standard delivery
        }
    }
}

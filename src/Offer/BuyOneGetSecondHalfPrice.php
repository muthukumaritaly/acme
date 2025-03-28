<?php

declare(strict_types=1);

namespace Acme\Offer;

use Acme\Model\Product;

class BuyOneGetSecondHalfPrice implements OfferInterface
{
    public function __construct(
        private readonly string $productCode
    ) {}

    public function calculateDiscount(array $items): float
    {
        // Filter items applicable for this discount
        $applicableItems = array_values(array_filter($items, fn($item) => $this->appliesTo($item)));

        // Sort items by price to ensure discount is applied to the cheaper item
        usort($applicableItems, fn($a, $b) => $a->getPrice() <=> $b->getPrice());

        $count = count($applicableItems);
        $discount = 0.0;

        // Apply discount on every second item
        for ($i = 1; $i < $count; $i += 2) {
            $discount += $applicableItems[$i]->getPrice() / 2;
        }

        return round($discount, 2);
    }




    public function appliesTo(Product $product): bool
    {
        return $product->getCode() === $this->productCode;
    }
}
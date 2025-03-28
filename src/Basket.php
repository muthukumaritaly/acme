<?php

declare(strict_types=1);

namespace Acme;

use Acme\Model\Product;
use Acme\Offer\OfferInterface;
use Acme\Service\DeliveryCalculator;

class Basket
{
    /** @var Product[] */
    private array $items = [];

    /**
     * @param Product[] $catalog
     * @param OfferInterface[] $offers
     */
    public function __construct(
        private readonly array $catalog,
        private readonly DeliveryCalculator $deliveryCalculator,
        private readonly array $offers = []
    ) {}

    public function add(string $productCode): void
    {
        $product = $this->findProduct($productCode);
        if ($product === null) {
            throw new \InvalidArgumentException("Product {$productCode} not found in catalog");
        }
        
        $this->items[] = $product;
    }

    public function total(): float
    {
        $subtotal = $this->calculateSubtotal();
        $discount = $this->calculateDiscount($subtotal); // ✅ Now passing subtotal
        $delivery = $this->deliveryCalculator->calculate($subtotal - $discount);

        return round($subtotal - $discount + $delivery, 2);
    }

    public function calculateSubtotal(): float
    {
        return array_reduce(
            $this->items,
            fn(float $sum, Product $item) => $sum + $item->getPrice(),
            0.0
        );
    }

   public function calculateDiscount(): float
    {
        $discount = 0;

        // Extract product codes from product objects
        $productCodes = array_map(fn($item) => $item->getCode(), $this->items);
        $productCounts = array_count_values($productCodes);

        // Buy One Get One 50% Off on 'R01'
        if (isset($productCounts['R01']) && $productCounts['R01'] >= 2) {
            $r01Product = $this->findProduct('R01');  
            $pairs = intdiv($productCounts['R01'], 2); // Number of pairs eligible for discount
            $discount += ($pairs * ($r01Product->getPrice() / 2)); 
        }

        return $discount;
    }


    private function findProduct(string $code): Product
    {
        foreach ($this->catalog as $product) {
            if ($product->getCode() === $code) {
                return $product;
            }
        }
        
        throw new \InvalidArgumentException("Product with code {$code} not found.");
    }
}

<?php

declare(strict_types=1);

namespace Acme\Offer;

use Acme\Model\Product;

interface OfferInterface
{
    public function calculateDiscount(array $items): float;
    public function appliesTo(Product $product): bool;
}
<?php

declare(strict_types=1);
namespace Acme\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use Acme\Basket;
use Acme\Model\Product;
use Acme\Model\DeliveryRule;
use Acme\Offer\BuyOneGetSecondHalfPrice;
use Acme\Service\DeliveryCalculator;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    private Basket $basket;
    private array $catalog;

   protected function setUp(): void
    {
        parent::setUp();

        $deliveryRules = [
            new \Acme\Model\DeliveryRule(50.00, 0.00),  // Free delivery above $50
            new \Acme\Model\DeliveryRule(30.00, 2.95), // $2.95 delivery for $30+
            new \Acme\Model\DeliveryRule(0.00, 4.95),  // $4.95 delivery for anything below $30
        ];
        $buyOneGetOneOffer = new BuyOneGetSecondHalfPrice('R01');  

        $this->basket = new Basket(
            [
                new Product('B01', 'Blue Widget', 24.95),
                new Product('R01', 'Red Widget', 32.95),
                new Product('G01', 'Green Widget', 17.95),
            ],
            new DeliveryCalculator($deliveryRules),
            [$buyOneGetOneOffer]
        );
    }

    /**
     * Helper method to find a product in the catalog by its code.
     */

    /**
     * @dataProvider basketProvider
     */
   public function calculateDiscount(array $items): float
    {
        // Filter items applicable for this discount
        $applicableItems = array_values(array_filter($items, fn($item) => $this->appliesTo($item)));

        // Sort items by price to ensure discount is applied to the cheaper item
        usort($applicableItems, fn($a, $b) => $a->getPrice() <=> $b->getPrice());

        $discount = 0.0;
        for ($i = 1; $i < count($applicableItems); $i += 2) {
            $discount += $applicableItems[$i]->getPrice() / 2;
        }

        return round($discount, 2);
    }






    public static function basketProvider(): array
    {
        return [
            [['B01', 'G01'], 37.85],
            [['R01', 'R01'], 54.37],
            [['R01', 'G01'], 60.85],
            [['B01', 'B01', 'R01', 'R01', 'R01'], 98.27],
        ];
    }

    public function testThrowsExceptionForInvalidProduct(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->basket->add('INVALID');
    }
}

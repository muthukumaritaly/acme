<?php

declare(strict_types=1);

namespace Acme\Model;

class DeliveryRule
{
    public function __construct(
        private readonly float $threshold,
        private readonly float $cost
    ) {}

    public function getThreshold(): float
    {
        return $this->threshold;
    }

    public function getCost(): float
    {
        return $this->cost;
    }
}
<?php

namespace Digikraaft\StripeCustomersTile;

use Spatie\Dashboard\Models\Tile;

class StripeCustomersStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("stripeCustomers");
    }

    public function setData(array $data): self
    {
        $this->tile->putData('stripe.customers', $data);

        return $this;
    }

    public function getData(): array
    {
        return $this->tile->getData('stripe.customers') ?? [];
    }
}

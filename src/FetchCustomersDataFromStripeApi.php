<?php

namespace Digikraaft\StripeCustomersTile;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Stripe\StripeClient;

class FetchCustomersDataFromStripeApi extends Command
{
    protected $signature = 'dashboard:fetch-customers-data-from-stripe-api';

    protected $description = 'Fetch data for Stripe Customers tile';

    public function handle()
    {
        $stripe = new StripeClient(
            config('dashboard.tiles.stripe.secret_key', env('STRIPE_SECRET'))
        );

        $this->info('Fetching Stripe customers ...');

        $customers = $stripe->customers->all(
            config('dashboard.tiles.stripe.customers.params') ?? ['limit' => 5]
        );

        $customers = collect($customers->data)
            ->map(function ($customer) {
                return [
                    'name' => $customer->name,
                    'customer_id' => $customer->id,
                    'email' => $customer->email,
                    'createdAt' => Carbon::parse($customer->created)
                        ->format("d.m.Y"),
                ];
            })->toArray();

        StripeCustomersStore::make()->setData($customers);

        $this->info('All done!');

        return 0;
    }
}

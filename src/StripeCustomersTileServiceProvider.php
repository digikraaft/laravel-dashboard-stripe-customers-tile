<?php

namespace Digikraaft\StripeCustomersTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class StripeCustomersTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchCustomersDataFromStripeApi::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/stripe-customers-tile'),
        ], 'stripe-customers-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-stripe-customers-tile');

        Livewire::component('stripe-customers-tile', StripeCustomersTileComponent::class);
    }
}

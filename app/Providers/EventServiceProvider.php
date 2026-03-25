<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\InsuranceExpiryEvent::class => [
            \App\Listeners\SendInsuranceExpiryEmail::class,
        ],
        \App\Events\RegistrationExpiryEvent::class => [
            \App\Listeners\SendRegistrationExpiryEmail::class,
        ],
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}

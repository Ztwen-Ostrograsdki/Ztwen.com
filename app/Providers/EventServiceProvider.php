<?php

namespace App\Providers;

use App\Events\PaymentSystemEvent;
use Illuminate\Support\Facades\Event;
use App\Events\NewProductCreatedEvent;
use Illuminate\Auth\Events\Registered;
use App\Listeners\PaymentSystemListener;
use App\Listeners\NewProductCreatedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewProductCreatedEvent::class => [
            NewProductCreatedListener::class,
        ],
        PaymentSystemEvent::class => [
            PaymentSystemListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}

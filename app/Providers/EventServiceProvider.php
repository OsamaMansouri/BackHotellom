<?php

namespace App\Providers;

use App\Listeners\ProlongationEventSubscriber;
use App\Listeners\UserEventSubscriber;
use App\Events\PromotionAddedEvent;
use App\Listeners\PromotionNotification;
use App\Events\StatistiqueUpdateEvent;
use App\Listeners\StatistiqueUpdateListener;
use App\Events\ActiveClientsEvent;
use App\Listeners\ActiveClientsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PromotionAddedEvent::class => [
            PromotionNotification::class
        ],
        StatistiqueUpdateEvent::class => [
            StatistiqueUpdateListener::class
        ],
        ActiveClientsEvent::class => [
            ActiveClientsListener::class
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        ProlongationEventSubscriber::class,
        UserEventSubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
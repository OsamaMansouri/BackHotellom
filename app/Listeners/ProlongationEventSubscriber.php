<?php

namespace App\Listeners;

use App\Events\AcceptProlongationEvent;
use App\Events\NewProlongationNotificationEvent;
use App\Notifications\AcceptProlongation;
use App\Notifications\NewProlongation;
use Illuminate\Support\Facades\Notification;

class ProlongationEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle new prolongation event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleNewProlongation($event)
    {
        Notification::send($event->super_admin, new NewProlongation($event->admin_name));
    }

    /**
     * Handle accept prolongation event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleAcceptProlongation($event)
    {
        Notification::send($event->admin, new AcceptProlongation());
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            NewProlongationNotificationEvent::class,
            [ProlongationEventSubscriber::class, 'handleNewProlongation']
        );

        $events->listen(
            AcceptProlongationEvent::class,
            [ProlongationEventSubscriber::class, 'handleAcceptProlongation']
        );
    }
}

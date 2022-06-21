<?php

namespace App\Listeners;

use App\Events\UserHasBeenAddedEvent;
use App\Events\UserPassHasBeenUpdatedEvent;
use App\Events\UserHasRegistredEvent;
use App\Mail\UserHasBeenAddedMail;
use App\Mail\UserPassHasBeenUpdatedMail;
use App\Mail\UserHasRegistredMail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;

class UserEventSubscriber
{
    private $userRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle new user registred.
     *
     * @param  object  $event
     * @return void
     */
    public function handleUserHasRegistred($event)
    {
        // Add event user to mesibo
        $this->userRepository->addUserToMesibo($event->user);

        // Send email to new user registred
        Mail::to($event->user)->queue(new UserHasRegistredMail());
    }

    /**
     * Handle new user added.
     *
     * @param  object  $event
     * @return void
     */
    public function handleUserHasBeenAdded($event)
    {
        // Add event user to mesibo
        $this->userRepository->addUserToMesibo($event->user);

        // Send email with password to new user added
        $email = $event->user->email;
        $password = $event->password;
        Mail::to($event->user)->queue(new UserHasBeenAddedMail($email, $password));
    }

    /**
     * Handle new user added.
     *
     * @param  object  $event
     * @return void
     */
    public function handleUserPassHasBeenUpdated($event)
    {
        // Send email with password to new user added
        $email = $event->user->email;
        $password = $event->password;
        Mail::to($event->user)->queue(new UserPassHasBeenUpdatedMail($email, $password));
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
            UserHasRegistredEvent::class,
            [UserEventSubscriber::class, 'handleUserHasRegistred']
        );

        $events->listen(
            UserHasBeenAddedEvent::class,
            [UserEventSubscriber::class, 'handleUserHasBeenAdded']
        );

        $events->listen(
            UserPassHasBeenUpdatedEvent::class,
            [UserEventSubscriber::class, 'handleUserPassHasBeenUpdated']
        );
    }
}

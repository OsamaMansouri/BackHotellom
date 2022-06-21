<?php

namespace App\Events;

use App\Repositories\UserRepository;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewProlongationNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $super_admin;
    public $admin_name;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($admin_name)
    {
        $this->admin_name = $admin_name;

        // Get super admin user
        $userRepo = new UserRepository;
        $this->super_admin = $userRepo->getSuperAdmin();
    }
}

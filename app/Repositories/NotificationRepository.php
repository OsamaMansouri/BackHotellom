<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class NotificationRepository
{

    /**
     * Display the list articles
     */
    public function getNotifications(){
        $notification = DB::table('notifications')->orderBy('created_at','desc')->get();
        return $notification;
    }
}

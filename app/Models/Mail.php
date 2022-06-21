<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use \Mailjet\Resources;

class Mail extends Model
{
    use HasFactory;

    public static function sendEmail($event,$template = null){
        $mj = new \Mailjet\Client('479ebdf327d7826263a8cfce5666ecfa','900e19b23514359c50e6dbb6a9f0170f',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "contact@hotellom.com",
                        'Name' => "Hotellom"
                    ],
                    'To' => [
                        [
                            'Email' => $event->user->email,
                            'Name' => $event->user->firstname
                        ]
                    ],
                    'Subject' => "Hotellom",
                    'TextPart' => "Hotellom",
                    'HTMLPart' => $template,
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }

}

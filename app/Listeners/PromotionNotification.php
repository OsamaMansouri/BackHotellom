<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PromotionAddedEvent;

class PromotionNotification
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
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PromotionAddedEvent $event)
    {
        $topic = "";
        $notif = array(
            "title" => $event->offer->titre,
            "body" => $event->offer->description
        );

        // Send Promotion To A group Of Topic That Belong To One Hotel
        $to ="/topics/hotel-" . $event->offer->hotel_id;

        $apiKey = "AAAAfMmRk3E:APA91bFg_tZOGAfBPny8v_hRi2wNHWEDgtRE23956FwWh1DesIYgk3bnnidXrE5WmT44oJLLD45bpH4kiXBErgxwYad9k_Hcj-Y0XdTGC-zs5suc3lTywaBt9JpvYmiNOtPJoKOB7nis";
        
        $fields = json_encode(array('to'=> $to, 'notification'=>$notif));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($fields));
        
        $headers = array();
        $headers[] = 'Authorization: key='. $apiKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        //dd($result . ' offre-titre: '.$event->offer->titre);
    }
}

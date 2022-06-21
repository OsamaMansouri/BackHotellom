<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\PromotionAddedEvent;
use App\Models\Hotel;
use App\Models\Offer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ActiveOffers extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'active-offers';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $hotels = Hotel::get();
        foreach ($hotels as $hotel){
            // Get Today Active Promotions
            $offers = Offer::getActiveOffers($hotel->id);
            $date = date('H:i:s');
            foreach ($offers as $offer){
                // Check If Start Time == Current Hour And Send The Notification
                if($offer->startTime === $date){
                    // Event/Listener To Send Promotion Notification RealTime/FireBase/Topics
                    $this->sendNotif($offer);
                    // Log
                    Log::channel('users')->info("Offer $offer->id with date $offer->startTime has bean pushed to phone at $date");
                }
            }
        }

    }

    public function sendNotif($offer)
    {
        $users = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::CLIENT);
                            })
                        ->where('hotel_id', $offer->hotel->id)
                        ->whereNotNull('experation_date')
                        ->where('experation_date', '>=', date("Y-m-d h:i:s a", time()))
                        ->pluck('deviceToken');

        $notif = array(
            "title" => $offer->titre,
            "body" => $offer->description,
        );

        $data = array(
            "type" => "notif_event"
        );

        $apiKey = env('FIREBASE_API_KEY');

        $fields = json_encode(array('registration_ids'=> $users, 'notification'=>$notif, 'data'=>$data));

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
    }
}

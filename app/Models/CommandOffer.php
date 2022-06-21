<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandOffer extends Model
{
    use HasFactory;
    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $fillable = [
       'offer_id',
       'user_id',
       'total',
       'quantity',
       'comment',
       'orderStatus',
       'room_id'
   ];

   public function offer()
   {
       return $this->belongsTo(Offer::class);
   }

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function room()
   {
       return $this->belongsTo(Room::class);
   }
}

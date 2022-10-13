<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'type_id',
        'Frequency',
        'startDate',
        'startTime',
        'endDate',
        'description',
        'prix',
        'profit',
        'discount',
        'prixFinal',
        'image',
        'status',
        'orders',
        'hotel_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    
    protected $with =['user'];
    public function user()
    {
        return $this->belongsTo(User::class,'hotel_id','id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public static function getActiveOffers($hotel){
        //return Offer::whereBetween(Carbon::now()->toDateTimeString(), ['startDate', 'endDate'])->get();
        //$offers = DB::select( DB::raw("SELECT * FROM `offers` WHERE DATE(NOW()) BETWEEN startDate AND endDate"));
        $offers = Offer::where('hotel_id', $hotel)->whereRaw('(now() between startDate and endDate)')->get();
        return $offers;
    }

}

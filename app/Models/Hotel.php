<?php

namespace App\Models;

use App\Repositories\HotelRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    const STATUS_AFCTIVE = 'ACTIVE';
    const STATUS_EXPIRD = 'EXPIRED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'country',
        'city',
        'address',
        'status',
        'reference',
        'ice',
        'idf',
        'rib',
        'rc',
        'code',
        'reason',
        'comment',
        'updated_at',
        'mesibo_token',
        'mesibo_uid'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function prolongations()
    {
        return $this->hasMany(Prolongation::class);
    }

    public function general_setting()
    {
        return $this->hasOne(GeneralSetting::class);
    }

    public function licence()
    {
        return $this->hasOne(Licence::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * get a hotel details by QR Code
     * @param String $qrCode The string of the QR Code
     * @return array $hotel the hotel requested
     */
    public static function getHotelDetails($qrcode)
    {
        $room = Room::Where('qrcode',$qrcode)->first();
        $hotel = Hotel::with('rooms')->where('hotels.id',$room->hotel_id)->first();
        return $hotel;
    }
}

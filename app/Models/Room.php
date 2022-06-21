<?php

namespace App\Models;

use BaconQrCode\Encoder\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Scalar\String_;

class Room extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'room_number',
        'qrcode',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Create a new QR Code
     * @param Integer $len The length of the QR Code
     * @return String the generated QR Code
     */
    public static function newQrCode($len = 8)
    {
        $code = "";
        for ($i = 0; $i < $len; $i++) {
            $d = rand(1, 30) % 2;
            $code .= $d ? chr(rand(65, 90)) : chr(rand(48, 57));
        }
        $code = strtolower($code);

       return $code;
    }

    /**
     * get a room by QR Code
     * @param String $qrCode The string of the QR Code
     * @return array $room the room requested
     */
    public static function getRoomByQrCode($qrCode)
    {
        $room = Room::Where('qrcode',$qrCode)->with('hotel')->first();
        $result='Chambre numéro: '.$room->room_number.' Hotel: '.$room->hotel->name.' Adresse: '.$room->hotel->address.' ville: '.$room->hotel->city.' pays: '.$room->Hotel->country;
        return  $result;
    }

    // public function scanQrQode with print convert to pdf
}

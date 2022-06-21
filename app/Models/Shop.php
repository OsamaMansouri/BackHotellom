<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'name',
        'type_id',
        'color',
        'pdf_file',
        'menu',
        'startTime',
        'endTime',
        'description',
        'sequence',
        //'isRoomService',
        'size'
    ];


    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class,'type_id','id');
    }

}

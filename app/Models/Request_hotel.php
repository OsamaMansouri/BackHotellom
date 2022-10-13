<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request_hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'demmand_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    protected $with =['demmand'];
    public function demmand()
    {
        return $this->belongsTo(Demmand::class,'demmand_id','id');
    }
}

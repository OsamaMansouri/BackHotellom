<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        //'hotel_id',
        'name',
        'gold_img',
        'purple_img',
    ];

   /*  public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    } */

}

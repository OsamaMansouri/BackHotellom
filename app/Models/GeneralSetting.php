<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'logo',
        'licence_days',
        'tax',
        'timer',
        /* 'commissions' */
    ];


    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}

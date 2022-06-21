<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demmand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
        'sequence',
        'isEmpthy',
        //'hotel_id',
    ];

    /* public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    } */

    public function demmandOptions()
    {
        return $this->hasMany(DemmandOption::class);
    }
}

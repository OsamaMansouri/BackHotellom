<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultLicence extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'days'
    ];


    static protected function getLicenceDays()
    {
        $licenceDays = DefaultLicence::first()->pluck('days');

        return $licenceDays[0];
    }
}

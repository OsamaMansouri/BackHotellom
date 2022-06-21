<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Licence extends Model
{
    const IS_VALID = 'isValid';
    const IN_PROCESS = 'processing';

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'startDate',
        'endDate'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the list of Expired licences
     */
    public function getExpiredLicences(){
        return Licence::whereDate('endDate',Carbon::today()->toDateString())->paginate();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'activeClients',
        'activeClientsWeek',
        'activeClientsMonth',
        'activeClientsYear',
        'commandsDay',
        'commandsWeek',
        'commandsMonth',
        'commandsYear',
        'salesDay',
        'salesWeek',
        'salesMonth',
        'salesYear',
        'avgDay',
        'avgWeek',
        'avgMonth',
        'avgYear',
        'conversionWeek',
        'conversionMonth',
        'conversionYear',
        'commandsProfitDay',
        'commandsProfitWeek',
        'commandsProfitMonth',
        'commandsProfitYear'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}

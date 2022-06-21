<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'icon',
        'startTime',
        'endTime',
        'Sequence',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

}

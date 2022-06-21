<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'name',
        'max_choice',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}

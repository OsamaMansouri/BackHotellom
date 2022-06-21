<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $fillable = [
        'article_id',
        'user_id',
        'total',
        'comment'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getRatingCount($article)
    {
        $sum = Rating::where('article_id', $article)->sum('total');
        $ratings = Rating::where('article_id', $article)->get();
        $rating['count'] = count($ratings);
        $rating['sum'] = $sum;
        return $rating;
    }
}

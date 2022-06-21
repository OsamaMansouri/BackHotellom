<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandArticle extends Model
{
    use HasFactory;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'command_id',
        'quantity',
        'total',
        'comment'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function command()
    {
        return $this->belongsTo(Command::class);
    }

    public function commandOptions()
    {
        return $this->hasMany(CommandOption::class);
    }

}

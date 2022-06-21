<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandOption extends Model
{
    use HasFactory;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'option_id',
        'command_article_id'
    ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function commandChoices()
    {
        return $this->hasMany(CommandChoice::class);
    }
}

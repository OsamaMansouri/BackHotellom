<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandChoice extends Model
{
    use HasFactory;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'choice_id',
        'command_option_id'
    ];

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }

}

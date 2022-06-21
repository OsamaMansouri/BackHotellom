<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content',
        'type',
        'demmand_id',
        'hotel_id',
        'conversation_id',
        'fromManager'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function demmand()
    {
        return $this->belongsTo(Demmand::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

}

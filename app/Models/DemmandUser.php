<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemmandUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'status',
        'demmand_id',
        'user_id',
        'option_id',
        'room_id',
        'done_by',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;

    public function demmand()
    {
        return $this->belongsTo(Demmand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function option()
    {
        return $this->hasOne(DemmandOption::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const SUPER_ADMIN = 'super-admin';
    const ADMIN = 'admin';
    const CLIENT = 'client';
    const RECEPTIONIST = 'receptionist';
    const ROOMS_SERVANT = 'rooms-servant';
    const HOUSEKEEPING = 'housekeeping';
    const MANAGER = 'manager';

    public $timestamps = false;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

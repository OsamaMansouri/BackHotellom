<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
//use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles, Billable;
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'name',
        'email',
        'image',
        'password',
        'social_id',
        'mesibo_uid',
        'mesibo_token',
        'experation_date',
        'avatar',
        'phone_number',
        'etat',
        'dateNaissance',
        'gender',
        'city',
        'country',
        'nationality',
        'function',
        'deviceToken',
        'del',
        'connected',
        'is_manager'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }*/


    protected function getPermissionAttribute()
    {
        return $this->getAllPermissions();
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    public function modelHasRole()
    {
        return $this->hasOne(ModelHasRole::class, 'model_id', 'id');
    }
}

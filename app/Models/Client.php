<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName',
        'etablissement',
        'poste',
        'phone',
        'email',
        'type',
        'datePre',
        'demmands',
        'vendeur',
        'ville',
        'commentaire',
        'priorite',
        'nbrChambre',
        'profile'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;
    use HasFactory;
    const DEFAULT_PERMISSIONS = [
        'Articles',
        'Categories',
        'RoomService',
        'SPA',
        'Prolongations',
        'Commandes',
        'Paiments',
        'Add_Prolongations',
        'Staffs',
        'Shops',
        'GeneralSettings',
        //'Types',
        'Offers',
        'Dashboards',
        //'Demmands',
        'ClientsDemmands'
    ];

    const manager_Rooms_service = [
        'Articles',
        'RoomService',
        'Commandes',
        'Prolongations',
        'Categories',
        'Paiments',
        'Add_Prolongations',
        'Shops',
        'GeneralSettings',
        'Offers',
        'Dashboards',
    ];
    const manager_housekeeping = [
        'Dashboards',
        'ClientsDemmands',
        
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];

}

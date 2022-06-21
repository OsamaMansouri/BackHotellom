<?php

namespace Database\Seeders;

use App\Models\DefaultLicence;
use App\Models\ModelHasPermission;
use App\Models\ModelHasRole;
use App\Models\Permission;
use App\Models\RoleHasPermission;
use App\Models\Role;
use App\Models\User;
use App\Models\Type;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        Role::factory()->create([
            'name' =>  'super-admin',
            'guard_name' => 'web'
        ]);
        Role::factory()->create([
            'name' =>  'admin',
            'guard_name' => 'web'

        ]);
        Role::factory()->create([
            'name' =>  'client',
            'guard_name' => 'web'
        ]);

        Role::factory()->create([
            'name' =>  'receptionist',
            'guard_name' => 'web'
        ]);

        Role::factory()->create([
            'name' =>  'rooms-servant',
            'guard_name' => 'web'
        ]);

        // Permissions
        Permission::factory()->create([
            'name' =>  'Hotels',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Prolongations',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Permissions',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Paiments',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Licences',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Categories',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Articles',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Options',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Choices',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Offers',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Users',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Commandes',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Dashboards',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Add_Prolongations',
            'guard_name' => 'web',
            'type' => 'create',
        ]);
        Permission::factory()->create([
            'name' =>  'Staffs',
            'guard_name' => 'web',
            'type' => 'create',
        ]);
        Permission::factory()->create([
            'name' =>  'Shops',
            'guard_name' => 'web',
            'type' => 'create',
        ]);
        Permission::factory()->create([
            'name' =>  'GeneralSettings',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Types',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'Demmands',
            'guard_name' => 'web'
        ]);
        Permission::factory()->create([
            'name' =>  'ClientsDemmands',
            'guard_name' => 'web'
        ]);

        // Create default hotel
        Hotel::factory()->create([
            'name' =>  'Default',
            'country' =>  'Morocco',
            'city' =>  'Marrakech',
            'address' =>  'Nakhil',
            'status' =>  'Test'

        ]);

        // Create super admin
        User::factory()->create([
            'name' =>  'Yassine',
            'firstname' =>  'fname',
            'lastname' =>  'lname',
            'email' =>  'sec-super@gmail.com',
            'password' =>  bcrypt('azertyuiop'),
            'social_id' =>  "",
            'hotel_id' => 1

        ]);

        // Give the role super admin
        ModelHasRole::factory()->create([
            'role_id' => 1,
            'model_type' => "App\Models\User",
            'model_id' => 1
        ]);

        // Add permission to super admin user
        ModelHasPermission::factory()->create([
            'permission_id' => 1,
            'model_type' => "App\Models\User",
            'model_id' => 1
        ]);
        ModelHasPermission::factory()->create([
            'permission_id' => 2,
            'model_type' => "App\Models\User",
            'model_id' => 1
        ]);
        ModelHasPermission::factory()->create([
            'permission_id' => 11,
            'model_type' => "App\Models\User",
            'model_id' => 1
        ]);
        ModelHasPermission::factory()->create([
            'permission_id' => 5,
            'model_type' => "App\Models\User",
            'model_id' => 1
        ]);
        ModelHasPermission::factory()->create([
            'permission_id' => 13,
            'model_type' => "App\Models\User",
            'model_id' => 1
        ]);

        // Default licence
        DefaultLicence::factory()->create([
            'days' => 7,
        ]);

        // Create Types
        /* Type::factory()->create([
            'hotel_id' => 2,
            'name' =>  'Room Service',
            'gold_img' =>  'types/roomservicegoldimage.png',
            'purple_img' =>  'types/roomservicepurpleimage.png',
        ]);
        Type::factory()->create([
            'hotel_id' => 2,
            'name' =>  'La Terrasse Restaurant',
            'gold_img' =>  'types/terrasserestaurantgoldimage.png',
            'purple_img' =>  'types/terrasserestaurantpurpleimage.png',
        ]);
        Type::factory()->create([
            'hotel_id' => 2,
            'name' =>  'Spa & Wellness',
            'gold_img' =>  'types/spawellnessgoldimage.png',
            'purple_img' =>  'types/roomservicepurpleimage.png',
        ]);
        Type::factory()->create([
            'hotel_id' => 2,
            'name' =>  'Promotion',
            'gold_img' =>  'types/promotiongoldimage.png',
            'purple_img' =>  'types/promotionpurpleimage.png',
        ]); */
    }
}

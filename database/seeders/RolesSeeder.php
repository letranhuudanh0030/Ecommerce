<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function PHPSTORM_META\map;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'Super Admin']);

        User::find(1)->assignRole($superAdmin);

        $editor = Role::create(['name' => 'Editor']);

        User::find(2)->assignRole($editor);

        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
    }

    private function roles():array {
        return [
            "Super Admin",
            "Content Writer"
        ];
    }
}

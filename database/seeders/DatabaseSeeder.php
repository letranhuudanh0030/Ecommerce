<?php

namespace Database\Seeders;

use App\Models\User;
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
        \App\Models\User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'name' => 'Super Admin',
        ]);

        User::factory()->create([
            'email' => 'editor@editor.com',
            'password' => bcrypt('password'),
            'name' => 'Editor',
        ]);

        $this->call(RolesSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = json_decode(file_get_contents(storage_path('app/data/roles.json')), true);
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

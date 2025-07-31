<?php

namespace Database\Seeders;

use App\Http\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RoleEnum::values();
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}

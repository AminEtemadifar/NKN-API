<?php

namespace Database\Seeders;

use App\Http\Enums\RoleEnum;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'firstname' => 'ادمین',
            'lastname' => 'برنامه نویس',
            'phone' => '09012959494',
            'email' => "admin@admin.com",
            'password' => Hash::make('mifadev'),
        ]);
        $user->assignRole(RoleEnum::FULL_ADMIN);

    }
}

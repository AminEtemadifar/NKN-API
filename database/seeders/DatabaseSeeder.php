<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new RoleSeeder())->run();
        (new UserSeeder())->run();
        (new SliderSeeder)->run();
        (new SlideSeeder())->run();
        (new TaxonomySeeder())->run();
        (new TermSeeder())->run();
        (new DoctorSeeder())->run();
    }
}

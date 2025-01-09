<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hospitals = json_decode(file_get_contents(storage_path('app/data/hospitals.json')), true);
        foreach ($hospitals as $hospitalItem) {

            $hospital = Hospital::query()->create([
                'name' => $hospitalItem['name'],
                'address' => $hospitalItem['address'],
                'fax' => $hospitalItem['fax'],
                'email' => $hospitalItem['email'],
                'address_link' => $hospitalItem['address_link'],
            ]);

            $imagePath = public_path($hospitalItem['image']);
            if (file_exists($imagePath)) {
                $hospital->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('image');
            }
            $imagePath = public_path($hospitalItem['thumbnail']);
            if (file_exists($imagePath)) {
                $hospital->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('thumbnail');
            }
            $imagePath = public_path($hospitalItem['main_thumbnail']);
            if (file_exists($imagePath)) {
                $hospital->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('main_thumbnail');
            }
        }
    }
}

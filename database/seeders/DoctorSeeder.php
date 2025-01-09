<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = json_decode(file_get_contents(storage_path('app/data/doctors.json')), true);
        foreach ($doctors as $doctorItem) {
            $terms = $doctorItem['terms'];
            $portfolio = $doctorItem['portfolio'];
            $image = $doctorItem['image'];

            $doctor = Doctor::query()->create([
                'first_name' => $doctorItem['first_name'],
                'last_name' => $doctorItem['last_name'],
                'code' => $doctorItem['code'],
                'sub_title' => $doctorItem['sub_title'],
                'short_description' => $doctorItem['short_description'],
                'redirect' => $doctorItem['redirect'],
                'description' => $doctorItem['description'],
                'gender' => $doctorItem['gender'],
                'hospital_id' => $doctorItem['hospital_id'],
            ]);
            //$doctorItem['user_id'] = User::whereRole()->first();
            // TODO control user id for doctors
            foreach ($terms as $term) {
                $taxonomy = Taxonomy::query()->where('key', $term['taxonomy_key'])->first();
                unset($term['taxonomy_key']);
                $term = $taxonomy->terms()->create($term);
                $doctor->terms()->attach($term->id);
            }

            $imagePath = public_path($image);
            if (file_exists($imagePath)) {
                $doctor->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('image');
            }
            foreach ($portfolio as $portfolioItem) {
                $portfolioPath = public_path($portfolioItem);
                if (file_exists($portfolioPath)) {
                    $doctor->addMedia($portfolioPath)
                        ->preservingOriginal()
                        ->toMediaCollection('portfolio');
                }
            }

        }
    }
}

<?php

namespace Database\Seeders;

use App\Http\Enums\RoleEnum;
use App\Models\Blog;
use App\Models\Doctor;
use App\Models\Taxonomy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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


            $user = User::query()->create([
                'firstname' => $doctorItem['first_name'],
                'lastname' => $doctorItem['last_name'],
                'phone' => '091000000' . rand(0, 99),
                'email' => "admin" . rand(0, 500) . "@admin.com",
                'password' => Hash::make('mifadev'),
            ]);
            $user->assignRole(RoleEnum::DOC);
            $doctor->user_id = $user->id;
            $doctor->save();

            $blogs = json_decode(file_get_contents(storage_path('app/data/blogs.json')), true);
            for ($i = 0; $i < 4; $i++) {
                $randomBlogKey = array_rand($blogs);
                $randomBlog = $blogs[$randomBlogKey];
                $randomBlogImage = $randomBlog['image'];
                unset($randomBlog['image']);
                $blog = $user->blogs()->create($randomBlog);
                /** @var Blog $blog */
                $blog->addMediaFromUrl($randomBlogImage)
                    ->preservingOriginal()
                    ->toMediaCollection('main_image');
            }
        }
    }
}

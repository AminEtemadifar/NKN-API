<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = json_decode(file_get_contents(storage_path('app/data/sliders.json')), true);

        foreach ($sliders as $sliderData) {
            $thumbnails = $sliderData['thumbnails'];
            unset($sliderData['thumbnails'], $sliderData['slides']);

            $slider = Slider::create($sliderData);

            // Add the thumbnail to the slider
            foreach ($thumbnails as $thumbnail) {
                $thumbnailPath = public_path($thumbnail);
                if (file_exists($thumbnailPath)) {
                    $slider->addMedia($thumbnailPath)
                        ->preservingOriginal()
                        ->toMediaCollection('thumbnails');
                }
            }
        }
    }
}

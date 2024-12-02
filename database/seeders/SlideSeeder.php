<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sliders = json_decode(file_get_contents(storage_path('app/data/sliders.json')), true);
        foreach ($sliders as $slider) {
            $slides = $slider['slides'];
            $slider = Slider::where('key', $slider['key'])->first();

            foreach ($slides as $slide) {
                $image = $slide['image'];
                if (!empty($slide['button']))
                    $slide['extra_data']['button'] = $slide['button'];
                unset($slide['image'], $slide['button']);
                $slide = $slider->slides()->create($slide);
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    $slide->addMedia($imagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
            }

        }


    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Enums\SliderKeyEnum;
use App\Http\Resources\HomeResource;
use App\Models\Blog;
use App\Models\Hospital;
use App\Models\Slider;
use App\Models\Taxonomy;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/home",
     *     tags={"Home"},
     *     summary="home",
     *     description="home data",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Property(property="data",ref="#/components/schemas/HomeResource")
     *      ),
     *
     * )
     */
    public function index()
    {
        $sliders = Slider::query()->with('slides')->whereIn('key', [
            SliderKeyEnum::MAIN_SLIDER->value,
            SliderKeyEnum::SECTION_TWO->value,
            SliderKeyEnum::SECTION_THREE->value,
        ])->get();

        $taxonomy = Taxonomy::query()->where('key', '=', 'expertise')->first();
        $terms = !empty($taxonomy) ? $taxonomy->terms()->where('is_main', true)->get() : [];
        $hospitals = Hospital::query()->get();
        $news = Blog::query()->news()->published()->orderByDesc('published_at')->limit(7)->get();
        $data = (object)[
            'sliders' => $sliders,
            'main_terms' => $terms,
            'footer_terms' => $terms,
            'hospitals' => $hospitals,
            'news' => $news,
            'blogs' => Blog::limit(5)->orderBy('created_at')->get(),
        ];

        return HomeResource::make($data);
    }

}

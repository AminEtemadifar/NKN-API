<?php

namespace App\Http\Controllers;

use App\Http\Enums\SliderKeyEnum;
use App\Http\Resources\BlogResource;
use App\Http\Resources\HomeResource;
use App\Models\Blog;
use App\Models\Hospital;
use App\Models\Slider;
use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *      path="/home",
     *      tags={"Home"},
     *      summary="home",
     *      description="home data",
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
        $data = (object) [
            'sliders' => $sliders,
            'main_terms' => $terms,
            'footer_terms' => $terms,
            'hospitals' => $hospitals,
            'blogs' => Blog::limit(5)->orderBy('created_at')->get(),
        ];

        return HomeResource::make($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

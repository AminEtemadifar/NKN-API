<?php

namespace App\Http\Controllers;

use App\Http\Enums\SliderKeyEnum;
use App\Http\Resources\SliderResource;
use App\Http\Resources\TermResource;
use App\Models\Slider;
use App\Models\Taxonomy;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HomeController extends Controller
{
    /**
     * @OA\Post(
     *      path="/home",
     *      tags={"Home"},
     *      summary="home",
     *      description="home data",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Property(property="data",ref="#/components/schemas/SliderResource"),
     *         @OA\Property(property="data",ref="#/components/schemas/TermResource")
     *      ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
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

        return ResourceCollection::collection(['slides' => SliderResource::collection($sliders), 'terms' => TermResource::collection($terms)]);
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

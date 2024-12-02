<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sliders",
     *     summary="Retrieve a list of sliders",
     *     description="get all sliders from the database as slider resource",
     *     tags={"Sliders"},
     *     @OA\Response(
     *         response=200,
     *         description="List of sliders retrieved successfully",
     *     ),
     *
     * )
     */
    public function index(): ResourceCollection
    {
        $sliders = Slider::orderBy('ordering')->get();
        return SliderResource::collection($sliders);
    }


    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return SliderResource::make($slider);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $data = $request->validated();
        $slider->update($data);
        if ($request->has('thumbnails')) {
            foreach ($request->file('thumbnails') as $thumbnail) {
                if ($thumbnail) {
                    $slider->clearMediaCollection('thumbnails');
                    $slider->addMedia($thumbnail)
                        ->toMediaCollection('thumbnails');
                }
            }
        }
        return SliderResource::make($slider);

    }
}

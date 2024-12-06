<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Http\Resources\SlideResource;
use App\Models\Slide;
use App\Models\Slider;

class SlideController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSlideRequest $request)
    {
        $data = $request->validated();
        if (!empty($data['button'])) {
            $data['extra_data']['button'] = $data['button'];
        }
        $slider = Slider::find($data['slider_id']);
        $slide = $slider->slides()->create($data);

        $slide->clearMediaCollection('image');
        $slide->addMediaFromRequest('image')
            ->toMediaCollection('image');


        return SlideResource::make($slide);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slide $slide)
    {
        return SlideResource::make($slide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSlideRequest $request, Slide $slide)
    {
        $data = $request->validated();
        $data['extra_data'] = null;
        if (!empty($data['button'])) {
            $data['extra_data']['button'] = $data['button'];
        }

        $slide->update($data);

        if ($request->has('image')) {
            $slide->clearMediaCollection('image');
            $slide->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return SlideResource::make($slide);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slide $slide)
    {
        return $slide->delete();
    }
}

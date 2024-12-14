<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSliderRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slide;
use App\Models\Slider;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sliders",
     *     summary="Retrieve a list of sliders",
     *     description="get all sliders from the database as slider resource",
     *     tags={"Sliders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of sliders retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SliderResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      )
     * )
     */
    public function index(): ResourceCollection
    {
        $sliders = Slider::with('slides')->get();
        return SliderResource::collection($sliders);
    }


    /**
     * @OA\Get(
     *      path="/sliders/{id}",
     *      tags={"Sliders"},
     *      summary="Get Slider information",
     *      description="Returns Slider data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Slider id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/SliderResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Slider $slider)
    {
        $slider = Slider::with('slides')->find($slider->id);
        return SliderResource::make($slider);
    }

    /**
     * @OA\Put(
     *      path="/sliders/{id}",
     *      tags={"Sliders"},
     *      summary="Update existing Slider",
     *      description="Returns updated Slider data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Slider id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="slider name",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Parameter(
     *           name="description",
     *           in="query",
     *           description="slider description",
     *           required=false,
     *           @OA\Schema(type="string")
     *       ),
     *     @OA\Parameter(
     *            name="thumbnails",
     *            in="query",
     *            description="slider thumbnails",
     *            required=false,
     *            @OA\Schema(
     *                  type="array",
     *                  @OA\Items(
     *                      type="file",
     *                  )
     *            ),
     *        ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateSliderRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/SliderResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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

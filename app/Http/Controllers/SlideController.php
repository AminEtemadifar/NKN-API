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
     * @OA\Post(
     *      path="/slides",
     *      tags={"Slides"},
     *      summary="Store new Slide",
     *      description="Returns created Slide data",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/StoreSlideResourceRequest")
     *           ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SlideResource")
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
     * @OA\Get(
     *      path="/slides/{id}",
     *      tags={"Slides"},
     *      summary="Get Slide information",
     *      description="Returns Slide data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Slide id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/SlideResource")
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
    public function show(Slide $slide)
    {
        return SlideResource::make($slide);
    }

    /**
     * @OA\Put(
     *      path="/slides/{id}",
     *      tags={"Slides"},
     *      summary="Update existing Slide",
     *      description="Returns updated Slide data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Slide id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UpdateSlideResourceRequest")
     *          ),
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/UpdateSlideResourceRequest")
     *          ),
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateSlideResourceRequest")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SlideResource")
     *      ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UpdateSlideRequest $request, Slide $slide)
    {
        $data = $request->validated();
        $data['extra_data'] = null;
        if (!empty($data['button'])) {
            $data['extra_data']['button'] = $data['button'][0];
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
     * @OA\Delete(
     *      path="/slides/{id}",
     *      tags={"Slides"},
     *      summary="Delete Slide record",
     *      description="Returns delete status",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Slide id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
    public function destroy(Slide $slide)
    {
        return (bool)$slide->delete();
    }
}

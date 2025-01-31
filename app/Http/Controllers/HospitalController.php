<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;

class HospitalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/hospitals",
     *     summary="Retrieve a list of hospitals",
     *     description="get all hospitals from the database as hospital resource",
     *     tags={"Hospitals"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of hospitals retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/HospitalResource")
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
    public function index()
    {
        $items = Hospital::all();
        return HospitalResource::collection($items);
    }

    /**
     * @OA\Post(
     *      path="/hospitals",
     *      tags={"Hospitals"},
     *      summary="Store new Hospital",
     *      description="Returns created Hospital data",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/StoreHospitalResourceRequest")
     *           ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/HospitalResource")
     *      ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     * )
     */
    public function store(StoreHospitalRequest $request)
    {
        $data = $request->validated();
        $hospital = Hospital::query()->create($data);
        if ($request->has('main_thumbnail')) {
            $hospital->clearMediaCollection('main_thumbnail');
            $hospital->addMediaFromRequest('main_thumbnail')
                ->toMediaCollection('main_thumbnail');
        }
        if ($request->has('image')) {
            $hospital->clearMediaCollection('image');
            $hospital->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }
        if ($request->has('thumbnail')) {
            $hospital->clearMediaCollection('thumbnail');
            $hospital->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnail');
        }
        return HospitalResource::make($hospital);
    }

    /**
     * @OA\Get(
     *      path="/hospitals/{id}",
     *      tags={"Hospitals"},
     *      summary="Get hospital information",
     *      description="Returns hospital data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="hospital id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/HospitalResource")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
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
    public function show(Hospital $hospital)
    {
        return HospitalResource::make($hospital);
    }

    /**
     * @OA\Put(
     *      path="/hospitals/{id}",
     *      tags={"Hospitals"},
     *      summary="Update existing hospital",
     *      description="Returns updated hospital data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="hospital id",
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
     *              @OA\Schema(ref="#/components/schemas/UpdateHospitalResourceRequest")
     *          ),
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/UpdateHospitalResourceRequest")
     *          ),
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateHospitalResourceRequest")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateHospitalResourceRequest")
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
    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        $data = $request->validated();
        $hospital->update($data);
        return HospitalResource::make($hospital);
    }

    /**
     * @OA\Delete(
     *      path="/hospitals/{id}",
     *      tags={"Hospitals"},
     *      summary="Delete hospital record",
     *      description="Returns delete status",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="hospital id",
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
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *       @OA\Response(
     *           response=404,
     *           description="Resource Not Found"
     *       )
     * )
     */
    public function destroy(Hospital $hospital)
    {
        return $hospital->delete();
    }
}

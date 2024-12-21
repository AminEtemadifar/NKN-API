<?php

namespace App\Http\Controllers;

use App\Http\Enums\GenderEnum;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DoctorController extends Controller
{
    /**
     * @OA\Get(
     *      path="/doctors",
     *      tags={"doctors"},
     *      summary="Get list of doctors",
     *      description="Retrieve filtered data for doctors",
     *      @OA\Parameter(
     *          name="filter[search]",
     *          description="search in data of doctors",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          ),
     *     ),
     *     @OA\Parameter(
     *          name="filter[gender]",
     *          description="filter doctrs by gender (male or female) example:male",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter[terms]",
     *          description="get id of terms and explode by , example:26,25",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\Property(property="data", ref="#/components/schemas/DoctorResource")
     *      ),
     * )
     */

    public function index()
    {
        //TODO sort by hospital
        $doctors = QueryBuilder::for(Doctor::class)
            ->allowedFilters([
                AllowedFilter::callback('gender',
                    fn(Builder $query, string $value) => $value == 'female' ? $query->where('gender', GenderEnum::FEMALE->value) :
                        ($value == 'male' ? $query->where('gender', GenderEnum::MALE->value) : null)),
                AllowedFilter::partial('terms', 'terms.id'),
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    $query->where('first_name', 'like', '%' . $value . '%');
                    $query->orWhere('last_name', 'like', '%' . $value . '%');
                    $query->orWhere('code', 'like', '%' . $value . '%');
                    $query->orWhere('sub_title', 'like', '%' . $value . '%');
                    $query->orWhere('short_description', 'like', '%' . $value . '%');
                }),
            ])->get();
        return DoctorResource::collection($doctors);
    }

    /**
     * @OA\Get(
     *      path="/doctors/{id}",
     *      tags={"doctors"},
     *      summary="Get doctor information",
     *      description="Returns doctor data",
     *      @OA\Parameter(
     *          name="id",
     *          description="doctor id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/DoctorResource")
     *       )
     * )
     */
    public function store(StoreDoctorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return DoctorResource::make($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Enums\GenderEnum;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\RecordNameResource;
use App\Http\Resources\TaxonomyResource;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Taxonomy;
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
     *          description="filter doctrs by terms and explode by , example:26,25",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter[hospital]",
     *          description="filter doctrs by hospital_id",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\Property(property="data", ref="#/components/schemas/DoctorResource"),
     *          @OA\Property(property="taxonomies", ref="#/components/schemas/TaxonomyResource"),
     *          @OA\Property(property="links", ref="#/components/schemas/LinksPaginationResource"),
     *          @OA\Property(property="meta", ref="#/components/schemas/MetaPaginationResource"),
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
                AllowedFilter::exact('hospital', 'hospital_id'),
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    $query->where('first_name', 'like', '%' . $value . '%');
                    $query->orWhere('last_name', 'like', '%' . $value . '%');
                    $query->orWhere('code', 'like', '%' . $value . '%');
                    $query->orWhere('sub_title', 'like', '%' . $value . '%');
                    $query->orWhere('short_description', 'like', '%' . $value . '%');
                }),
            ])->paginate(request()->per_page);

        $taxonomies = Taxonomy::with([
            'terms' => fn($terms) => $terms->filterable()
        ])->get();

        $hospitals = Hospital::query()->select('id', 'name')->get();

        return DoctorResource::collection($doctors)
            ->additional([
                'taxonomies' => TaxonomyResource::collection($taxonomies),
                'hospitals' => RecordNameResource::collection($hospitals),
            ]);
    }

    /**
     * @OA\Post(
     *      path="/doctors",
     *      tags={"doctors"},
     *      summary="Create a new doctor",
     *      description="Store a new doctor in the database",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreDoctorRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Doctor created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/DoctorResource")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::query()->create($data);

        if ($request->has('main_image')) {
            $doctor->clearMediaCollection('image');
            $doctor->addMediaFromRequest('main_image')
                ->toMediaCollection('image');

        }

        if ($request->has('portfolio')) {
            $doctor->clearMediaCollection('portfolio');
            foreach ($request->file('portfolio') as $item) {
                if ($item) {
                    $doctor->addMedia($item)
                        ->toMediaCollection('portfolio');
                }
            }
        }
        if ($request->has('terms')) {
            $doctor->terms()->sync($data['terms']);
        }
        return new DoctorResource($doctor);
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

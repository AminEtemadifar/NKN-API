<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="DoctorResource",
     *     title="DoctorResource",
     *     type="object",
     *     description="Doctor resource",
     *     required={"id","last_name","first_name","full_name","code","sub_title","short_description","redirect","gender","terms","image"},
     *     @OA\Xml(
     *          name="DoctorResource"
     *      ),
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="id of the doctor"
     *     ),
     *     @OA\Property(
     *         property="first_name",
     *         type="string",
     *         description="first name of the doctor"
     *     ),
     *     @OA\Property(
     *         property="code",
     *         type="string",
     *         description="code number of the doctor"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         description="last name of the doctor"
     *     ),
     *     @OA\Property(
     *         property="full_name",
     *         type="string",
     *         description="full name of the doctor"
     *     ),
     *     @OA\Property(
     *         property="sub_title",
     *         type="string",
     *         description="sub title of the doctor"
     *     ),
     *     @OA\Property(
     *         property="short_description",
     *         type="string",
     *         description="short description url of the doctor"
     *      ),
     *     @OA\Property(
     *         property="redirect",
     *         type="string",
     *         description="redirect link of the doctor"
     *     ),
     *     @OA\Property(
     *         property="gender",
     *         type="string",
     *         description="gender of doctor"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="description of doctor"
     *     ),
     *     @OA\Property(
     *          property="image",
     *          type="object",
     *          ref="#/components/schemas/FileResource",
     *          description="The image associated with the doctor"
     *      ),
     *     @OA\Property(
     *          property="portfolio",
     *          type="array",
     *          description="portfolio of doctor",
     *          @OA\Items(ref="#/components/schemas/FileResource")
     *      ),
     *     @OA\Property(
     *          property="terms",
     *          type="array",
     *          description="categories item of doctor",
     *          @OA\Items(ref="#/components/schemas/TermResource")
     *      ),
     *     @OA\Property(
     *          property="hospital",
     *          type="array",
     *          description="hospital of doctor",
     *          @OA\Items(ref="#/components/schemas/HospitalResource")
     *      )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "full_name" => $this->full_name,
            "code" => $this->code,
            "sub_title" => $this->sub_title,
            "short_description" => $this->short_description,
            "redirect" => $this->redirect,
            "image" => FileResource::make($this->getFirstMedia('image') ?? $this->getDefaultMedia()),
            "terms" => TermResource::collection($this->terms),
            "description" => $this->description,
            "portfolio" => FileResource::collection($this->getMedia('portfolio')),
            "gender" => $this->gender,
            "hospital" => HospitalResource::make($this->hospital),
        ];
    }
}

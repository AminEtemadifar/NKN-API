<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="HospitalResource",
     *     type="object",
     *     required={"name","id", "fax", "email", "image", "main_thumbnail", "thumbnail"},
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="The name of the hospital"
     *     ),
     *     @OA\Property(
     *         property="fax",
     *         type="string",
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *     ),
     *     @OA\Property(
     *         property="address_link",
     *         type="string",
     *     ),
     *     @OA\Property(
     *         property="website_link",
     *         type="string",
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="uri",
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="object",
     *         ref="#/components/schemas/FileResource",
     *         description="The image associated with the hospital"
     *     ),
     *     @OA\Property(
     *         property="main_thumbnail",
     *         type="object",
     *         ref="#/components/schemas/FileResource",
     *         description="The image associated with the hospital and show in main page"
     *     ),
     *     @OA\Property(
     *         property="thumbnail",
     *         type="object",
     *         ref="#/components/schemas/FileResource",
     *         description="The thumbnail associated with the hospital"
     *     ),
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'fax' => $this->fax,
            'address_link' => $this->address_link,
            'email' => $this->email,
            'website_link' => $this->website_link,
            'thumbnail' => FileResource::make($this->getFirstMedia('thumbnail')),
            'main_thumbnail' => FileResource::make($this->getFirstMedia('main_thumbnail')),
            'image' => FileResource::make($this->getFirstMedia('image')),
        ];
    }
}

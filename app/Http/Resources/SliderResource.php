<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="SliderResource",
     *     title="SliderResource",
     *     type="object",
     *     description="Slider resource",
     *     required={"id"},
     *     @OA\Xml(
     *          name="SliderResource"
     *      ),
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the slider"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="name of the slider"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="description of the slider"
     *     ),
     *     @OA\Property(
     *         property="key",
     *         type="string",
     *         description="key of the slider"
     *      ),
     *     @OA\Property(
     *         property="thumbnails",
     *         type="array",
     *         description="URL of the slider image",
     *         @OA\Items(ref="#/components/schemas/FileResource")
     *     ),
     *     @OA\Property(
     *         property="slides",
     *         type="array",
     *         description="List of slides of slider",
     *         @OA\Items(ref="#/components/schemas/SlideResource")
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'key' => $this->key,
            'thumbnails' => FileResource::collection($this->getMedia('thumbnails')),
            'slides' => $this->whenLoaded('slides', function () {
                return SlideResource::collection($this->slides);
            })
        ];
    }
}

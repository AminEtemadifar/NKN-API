<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Slider",
     *     type="object",
     *     title="Slider",
     *     description="Slider resource",
     *     required={"id", "title", "image_url"},
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the slider"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="Title of the slider"
     *     ),
     *     @OA\Property(
     *         property="image_url",
     *         type="string",
     *         format="url",
     *         description="URL of the slider image"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
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

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="SlideResource",
     *     type="object",
     *     required={"title", "description", "link", "image"},
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="The title of the slide"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="The title of the slide"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="A brief description of the slide"
     *     ),
     *     @OA\Property(
     *         property="link",
     *         type="string",
     *         format="uri",
     *         description="The link associated with the slide"
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="object",
     *         ref="#/components/schemas/FileResource",
     *         description="The image associated with the slide"
     *     ),
     *     @OA\Property(
     *         property="button",
     *         type="object",
     *         description="The button data for the slide, if available",
     *         @OA\Property(
     *             property="title",
     *             type="string",
     *             description="The title of the button"
     *         ),
     *         @OA\Property(
     *             property="link",
     *             type="string",
     *             format="uri",
     *             description="The link of the button"
     *         )
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
            'image' => FileResource::make($this->getFirstMedia('image')),
            'button' => $this->when(!empty($this->extra_data) && !empty($this->extra_data->button), function () {
                return $this->extra_data->button;
            })
        ];
    }
}

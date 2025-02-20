<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="BlogResource",
     *     type="object",
     *     title="Blog Resource",
     *     description="Blog resource representation",
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="The title of the blog"
     *     ),
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="The id of the blog"
     *     ),
     *     @OA\Property(
     *         property="sub_title",
     *         type="string",
     *         description="The subtitle of the blog"
     *     ),
     *     @OA\Property(
     *         property="slug",
     *         type="string",
     *         description="The slug of the blog"
     *     ),
     *     @OA\Property(
     *         property="duration",
     *         type="integer",
     *         description="The duration of the blog"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         description="The creation date of the blog"
     *     ),
     *     @OA\Property(
     *         property="published_at",
     *         type="string",
     *         format="date-time",
     *         description="The publish date of the blog"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the blog"
     *     ),
     *     @OA\Property(
     *         property="main_image",
     *         type="array",
     *         description="The main image of the blog",
     *         @OA\Items(ref="#/components/schemas/FileResource")
     *     ),
     *     @OA\Property(
     *         property="user",
     *         type="object",
     *         description="The doctor associated with the blog",
     *         ref="#/components/schemas/UserResource"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'sub_title' => $this->sub_title,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'published_at' => $this->published_at,
            'description' => $this->whenLoaded('description', function () {
                return $this->description;
            }),
            'main_image' => FileResource::collection($this->getMedia('main_image')),
            'user' => new UserResource($this->user)
        ];
    }
}

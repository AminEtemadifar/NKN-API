<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /** @OA\Schema(
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
     *         property="sub_title",
     *         type="string",
     *         description="The subtitle of the blog"
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
     *         property="description",
     *         type="string",
     *         description="The description of the blog"
     *     ),
     *     @OA\Property(
     *         property="doctor",
     *         type="object",
     *         description="The doctor associated with the blog",
     *         ref="#/components/schemas/DoctorResource"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'doctor' => $this->whenLoaded('doctor', function () {
                return new DoctorResource($this->doctor);
            })
        ];
    }
}

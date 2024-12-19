<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="TermResource",
     *     title="TermResource",
     *     type="object",
     *     description="Term resource",
     *     required={"id"},
     *     @OA\Xml(
     *          name="TermResource"
     *      ),
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the category item"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="title of the category item"
     *     ),
     *     @OA\Property(
     *         property="slug",
     *         type="string",
     *         description="slug of the category item"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
        ];
    }
}

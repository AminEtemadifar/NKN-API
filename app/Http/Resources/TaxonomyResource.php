<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxonomyResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="TaxonomyResource",
     *     title="TaxonomyResource",
     *     type="object",
     *     description="Taxonomy resource",
     *     required={"title","key"},
     *     @OA\Xml(
     *          name="TaxonomyResource"
     *      ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="title of Taxonomy"
     *     ),
     *     @OA\Property(
     *         property="key",
     *         type="string",
     *         description="key of Taxonomy"
     *     ),
     *     @OA\Property(
     *         property="terms",
     *         type="array",
     *         description="categories item of doctor",
     *         @OA\Items(ref="#/components/schemas/TermResource")
     *      )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'key' => $this->key,
            'terms' => $this->whenLoaded('terms', function () {
                return TermResource::collection($this->terms);
            }),
        ];
    }
}

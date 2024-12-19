<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="HomeResource",
     *     title="HomeResource",
     *     type="object",
     *     description="HomeResource resource",
     *     required={"id"},
     *     @OA\Xml(
     *          name="HomeResource"
     *      ),
     *      @OA\Property(
     *          property="sliders",
     *          type="array",
     *          description="List of sliders of home page",
     *          @OA\Items(ref="#/components/schemas/SliderResource")
     *      ),
     *      @OA\Property(
     *          property="main_terms",
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/TermResource"),
     *          description="terms list of home page"
     *      ),
     *      @OA\Property(
     *          property="footer_terms",
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/TermResource"),
     *          description="terms list of home page"
     *      )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'sliders' => SliderResource::collection($this->resource->sliders),
            'main_terms' => TermResource::collection($this->resource->main_terms),
            'footer_terms' => TermResource::collection($this->resource->footer_terms),
        ];
    }
}

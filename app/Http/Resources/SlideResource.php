<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
            'image' => FileResource::make($this->getMedia('image')),
            'button' => $this->when(!empty($this->extra_data) && !empty($this->extra_data->button), function () {
                return $this->extra_data->button;
            })
        ];
    }
}

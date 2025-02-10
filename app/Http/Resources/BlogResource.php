<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'sub_title' => $this->sub_title,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'doctor' => $this->whenLoaded('doctor' , function (){
                return new DoctorResource($this->doctor);
            })
        ];
    }
}

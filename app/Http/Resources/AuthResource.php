<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fist_name' => $this->firstname,
            'last_name' => $this->lastnamename,
            'full_name' => $this->fullname,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}

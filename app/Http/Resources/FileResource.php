<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_name' => $this->file_name,
            'preview_url' => $this->preview_url,
            'original_url' => $this->original_url,
            'extension' => $this->extension,
            'size' => $this->size,
        ];
    }
}

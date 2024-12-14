<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="FileResource",
     *     title="FileResource",
     *     type="object",
     *     description="File resource",
     *     required={"id"},
     *     @OA\Xml(
     *          name="FileResource"
     *      ),
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the slider"
     *     ),
     *     @OA\Property(
     *         property="file_name",
     *         type="string",
     *         description="name of the file"
     *     ),
     *     @OA\Property(
     *         property="preview_url",
     *         type="string",
     *         format="uri",
     *         description="preview url of the File"
     *     ),
     *     @OA\Property(
     *         property="original_url",
     *         type="string",
     *         format="uri",
     *         description="original url of the File"
     *      ),
     *     @OA\Property(
     *         property="extension",
     *         type="string",
     *         description="extension of the File"
     *     ),
     *     @OA\Property(
     *         property="size",
     *         type="integer",
     *         description="size of extension"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'preview_url' => $this->preview_url,
            'original_url' => $this->original_url,
            'extension' => $this->extension,
            'size' => $this->size,
        ];
    }
}

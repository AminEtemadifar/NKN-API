<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTermRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="StoreTermResourceRequest",
     *     type="object",
     *     required={"title","taxonomy_id"},
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="title of category item"
     *     ),
     *     @OA\Property(
     *         property="taxonomy_id",
     *         type="integer",
     *         description="parent of category item"
     *     ),
     *     @OA\Property(
     *         property="slug",
     *         type="string",
     *         description="slug of category item"
     *     ),
     * )
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'taxonomy_id' => 'required|integer|exists:taxonomies,id',
        ];
    }
}

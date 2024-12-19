<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTermRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="UpdateTermResourceRequest",
     *     type="object",
     *     required={"password","email"},
     *     @OA\Property(
     *          property="title",
     *          type="string",
     *          description="title of category item"
     *      ),
     *      @OA\Property(
     *          property="taxonomy_id",
     *          type="integer",
     *          description="parent of category item"
     *      ),
     *      @OA\Property(
     *          property="slug",
     *          type="string",
     *          description="slug of category item"
     *      ),
     *     @OA\Property(
     *          property="is_main",
     *          type="boolean",
     *          description="category item show on client main page"
     *      ),
     *     @OA\Property(
     *          property="is_filter",
     *          type="boolean",
     *          description="category item show on client filter page"
     *      ),
     *     @OA\Property(
     *          property="is_footer",
     *          type="boolean",
     *          description="category item show on client footer"
     *      ),
     * )
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'taxonomy_id' => 'required|integer|exists:taxonomies,id',
            'is_main' => 'required|bool',
            'is_filter' => 'required|bool',
            'is_footer' => 'required|bool',
        ];
    }
}

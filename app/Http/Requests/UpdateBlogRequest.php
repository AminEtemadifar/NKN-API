<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="UpdateBlogRequest",
     *     type="object",
     *     title="Update Blog Request",
     *     description="Request body for updating a blog",
     *     required={"title", "description"},
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="Title of the blog"
     *     ),
     *     @OA\Property(
     *         property="sub_title",
     *         type="string",
     *         description="Subtitle of the blog",
     *         nullable=true
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="Description of the blog"
     *     ),
     *     @OA\Property(
     *         property="duration",
     *         type="integer",
     *         description="Duration of the blog",
     *         nullable=true
     *     ),
     *     @OA\Property(
     *         property="published",
     *         type="boolean",
     *         description="publish status of the blog default is false",
     *         nullable=true
     *     ),
     *     @OA\Property(
     *         property="main_image",
     *         type="string",
     *         format="binary",
     *         description="Main image of the blog",
     *         nullable=true
     *     )
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
            'sub_title'=> 'nullable|string',
            'published'=> 'nullable|boolean',
            'description' => 'required|string',
            'duration' => 'nullable|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'publish' => 'nullable|boolean',
        ];
    }
}

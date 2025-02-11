<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="StoreBlogRequest",
     *     type="object",
     *     title="Store Blog Request",
     *     description="Schema for storing a blog",
     *     required={"title", "description", "main_image"},
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="Title of the blog"
     *     ),
     *     @OA\Property(
     *         property="sub_title",
     *         type="string",
     *         nullable=true,
     *         description="Subtitle of the blog"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="Description of the blog"
     *     ),
     *     @OA\Property(
     *         property="duration",
     *         type="integer",
     *         nullable=true,
     *         description="Duration of the blog"
     *     ),
     *     @OA\Property(
     *         property="main_image",
     *         type="string",
     *         format="binary",
     *         description="Main image of the blog"
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
            'description' => 'required|string',
            'duration' => 'nullable|integer',
            'main_image' => 'required|image|mimes:jpeg,png,jpg`',
        ];
    }
}

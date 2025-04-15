<?php

namespace App\Http\Requests;

use App\Http\Enums\BlogTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     *         property="type",
     *         type="string",
     *         nullable=true,
     *         description="type of blog. values: blog,news,social_responsibilty . default: blog"
     *     ),
     *     @OA\Property(
     *         property="published",
     *         type="boolean",
     *         nullable=true,
     *         description="publish status of the blog ",
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
        if ($this->has('title')) {
            $this->merge(['slug'=> preg_replace('/\s+/', '_', $this->input('title'))]);
        }
        return [
            'title' => 'required|string',
            'slug' => 'required|string|unique:blogs,slug',
            'sub_title' => 'nullable|string',
            'published' => 'nullable|boolean',
            'description' => 'required|string',
            'duration' => 'nullable|integer',
            'main_image' => 'required|image|mimes:jpeg,png,jpg',
            'type' => 'nullable|string|' . Rule::In(BlogTypeEnum::values()),
        ];
    }
}

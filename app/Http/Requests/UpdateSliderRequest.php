<?php

namespace App\Http\Requests;

use App\Http\Enums\SliderKeyEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSliderRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *      schema="UpdateSliderResourceRequest",
     *      description="Update Slider request body data",
     *      type="object",
     * )
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'thumbnails' => 'array',
            'thumbnails.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ];
    }
}

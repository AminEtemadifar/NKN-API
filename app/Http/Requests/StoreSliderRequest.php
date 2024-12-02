<?php

namespace App\Http\Requests;

use App\Http\Enums\SliderKeyEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreSliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'name' => 'required|string',
            'thumbnails' => 'array',
            'thumbnails.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'ordering' => 'required|integer|unique:sliders,ordering',
            'key' => 'required|string|' . Rule::in(SliderKeyEnum::values()),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'thumbnails.array' => 'The thumbnails must be an array.',
            'thumbnails.*.image' => 'Each thumbnail must be an image.',
            'thumbnails.*.mimes' => 'Each thumbnail must be a jpeg, png, or jpg image.',
            'thumbnails.*.max' => 'Each thumbnail may not be greater than 2MB.',
            'description.string' => 'The description must be a string.',
            'ordering.integer' => 'The ordering must be an integer.',
            'key.required' => 'The key field is required.',
            'key.in' => 'The selected key is invalid.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }

}

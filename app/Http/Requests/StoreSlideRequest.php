<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSlideRequest extends FormRequest
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
            'title' => 'required|string',
            'slider_id' => 'required|exists:sliders,id|integer',
            'description' => 'nullable|string',
            'ordering' => 'required|integer',
            'link' => 'nullable|link',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button.*' => 'nullable|array',
            'button.title' => 'nullable|string',
            'button.link' => 'nullable|link',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="UpdateHospitalResourceRequest",
     *     type="object",
     *     required={"name", "fax"},
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="The name of the hospital"
     *     ),
     *     @OA\Property(
     *         property="fax",
     *         type="string",
     *         description="phone number of hospital"
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *     ),
     *     @OA\Property(
     *         property="address_link",
     *         type="string",
     *         format="uri",
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="string",
     *         format="binary",
     *         description="An image file for the hospital"
     *     ),
     *     @OA\Property(
     *         property="thumbnail",
     *         type="string",
     *         format="binary",
     *         description="thumbnail file for the hospital"
     *     ),
     *     @OA\Property(
     *         property="main_thumbnail",
     *         type="string",
     *         format="binary",
     *         description="main thumbnail file for the hospital"
     *     ),
     * )
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'address_link' => 'nullable|url|max:255',
            'fax' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'main_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}

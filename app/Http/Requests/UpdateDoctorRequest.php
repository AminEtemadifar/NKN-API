<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="UpdateDoctorRequest",
     *     type="object",
     *     required={"first_name", "last_name", "code", "redirect", "gender"},
     *     @OA\Property(property="first_name", type="string", example="John"),
     *     @OA\Property(property="last_name", type="string", example="Doe"),
     *     @OA\Property(property="code", type="string", example="DOC123"),
     *     @OA\Property(property="sub_title", type="string", example="MD"),
     *     @OA\Property(property="short_description", type="string", example="Experienced doctor"),
     *     @OA\Property(property="redirect", type="string", format="url", example="http://example.com"),
     *     @OA\Property(property="description", type="string", example="Detailed description"),
     *     @OA\Property(property="gender", type="string", enum={"male", "female"}, example="male"),
     *     @OA\Property(property="hospital_id", type="integer", example=1),
     *     @OA\Property(property="main_image", type="string", format="binary"),
     *     @OA\Property(property="terms", type="array", @OA\Items(type="integer")),
     *     @OA\Property(property="portfolio", type="array", @OA\Items(type="string", format="binary")),
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'code' => 'required|string',
            'sub_title' => 'nullable|string',
            'short_description' => 'nullable|string',
            'redirect' => 'required|url',
            'description' => 'nullable|string',
            'gender' => 'required|in:male,female',
            'hospital_id' => 'nullable|exists:hospitals,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'terms' => 'nullable|array',
            'terms.*' => 'nullable|integer|exists:terms,id',
            'portfolio' => 'nullable|array',
            'portfolio.*' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
        ];
    }
}

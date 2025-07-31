<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="UpdateAuthResourceRequest",
     *     type="object",
     *     required={"refresh_token"},
     *     @OA\Property(
     *         property="refresh_token",
     *         type="string",
     *         description="Refresh token for authentication"
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }
}

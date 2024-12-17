<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="StoreAuthResourceRequest",
     *     type="object",
     *     required={"password","email"},
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         description="email of user"
     *     ),
     *     @OA\Property(
     *         property="password",
     *         type="string",
     *         description="password of user"
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
    }
}

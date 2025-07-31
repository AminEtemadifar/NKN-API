<?php

namespace App\Http\Requests;

use App\Http\Enums\RoleEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

/**
 * @OA\Schema(
 *     schema="StoreUserRequest",
 *     title="Store User Request",
 *     description="Request body for creating a new user",
 *     type="object",
 *     required={"firstname", "lastname", "email", "phone", "password", "password_confirmation", "role_id"},
 *     @OA\Property(
 *         property="firstname",
 *         type="string",
 *         description="User's first name",
 *         example="John",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="lastname",
 *         type="string",
 *         description="User's last name",
 *         example="Doe",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="User's email address (must be unique)",
 *         example="john.doe@example.com",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="User's phone number (must be unique)",
 *         example="+1234567890",
 *         maxLength=20
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="User's password (minimum 8 characters)",
 *         example="password123",
 *         minLength=8
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         format="password",
 *         description="Password confirmation (must match password)",
 *         example="password123"
 *     ),
 *     @OA\Property(
 *         property="role_id",
 *         type="integer",
 *         description="ID of the role to assign to the user",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="doctor_id",
 *         type="integer",
 *         description="Doctor ID (required only when role is 'doc')",
 *         example=5,
 *         nullable=true
 *     )
 * )
 */
class StoreUserRequest extends FormRequest
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
        $rules = [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ];

        // If role is "doc", require doctor_id
        if ($this->has('role_id')) {
            $role = Role::find($this->input('role_id'));
            if ($role && $role->name === RoleEnum::DOC->value) {
                $rules['doctor_id'] = ['required', 'integer', 'exists:doctors,id', 'unique:doctors,user_id'];
            }
        }

        return $rules;
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'phone.unique' => 'This phone number is already registered.',
            'email.unique' => 'This email address is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            'role_id.required' => 'Role is required.',
            'role_id.exists' => 'The selected role is invalid.',
            'doctor_id.required' => 'Doctor ID is required when role is Doc.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'doctor_id.unique' => 'This doctor is already assigned to another user.',
        ];
    }
}

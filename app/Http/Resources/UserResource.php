<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="UserResource",
     *     title="UserResource",
     *     type="object",
     *     description="User resource",
     *     required={"id"},
     *     @OA\Xml(
     *          name="UserResource"
     *      ),
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the user"
     *     ),
     *     @OA\Property(
     *         property="first_name",
     *         type="string",
     *         description="name of the user"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         description="last name of the user"
     *     ),
     *     @OA\Property(
     *         property="full_name",
     *         type="string",
     *         description="full name of the user"
     *      ),
     *     @OA\Property(
     *         property="phone",
     *         type="string",
     *         description="phone number of the user",
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         description="email of the user"
     *     ),
     *     @OA\Property(
     *         property="role",
     *         type="array",
     *         description="list of role that associated with the user . list of role include : full_admin admin doc",
     *         @OA\Items(type="string")
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fist_name' => $this->firstname,
            'last_name' => $this->lastname,
            'full_name' => $this->firstname . ' ' . $this->lastname,
            'phone' => $this->phone,
            'email' => $this->email,
            'role' => $this->getRoleNames(),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="RoleResource",
     *     title="RoleResource",
     *     type="object",
     *     description="Role resource",
     *     required={"id", "name"},
     *     @OA\Xml(
     *          name="RoleResource"
     *      ),
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the role"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="Name of the role"
     *     ),
     *     @OA\Property(
     *         property="guard_name",
     *         type="string",
     *         description="Guard name of the role"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         description="Creation timestamp"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         description="Last update timestamp"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}

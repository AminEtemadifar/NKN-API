<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * @OA\Get(
     *      path="/roles",
     *      tags={"roles"},
     *      summary="Get list of roles",
     *      description="Retrieve all available roles in the system",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/RoleResource"))
     *          )
     *      )
     * )
     */
    public function index()
    {
        $roles = Role::all();
        
        return RoleResource::collection($roles);
    }
} 
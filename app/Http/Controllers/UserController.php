<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"users"},
     *      summary="Get list of users",
     *      description="Retrieve paginated and filtered list of users",
     *      @OA\Parameter(
     *          name="filter[search]",
     *          description="Search in first name, last name, email, or phone",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          description="Number of users per page",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="integer", default=15)
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="Page number",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="integer", default=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/UserResource")),
     *              @OA\Property(property="links", type="object"),
     *              @OA\Property(property="meta", type="object")
     *          )
     *      )
     * )
     */
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    $query->where('firstname', 'like', '%' . $value . '%')
                        ->orWhere('lastname', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->orWhere('phone', 'like', '%' . $value . '%');
                }),
            )
            ->defaultSorts('-created_at')
            ->paginate(request()->input('per_page', 15));

        return UserResource::collection($users);
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      tags={"users"},
     *      summary="Create a new user",
     *      description="Store a newly created user in storage",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                mediaType="multipart/form-data",
     *                @OA\Schema(ref="#/components/schemas/StoreUserRequest")
     *            ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", ref="#/components/schemas/UserResource")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object")
     *          )
     *      )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        // Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Extract role_id and doctor_id from validated data
        $roleId = $validatedData['role_id'];
        $doctorId = $validatedData['doctor_id'] ?? null;
        unset($validatedData['role_id'], $validatedData['doctor_id']);

        DB::beginTransaction();
        try {
            // Create the user
            $user = User::create($validatedData);

            // Find and assign role to user
            $role = Role::findById($roleId);
            $user->assignRole($role);

            // If role is 'doc' and doctor_id is provided, assign user to doctor
            if ($role->name === RoleEnum::DOC->value && $doctorId) {
                Doctor::where('id', $doctorId)->update(['user_id' => $user->id]);
            }

            DB::commit();

            return new UserResource($user->load('roles'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      tags={"users"},
     *      summary="Get user information",
     *      description="Returns user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", ref="#/components/schemas/UserResource")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     * )
     */
    public function show(User $user)
    {
        return new UserResource($user->load('roles'));
    }

    /**
     * @OA\Put(
     *      path="/users/{id}",
     *      tags={"users"},
     *      summary="Update existing user",
     *      description="Returns updated user data. Note: Role cannot be changed via update.",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                 mediaType="application/x-www-form-urlencoded",
     *                 @OA\Schema(ref="#/components/schemas/UpdateUserRequest")
     *           ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", ref="#/components/schemas/UserResource")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        // Hash password if provided
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        // Update user data (role handling removed)
        $user->update($validatedData);

        return new UserResource($user->fresh()->load('roles'));
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      tags={"users"},
     *      summary="Delete user",
     *      description="Deletes a user and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     * )
     */
    public function destroy(User $user)
    {
        $doc = Doctor::where('user_id', $user->id)->first();
        if (!empty($doc)) {
            $doc->user_id = null;
            $doc->save();
        }
        $user->delete();

        return response()->noContent();
    }
}

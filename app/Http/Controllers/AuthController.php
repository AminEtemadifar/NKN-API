<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\RefreshToken;

class AuthController extends Controller
{

    /**
     * @OA\Get(
     *     path="/auth",
     *     summary="Retrieve a loggend in user",
     *     description="Retrieve a loggend in user as user resource",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="user logged in retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      )
     * )
     */
    public function index()
    {
        $me = Auth::guard('api')->user();
        return UserResource::make($me);
    }
    /**
     * @OA\Post(
     *      path="/auth",
     *      tags={"Auth"},
     *      summary="login",
     *      description="loggend in user as User resource and token",
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(ref="#/components/schemas/StoreAuthResourceRequest")
     *           ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\Property(property="data",ref="#/components/schemas/UserResource"),
     *         @OA\Property(
     *            property="token",
     *            type="string",
     *            )
     *      ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     */
    public function store(StoreAuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('WebApp')->accessToken;
            return UserResource::make($user)->additional([
                'token' => $token,
            ]);
        } else {
            throw new UnauthorizedException();
        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthRequest $request, string $id)
    {
        $data = $request->validated();
        // Extract the refresh token from the request
        $refreshToken = $data['refresh_token'];

        // Attempt to retrieve the user using the refresh token
        // Here, we can use Laravel Passport's method to check the refresh token validity
        // Find the refresh token and return the associated user
        $refreshToken = RefreshToken::where('id', $refreshToken)->first();

        if ($refreshToken && $refreshToken->isExpired()) {
            return throw new UnauthorizedException();
        }

        $user = $refreshToken->accessToken->user;

        // Revoke the old refresh token if you plan on rotating it
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        // Generate a new access token
        $accessToken = $user->createToken('WebApp')->accessToken;

        // Optionally, generate a new refresh token (token rotation)
        $newRefreshToken = $user->createToken('WebApp')->accessToken;

        // Return the new access token and refresh token
        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $newRefreshToken,
        ]);
    }
    /**
     * @OA\Delete (
     *     path="/auth",
     *     summary="logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="user logout successfully",
     *         @OA\Property(
     *             type="bool",
     *             )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      )
     * )
     */
    public function destroy()
    {
        $me = Auth::user();
        return $me->token()->revoke();
    }
}

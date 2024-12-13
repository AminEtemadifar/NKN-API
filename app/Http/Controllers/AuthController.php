<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\RefreshToken;

class AuthController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function index()
    {
        $me = Auth::user();
        return AuthResource::make($me);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('WebApp')->accessToken;
            //$refreshToken = $user->createToken('WebApp', ['refresh'])->accessToken;
            return AuthResource::make($user)->additional([
                'token' => $token,
                //'refresh_token' => $refreshToken,
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
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $me = Auth::user();
        return $me->token()->revoke();
    }
}

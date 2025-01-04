<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|',
            'password' => 'required|string|min:8',
            'snow_resort_id' => 'required|exists:snow_resorts,id'
        ]);
        $existingUser = User::where('snow_resort_id', $request->snow_resort_id)->first();
        if ($existingUser) {
            return response()->json(['message' => 'User already exists with this snow resort ID'], 400);
        }
        $user = User::create([
            'id' => $request->snow_resort_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'snow_resort_id' => $request->snow_resort_id,
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Login user and create token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthenticationException
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $expirationMinutes = config('sanctum.expiration');
        $expiresAt = now()->addMinutes($expirationMinutes);
        $user->tokens->last()->forceFill([
            'expires_at' => $expiresAt,
        ])->save();
        $user->makeHidden('tokens');

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    /**
     * Logout user (Revoke the token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    /**
     * Register a new user and company with the application.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        $token = $user->createToken('api');

        return response()->json([
            'message' => 'Account created successfully.',
            'token' => $token->plainTextToken,
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->get('email'))->firstOrFail();

        abort_if(
            ! Hash::check($request->get('password'), $user->password),
            401,
            'Invalid credentials.'
        );

        $token = $user->createToken('api');

        return response()->json([
            'message' => 'You have successfully logged in.',
            'token' => $token->plainTextToken,
        ]);
    }
}

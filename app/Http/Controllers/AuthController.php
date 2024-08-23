<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register a new user in the system.
     *
     * @param \App\Http\Requests\RegisterRequest $request The incoming request containing user data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing a message and the newly created user, or an error message.
     *
     * @throws \Exception If there is an error during user creation, an exception will be thrown and a 500 response will be returned.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json(['message' => 'user created', 'user' => $newUser], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'User creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle user login and return a JWT token.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing user credentials.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the JWT token or an error message.
     *
     * @throws \Illuminate\Validation\ValidationException If the request data fails validation.
     * @throws \Tymon\JWTAuth\Exceptions\JWTException If there is an issue creating the JWT token.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation error', 'messages' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        return response()->json(['token' => $token]);
    }
}

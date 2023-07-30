<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('username', $request->input('username'))->first();
        if (!is_null($user)) {
            if (Hash::check($request->input('password'), $user->password)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully login',
                    'data' => $user
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials',
            'data' => []
        ], 401);
    }

    public function register()
    {

    }
}

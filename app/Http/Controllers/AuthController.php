<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerIfNotExisted(RegisterRequest $request)
    {
        if (!Auth::check()) {
            $signUpData = $request->validated();
            $user = User::create($signUpData);
            $apiToken = $user->createToken('apiToken')->plainTextToken;
            return response()->json([
                'Api token' => $apiToken,
                'message' => 'Registered successfully'
            ], 200);
        }
    }

    public function login(LoginRequest $request)
    {
        $request->validated();
        if ($user = User::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $user->password)) {
                $apiToken = $user->createToken('apiToken')->plainTextToken;
                Auth::login($user);
                return response()->json([
                    'Api token' => $apiToken,
                    'message' => 'Welcome , login was done Successfully',
                ]);
            } else {
                return response()->json([
                    'message' => 'Credinials are wrong , try again',
                ]);
            }
        } else {
            return response()->json([
                'message' => 'email doesnt exist',
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {

            $request->user()->tokens()->delete();
            return response()->json([
                'message' => "You've logged out successfully"
            ]);
        } catch (\Error $err) {
            return response()->json([
                'message' => 'Something went wrong',
                'err' => $err->getMessage(),
            ], 500);
        }
    }
}

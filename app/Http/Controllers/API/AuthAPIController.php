<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthAPIController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->generateOtpCode();
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'message' => 'Registrasi berhasil',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = ['email' => $data['email'], 'password' => $data['password']];
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $userData = User::where('email', $data['email'])->first();
        $token = JWTAuth::fromUser($userData);
        return response()->json([
            "message" => "Login Berhasil",
            "user" => $userData,
            "token" => $token
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout Berhasil']);
    }

}

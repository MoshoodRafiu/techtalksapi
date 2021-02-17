<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum')->only('logout');
    }
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'confirm_password' => 'same:password'
        ]);

        $user = new User();
        $user['username'] = $request['username'];
        $user['password'] = Hash::make($request['password']);
        $user->save();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Error Registering User'
            ], 422);
        }
        $token = $user->createToken('chatToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if(!Auth::attempt($request->only(['username', 'password']))){
            return response()->json([
                'success' => false,
                'message' => 'User Not Found'
            ], 404);
        }
        $user = User::where('username', $request['username'])->first();

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $user->createToken('chatToken')->plainTextToken
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        if (\request()->user()->currentAccessToken()->delete()){
            return response()->json([
                'success' => true,
                'message' => 'User Logged Out'
            ]);
        };
    }
}

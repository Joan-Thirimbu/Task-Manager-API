<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Api\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['access_token' => $token], 201);
    }

    public function login(AuthRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'],401);
        }
        $user = Auth::user(); 
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['access_token'=> $token], 200);
    }
    
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register Action
     */
    public function register(Request $request)
    {
        //validate the user data
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|confirmed',
        ]);

        //create the user data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //create the token
        $token = $user->createToken('token-name')->plainTextToken;


        //create the response
        $reponse = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($reponse, 201);
    }

    /**
     * Login Action
     */
    public function login(Request $request)
    {
        //validate data
        $this->validate($request, [
            "email" => "required|string",
            "password" => "required|string",
        ]);

        //check user email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid login'
            ], 401);
        }

        //create the token
        $token = $user->createToken('token-name')->plainTextToken;

        //create the response
        $reponse = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($reponse, 201);
    }

    /**
     * Logout Action
     */
    public function logout(Request $request)
    {
        //delete all user tokens
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged out'
        ], 201);
    }

    /*
     * User Profile 
     */
    public function userProfile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ], 201);
    }
}

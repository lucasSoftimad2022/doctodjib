<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    // Register a new user.

    public function register(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' =>'required|string|min:6|confirmed',
        ]);

        // create a new user
        $user = User::create([
            'name' => $attrs['name'],
            'address' => $attrs['address'],
            'number' => $attrs['number'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password']),
        ]);
        // retrun user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken,
        ]);
    }


    // login.

    public function login(Request $request)
    {
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' =>'required|string|min:6',
        ]);

        // attemp login
        if (!Auth::attempt($attrs)) {
            return response([
                'message' => 'Invalid credentials',
            ], 403);
        }
        // retrun user & token in response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken,
        ], 200);
    }

    // Logout
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
           'message' => 'Successfully logged out',
        ], 200);
    }

    // User details
    public function user()
    {
        return response([
            'user' => auth()->user(),
        ], 200);
    }
}

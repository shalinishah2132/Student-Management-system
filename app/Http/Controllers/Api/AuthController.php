<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register User
public function accountregister(Request $request)
{
    // Manual check
    if (User::where('email', $request->email)->exists()) {
        return response()->json([
            'message' => 'Email address already in use.'
        ], 422);
    }

    // Validation
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'required|min:6'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
        'message' => 'Registered successfully',
        'user' => $user,
        'token' => $token
    ], 201);
}



    // Login api
public function accountlogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    // If user not found or wrong password
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'The provided credentials do not match our records.'
        ], 401);
    }

    // Create Sanctum token
    $token = $user->createToken('API Token')->plainTextToken;

    // Load roles
    $roles = $user->roles;

    // Check each role and return API response
    foreach ($roles as $role) {

        if ($role->name == 'admin') {
            return response()->json([
                'message' => 'Welcome back, Administrator!',
                'role' => 'admin',
                'user' => $user,
                'token' => $token
            ], 200);
        }

        if ($role->name == 'teacher') {
            return response()->json([
                'message' => 'Welcome back, Teacher!',
                'role' => 'teacher',
                'user' => $user,
                'token' => $token
            ], 200);
        }

        if ($role->name == 'student') {
            return response()->json([
                'message' => 'Welcome back, Student!',
                'role' => 'student',
                'user' => $user,
                'token' => $token
            ], 200);
        }
    }

    // If user has no role
    return response()->json([
        'message' => 'User has no role assigned.',
        'user' => $user,
        'token' => $token
    ], 200);
}

    // Logout User
    public function accountlogout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

}

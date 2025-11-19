<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
        public function assignRole(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'role_id' => 'required|exists:roles,id'
    ]);

    $user = User::find($request->user_id);
    $user->role_id = $request->role_id;
    $user->save();

    return response()->json([
        'message' => 'Role assigned successfully',
        'user' => $user
    ], 200);
}
}

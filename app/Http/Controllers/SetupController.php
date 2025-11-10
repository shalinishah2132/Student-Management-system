<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class SetupController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        
        return view('setup.index', compact('users', 'roles'));
    }
    
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);
        
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);
        
        if (!$user->hasRole($role->name)) {
            $user->assignRole($role->name);
            return back()->with('success', "Role '{$role->display_name}' assigned to {$user->name}");
        }
        
        return back()->with('info', "User already has this role");
    }
    
    public function makeAdmin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = User::find($request->user_id);
        $adminRole = Role::where('name', 'admin')->first();
        
        if ($adminRole && !$user->hasRole('admin')) {
            $user->assignRole('admin');
            return back()->with('success', "{$user->name} is now an Administrator");
        }
        
        return back()->with('info', "User is already an admin");
    }
}

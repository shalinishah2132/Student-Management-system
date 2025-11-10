<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class TestController extends Controller
{
    public function checkAccess()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        $user->load('roles.permissions');
        
        $data = [
            'user' => $user,
            'roles' => $user->roles,
            'permissions' => $user->roles->flatMap->permissions->unique('id'),
            'can_create_students' => $user->hasPermission('create_students'),
            'can_create_courses' => $user->hasPermission('create_courses'),
            'can_create_enrollments' => $user->hasPermission('create_enrollments'),
            'is_admin' => $user->isAdmin(),
            'is_teacher' => $user->isTeacher(),
            'is_student' => $user->isStudent(),
        ];
        
        return view('test.access', $data);
    }
}

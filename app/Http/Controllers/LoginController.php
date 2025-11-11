<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{  
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect to role-based dashboard
           // $user = Auth::user();
            $user = Auth::user();
            $roles = $user->roles;

         foreach ($roles as $role) {
            if ($role->name == 'admin'){
         return redirect()->route('dashboard')
                ->with('success', 'Welcome back, Administrator!');
        }
        elseif($role->name == 'teacher'){
            return redirect()->route('teacher.dashboard')
                ->with('success', 'Welcome back, Teacher!');
        } 
            elseif($role->name == 'student') {
            return redirect()->route('student.dashboard')
                ->with('success', 'Welcome back, Student!');
        }
            }
        }

        return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}


     public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}

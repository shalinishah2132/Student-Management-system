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
            $user = Auth::user();
           // dd ($user);
           // $roles = $user->roles;
            //dd ($roles);
            echo "Admin". $user->isAdmin();
            echo "Teacher" . $user->isTeacher();
          die; 
         
        if ($user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('success', 'Welcome back, Administrator!');
        }
        elseif ($user->isTeacher()) {
            //echo "hello";
            //die;
            return redirect()->route('teacher.dashboard')
                ->with('success', 'Welcome back, Teacher!');
        } 
            elseif ($user->isStudent()) {
            return redirect()->route('student.dashboard')
                ->with('success', 'Welcome back, Student!');
        }
           
              return redirect()->route('dashboard')
            ->with('success', 'Welcome back!');
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

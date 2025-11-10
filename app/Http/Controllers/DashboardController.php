<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    /**
     * Main dashboard - redirects based on user role
     */
    public function index()
    {
        $user = auth()->user();
        
        // Redirect based on user role
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isTeacher()) {
            return $this->teacherDashboard();
        } elseif ($user->isStudent()) {
            return $this->studentDashboard();
        }
        
        // Default fallback
        return $this->guestDashboard();
    }
    
    /**
     * Admin Dashboard - Full system overview
     */
    public function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_students' => Student::latest()->take(5)->get(),
            'recent_enrollments' => Enrollment::with(['student', 'course'])->latest()->take(5)->get(),
        ];
        
        return view('dashboards.admin', compact('stats'));
    }
    
    /**
     * Teacher Dashboard - Class and course management
     */
    public function teacherDashboard()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'recent_students' => Student::latest()->take(5)->get(),
            'recent_courses' => Course::latest()->take(5)->get(),
            'recent_enrollments' => Enrollment::with(['student', 'course'])->latest()->take(5)->get(),
        ];
        
        return view('dashboards.teacher', compact('stats'));
    }
    
    /**
     * Student Dashboard - Personal information and enrolled courses
     */
    public function studentDashboard()
    {
        $user = auth()->user();
        
        // For demo purposes, we'll show general student info
        // In a real app, you'd link users to student records
        $stats = [
            'available_courses' => Course::count(),
            'total_students' => Student::count(),
            'recent_courses' => Course::latest()->take(5)->get(),
            'user_info' => $user,
        ];
        
        return view('dashboards.student', compact('stats'));
    }
    
    /**
     * Guest Dashboard - Limited access
     */
    public function guestDashboard()
    {
        return view('dashboards.studentS');
    }
}

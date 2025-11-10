<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->orderBy('created_at', 'desc')->get();
        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::orderBy('student_name')->get();
        $courses = Course::orderBy('title')->get();
        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Check if enrollment already exists
        $existingEnrollment = Enrollment::where('student_id', $request->student_id)
                                      ->where('course_id', $request->course_id)
                                      ->first();

        if ($existingEnrollment) {
            return redirect()->back()->withErrors(['error' => 'Student is already enrolled in this course.']);
        }

        Enrollment::create($request->all());

        return redirect()->route('enrollments.index')->with('success', 'Student enrolled successfully!');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'course']);
        return view('enrollments.show', compact('enrollment'));
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment removed successfully!');
    }

    // Method to show enrollments for a specific student
    public function studentEnrollments(Student $student)
    {
        $enrollments = $student->enrollments()->with('course')->get();
        return view('enrollments.student', compact('student', 'enrollments'));
    }

    // Method to show enrollments for a specific course
    public function courseEnrollments(Course $course)
    {
        $enrollments = $course->enrollments()->with('student')->get();
        return view('enrollments.course', compact('course', 'enrollments'));
    }

    // AJAX method to get available courses for a specific student
    public function getAvailableCourses(Request $request)
    {
        $studentId = $request->get('student_id');
        
        if (!$studentId) {
            return response()->json(['courses' => []]);
        }

        // Get all courses
        $allCourses = Course::orderBy('title')->get();
        
        // Get courses already enrolled by this student
        $enrolledCourseIds = Enrollment::where('student_id', $studentId)
                                     ->pluck('course_id')
                                     ->toArray();
        
        // Filter out already enrolled courses
        $availableCourses = $allCourses->whereNotIn('id', $enrolledCourseIds);
        
        return response()->json([
            'courses' => $availableCourses->map(function($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'duration' => $course->duration
                ];
            })
        ]);
    }
}

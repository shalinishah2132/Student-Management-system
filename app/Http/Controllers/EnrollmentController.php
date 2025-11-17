<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EnrollmentController extends Controller
{   
    //web
    public function index()
    {
         $enrollments = Enrollment::with(['student', 'course'])
        ->orderBy('created_at', 'desc')
        ->get();
        return view('enrollments.index', compact('enrollments'));
    }

     //api 
     public function allenrollment()
    {
        $enrollments = Enrollment::with(['student', 'course'])
        ->orderBy('created_at', 'desc')
        ->get();
      return response()->json($enrollments);
    }

    public function create()
    {
        $students = Student::orderBy('student_name')->get();
        $courses = Course::orderBy('title')->get();
        return view('enrollments.create', compact('students', 'courses'));
    }
//web
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

public function enrollmentstore(Request $request)
{
    try {

        // Validate request
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
        ], [
            'student_id.required' => 'Student ID is required.',
            'student_id.exists'   => 'The selected student does not exist.',
            'course_id.required'  => 'Course ID is required.',
            'course_id.exists'    => 'The selected course does not exist.',
        ]);

        // Check if enrollment already exists
        $existingEnrollment = Enrollment::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'message' => 'The student is already enrolled in this course.',
            ], 409); // Conflict
        }

        // Create enrollment
        $enrollment = Enrollment::create($validated);

        return response()->json([
            'message' => 'Enrollment created successfully.',
            'data'    => $enrollment
        ], 201);

    } catch (ValidationException $e) {

        return response()->json([
            'message' => 'Validation failed.',
            'errors'  => $e->errors(),
        ], 422);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'message' => 'Related record not found.',
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Something went wrong.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}



//web
    public function show($id)
    {
    $enrollment = Enrollment::find($id);
    if (!$enrollment) {
        return response()->json(['error' => 'Enrollment not found'], 404);
    }
    $enrollment->load(['student', 'course']);
     $enrollment->created_at = $enrollment->created_at->format('Y-m-d H:i:s');
    $enrollment->updated_at = $enrollment->updated_at->format('Y-m-d H:i:s');
    return view('enrollments.show', compact('enrollment'));
    }

//api
    public function showenrollment($id)
    {
    $enrollment = Enrollment::find($id);
     $enrollment->created_at = $enrollment->created_at->format('Y-m-d H:i:s');
    $enrollment->updated_at = $enrollment->updated_at->format('Y-m-d H:i:s');
    if (!$enrollment) {
        return response()->json(['error' => 'Enrollment not found'], 404);
    }
    $enrollment->load(['student', 'course']);
    return response()->json($enrollment);
    }

//web
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment removed successfully!');
    }

    //api
 public function enrollmentdelete($id)
{
    try {
        // Check if enrollment exists
        $enrollment = Enrollment::findOrFail($id);

        // Delete the record
        $enrollment->delete();

        return response()->json([
            'message' => 'Enrollment deleted successfully.'
        ], 200);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'message' => 'Enrollment not found.'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    // Method to show enrollments for a specific student 
    //web
    public function studentEnrollments(Student $student)
    {
        $enrollments = $student->enrollments()->with('course')->get();
        return view('enrollments.student', compact('student', 'enrollments'));
    }
//api
    public function allstudentEnrollments(Student $student)
    {
        $enrollments = $student->enrollments()->with('course')->get();
        return response()->json($enrollments);
    }

    // Method to show enrollments for a specific course
    //web
    public function courseEnrollments(Course $course)
    {
        $enrollments = $course->enrollments()->with('student')->get();
        return view('enrollments.course', compact('course', 'enrollments'));
    }
//api
     public function allcourseEnrollments(Course $course)
    {
        $enrollments = $course->enrollments()->with('student')->get();
         return response()->json($enrollments);
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

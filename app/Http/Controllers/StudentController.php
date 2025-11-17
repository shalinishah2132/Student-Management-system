<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{  //web
    public function index()
    {
        $students = Student::orderBy('total_marks', 'desc')->get();
        return view('students.index', compact('students'));
        $students = Student::all();
    }
 //api
     public function allstudent()
    {
        $students = Student::orderBy('total_marks', 'desc')->get();
        $students = Student::all();
        return response()->json($students);
    }


    public function create()
    {
        return view('students.create');
    }
        //web
  public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|unique:students',
            'student_phone' => 'nullable|string|max:20',
            'total_marks' => 'required|integer|min:0|max:500',
        ]);

        $student = Student::create($request->all());
        
        // Auto-assign rank based on marks
        $rank = match(true) {
            $student->total_marks >= 400 => 'First Class',
            $student->total_marks >= 300 => 'Second Class',
            $student->total_marks >= 200 => 'Third Class',
            default => 'Fail'
        };
        
        $student->update(['rank' => $rank]);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }
    //api
    public function studentstore(Request $request)
{
    try {

        // 🔍 Validate input (returns errors instead of HTML)
        $validator = Validator::make($request->all(), [
            'student_name'  => 'required|string|max:255',
            'student_email' => 'required|email|unique:students,student_email',
            'student_phone' => 'nullable|string|max:20',
            'total_marks'   => 'required|integer|min:0|max:500',
        ]);

        // ❌ If validation fails → return JSON instead of redirecting
        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Create student record
        $student = Student::create([
            'student_name'  => $request->student_name,
            'student_email' => $request->student_email,
            'student_phone' => $request->student_phone,
            'total_marks'   => $request->total_marks,
        ]);

        // 🎯 Auto assign rank
        $rank = match (true) {
            $student->total_marks >= 400 => 'First Class',
            $student->total_marks >= 300 => 'Second Class',
            $student->total_marks >= 200 => 'Third Class',
            default => 'Fail',
        };

        $student->rank = $rank;
        $student->save();

        // 🎉 Success response
        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student
        ], 201);

    } catch (\Exception $e) {

        // ❗ Catch unexpected server errors
        return response()->json([
            'error' => 'Something went wrong while creating the student.',
            'details' => $e->getMessage()
        ], 500);
    }
}

//web
    public function show($id)
{
    $student = Student::find($id);
    $student->created_at = $student->created_at->format('Y-m-d H:i:s');
    $student->updated_at = $student->updated_at->format('Y-m-d H:i:s');
 
    if (!$student) {
        return response()->json(['error' => 'Student not found'], 404);
    }
     return view('students.show', compact('student'));
     
}
 //api
public function showstudent($id)
{
    $student = Student::find($id);
    $student->created_at = $student->created_at->format('Y-m-d H:i:s');
    $student->updated_at = $student->updated_at->format('Y-m-d H:i:s');
 
    if (!$student) {
        return response()->json(['error' => 'Student not found'], 404);
    }
   //  return view('students.show', compact('student'));
       return response()->json($student);
}
 
   public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }
   //web
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|unique:students,student_email,' . $student->id,
            'student_phone' => 'nullable|string|max:20',
            'total_marks' => 'required|integer|min:0|max:500',
        ]);

        $student->update($request->all());
        
        // Update rank based on marks
        $rank = match(true) {
            $student->total_marks >= 400 => 'First Class',
            $student->total_marks >= 300 => 'Second Class',
            $student->total_marks >= 200 => 'Third Class',
            default => 'Fail'
        };
        
        $student->update(['rank' => $rank]);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully');
    }

    //api
 public function studentupdate(Request $request, $id)
{
    // ✅ Find the student
    $student = Student::find($id);

    // ✅ Validate input
    $request->validate([
        'student_name'  => 'sometimes|required|string|max:255',
        'student_email' => 'sometimes|required|email|unique:students,student_email,' . $id,
        'student_phone' => 'nullable|string|max:20',
        'total_marks'   => 'sometimes|required|integer|min:0|max:500',
    ]);

    // ✅ Update student fields
    $student->update([
        'student_name'  => $request->student_name ?? $student->student_name,
        'student_email' => $request->student_email ?? $student->student_email,
        'student_phone' => $request->student_phone ?? $student->student_phone,
        'total_marks'   => $request->total_marks ?? $student->total_marks,
    ]);

    // ✅ Recalculate rank if total_marks changed
    $rank = match (true) {
        $student->total_marks >= 400 => 'First Class',
        $student->total_marks >= 300 => 'Second Class',
        $student->total_marks >= 200 => 'Third Class',
        default => 'Fail',
    };

    $student->update(['rank' => $rank]);

    // ✅ Return response
     return response()->json([
        'message' => 'Student updated successfully',
        'student' => $student
    ]);
}

//web
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

//api
public function studentdelete($id)
{
    // Validate ID (must be numeric)
    if (!is_numeric($id)) {
        return response()->json([
            'error' => 'Invalid student ID.'
        ], 400);
    }

    // Try to find the student
    $student = Student::find($id);

    // If not found, return error
    if (!$student) {
        return response()->json([
            'error' => 'Student not found.'
        ], 404);
    }

    try {
        // Delete the student
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.'
        ], 200);

    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'error' => 'An error occurred while deleting the student.',
            'details' => $e->getMessage()
        ], 500);
    }
}

/**
 * Show the form for editing the student's address.
 *
 * @param  \App\Models\Student  $student
 * @return \Illuminate\Http\Response
 */
public function editAddress(Student $student)
{
    return view('students.edit-address', compact('student'));
}

/**
 * Update the student's address in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Student  $student
 * @return \Illuminate\Http\Response
 */
public function updateAddress(Request $request, Student $student)
{
    $validated = $request->validate([
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|string|max:20',
    ]);

    $student->update($validated);

    return redirect()->route('students.show', $student->id)
        ->with('success', 'Address updated successfully');
}
}
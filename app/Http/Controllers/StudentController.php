<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('total_marks', 'desc')->get();
        return view('students.index', compact('students'));
        $students = Student::all();
    }

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

    public function show($id)
{
    $student = Student::find($id);
    $student->created_at = $student->created_at->format('Y-m-d H:i:s');
    $student->updated_at = $student->updated_at->format('Y-m-d H:i:s');
 
    if (!$student) {
        return response()->json(['error' => 'Student not found'], 404);
    }
     return view('students.show', compact('student'));
      // return response()->json($student);
}
 
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

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|unique:students,student_email,' . $student->id,
            'student_phone' => 'nullable|string|max:20',
            'total_marks' => 'required|integer|min:0|max:500',
        ]);

        $student->update($request->all());
        
        // Auto-assign rank based on marks
        $rank = match(true) {
            $student->total_marks >= 400 => 'First Class',
            $student->total_marks >= 300 => 'Second Class',
            $student->total_marks >= 200 => 'Third Class',
            default => 'Fail'
        };
        
        $student->update(['rank' => $rank]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}

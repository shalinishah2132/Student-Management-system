<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //web
    public function index()
   {
    $courses = Course::orderBy('title')->get();
    return view('courses.index', compact('course'));
    $courses = Course::all();
  }

    //api
     public function allcourse()
   {
    $course = Course::orderBy('title')->get();
    return response()->json($course);
     $course = Course::all();
    }
    

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:255',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    public function show($id)
     {
        $course = Course::find($id);
        $course->created_at = $course->created_at->format('Y-m-d H:i:s');
        $course->updated_at = $course->updated_at->format('Y-m-d H:i:s');
        if (!$course) 
            {
              return response()->json(['error' => 'Course not found'], 404);
            }
      return view('courses.show', compact('course'));
    }

     public function showcourse($id)
     {
        $course = Course::find($id);
        $course->created_at = $course->created_at->format('Y-m-d H:i:s');
        $course->updated_at = $course->updated_at->format('Y-m-d H:i:s');
        if (!$course) 
            {
              return response()->json(['error' => 'Course not found'], 404);
            }
        return response()->json($course);
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:255',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}

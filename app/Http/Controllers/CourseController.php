<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Validation;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class CourseController extends Controller
{
    //web
    public function index()
   {
    $courses = Course::orderBy('title')->get();
    return view('courses.index', compact('courses'));
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

    //web
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

    //api
public function coursestore(Request $request)
{
    try {
        // Validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
        ], [
            'title.required' => 'Course title is required.',
            'duration.required' => 'Course duration is required.',
        ]);

        // Create course
        $course = Course::create($validated);

        return response()->json([
            'message' => 'Course created successfully.',
            'data' => $course
        ], 201);

    } catch (Exception $e) {

        return response()->json([
            'message' => 'Validation failed.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Something went wrong.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


//web
    public function show($id)
     {
        $course = Course::find($id);
        $course->created_at = $course->created_at->format('Y-m-d H:i:s');
        $course->updated_at = $course->updated_at->format('Y-m-d H:i:s');
        
      return view('courses.show', compact('course'));
    }
//api
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
//web
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
//api
public function courseupdate(Request $request, $id)
{
    try {

        // Check if course exists
        $course = Course::findOrFail($id);

        // Validation rules
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'duration' => 'sometimes|required|string|max:255',
        ], [
            'title.required' => 'Course title is required when updating.',
            'duration.required' => 'Course duration is required when updating.',
        ]);

        // Update only validated values
        $course->update($validated);

        return response()->json([
            'message' => 'Course updated successfully.',
            'data' => $course
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Validation failed.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Course not found.'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}



//web
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }

    //api
public function coursedelete($id)
{
    try {
        // Try to find course
        $course = Course::findOrFail($id);

        // Delete the course
        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully.'
        ], 200);

    } catch (ModelNotFoundException $e) {

        return response()->json([
            'message' => 'Course not found.'
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'message' => 'Something went wrong.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}

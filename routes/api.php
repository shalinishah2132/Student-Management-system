<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function() {
    return response()->json(['message' => 'API is working!']);
});

//student token
Route::middleware('api.token')->group(function () {
    //students
    Route::get('/students', [StudentController::class, 'allstudent']);
    Route::get('/students/{id}', [StudentController::class, 'showstudent']);

    //courses
    Route::get('/courses', [CourseController::class, 'allcourse']);
    Route::get('/courses/{id}', [CourseController::class, 'showcourse']);

    //enrollments
    Route::get('/enrollments', [EnrollmentController::class, 'allenrollment']);
    Route::get('/enrollments/{id}', [EnrollmentController::class, 'showenrollment']);
});

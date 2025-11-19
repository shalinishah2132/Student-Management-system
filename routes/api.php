<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;



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


// Public routes
Route::post('/register', [AuthController::class, 'accountregister']);
Route::post('/login', [AuthController::class, 'accountlogin']);
Route::post('/assignrole', [RoleController::class, 'assignRole']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'accountlogout']);
    
});

//student token
Route::middleware('api.token')->group(function () {
    //students
    Route::get('/students', [StudentController::class, 'allstudent']);
    Route::get('/students/{id}', [StudentController::class, 'showstudent']);
    Route::post('/students/create', [StudentController::class, 'studentstore']); //create students
    Route::put('/students/edit/{id}', [StudentController::class, 'studentupdate']); //edit students
    Route::delete('/students/{id}', [StudentController::class, 'studentdelete']);//delete students
    
    //courses
    Route::get('/courses', [CourseController::class, 'allcourse']);
    Route::get('/courses/{id}', [CourseController::class, 'showcourse']);
    Route::post('/courses/create', [CourseController::class, 'coursestore']);  //create courses
    Route::put('/courses/edit/{id}', [CourseController::class, 'courseupdate']);  //edit courses
    Route::delete('/courses/{id}', [CourseController::class, 'coursedelete']);  //delete courses

    //enrollments
    Route::get('/enrollments', [EnrollmentController::class, 'allenrollment']);
    Route::get('/enrollments/{id}', [EnrollmentController::class, 'showenrollment']);
    Route::post('/enrollments/create', [EnrollmentController::class, 'enrollmentstore']);  //create enrollments
    Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'enrollmentdelete']);  //delete enrollments
    Route::get('/students/{student}/courses', [EnrollmentController::class, 'allstudentEnrollments']); //list all courses of a student
    Route::get('/courses/{course}/students', [EnrollmentController::class, 'allcourseEnrollments']);//list all students of a course
    
    
 });

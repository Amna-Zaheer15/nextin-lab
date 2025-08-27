<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProjectController; 
use App\Http\Controllers\TemplateController; 
use App\Http\Controllers\LabController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/projects', function () {
    return view('pages.projects');
});

Route::get('/templates', function () {
    return view('pages.templates');
});

Route::get('/lab', function () {
    return view('pages.lab');
});

//This route is duplicated below and can be removed
Route::get('/courses', function () {
    return view('pages.courses');
});



// Course detail page


// Course content page
Route::get('/courses/{courseId}/content/{topicId}', function ($courseId, $topicId) {
    // Fetch topic content from database
    return view('pages.coursecontent', [
        'courseId' => $courseId,
        'topicId' => $topicId
    ]);
})->name('course.content');

//Admin routes
Route::prefix('admin')->group(function() {
    // Dashboard
    Route::view('/', 'admin.dashbord'); // Fixed typo in 'dashboard'
    
    //Admin Courses
    //Route::get('/admincourses', [CourseController::class, 'showAdminCourses'])->name('admin.courses');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses');
    Route::get('/course/{id?}', [CourseController::class, 'showAdminCourses'])->name('admin.course');

    // Courses routes
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
  // Use PUT method for updates and include the course ID parameter
Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    // Store or update course

    // In routes/web.php
    Route::delete('/course/{course}', [CourseController::class, 'destroy'])->name('admin.deletecourse');
    
    // Route::post('/course/{id}', [CourseController::class, 'update'])->name('admin.updatecourse');


Route::get('/coursedetail/{id}', [CourseController::class, 'show'])->name('courses.detail');

Route::get('/coursedetail/{id}/{topic}', [CourseController::class, 'topicContent'])->name('topic.detail');


//projects routes

Route::get('/adminprojects', [ProjectController::class, 'index'])->name('admin.projects');
Route::get('/addeditprojects', [ProjectController::class, 'create'])->name('addeditprojects.create');
Route::get('/addeditprojects/{id}', [ProjectController::class, 'edit'])->name('addeditprojects.edit');
Route::get('/viewprojects/{id}', [ProjectController::class, 'show'])->name('viewprojects.show');




// templates 
// Route::get('/admintemplates', [TemplateController::class, 'get'])->name('admin.templates');

Route::get('/admintemplates', [TemplateController::class, 'index'])->name('admin.templates');
Route::get('/addedittemplates', [TemplateController::class, 'create'])->name('addedittemplates.create');
Route::get('/addedittemplates/{id}', [TemplateController::class, 'edit'])->name('addedittemplates.edit');
Route::get('/viewtemplates/{id}', [TemplateController::class, 'show'])->name('viewtemplates.show');

// Lab Routes
Route::get('/admin/lab', [LabController::class, 'index'])->name('admin.lab');

// Lab Routes
Route::get('/admin/lab/create', [LabController::class, 'create'])->name('addeditlab.create');
Route::post('/admin/lab/store', [LabController::class, 'store'])->name('addeditlab.store');
Route::get('/admin/lab/{id}/edit', [LabController::class, 'edit'])->name('addeditlab.edit');
Route::put('/admin/lab/{id}/update', [LabController::class, 'update'])->name('addeditlab.update');
Route::delete('/admin/lab/{id}/delete', [LabController::class, 'destroy'])->name('addeditlab.delete');
Route::get('/admin/lab/{id}', [LabController::class, 'show'])->name('viewlab.show');
});
 


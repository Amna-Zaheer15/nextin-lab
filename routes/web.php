<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController; // Add this line to import the CourseController
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

Route::get('/projectdetails', function () {
    return view('pages.projectdetails');
});

Route::get('/templates', function () {
    return view('pages.templates');
});

Route::get('/templatedetails', function () {
    return view('pages.templatedetails');
});

Route::get('/templatedemo', function () {
    return view('pages.templatedemo');
});

Route::get('/lab', function () {
    return view('pages.lab');
});

//This route is duplicated below and can be removed
Route::get('/courses', function () {
    return view('pages.courses');
});

Route::get('/coursecontent', function () {
    return view('pages.coursecontent');
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
    Route::get('/course', [CourseController::class, 'showAdminCourses'])->name('admin.course');
    Route::delete('/course/{course}', [CourseController::class, 'destroy'])->name('admin.deletecourse');
    
    Route::put('/course/{id}', [CourseController::class, 'update'])->name('admin.updatecourse');


Route::get('/coursedetail/{id}', [CourseController::class, 'show'])->name('courses.detail');

Route::get('/coursedetail/{id}/{topic}', [CourseController::class, 'topicContent'])->name('topic.detail');
 
//routes new by asmat
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
  // Use PUT method for updates and include the course ID parameter
Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
// view course
Route::get('/courses/{id}', [CourseController::class, 'ViewCourse'])->name('courses.show');

// Project Routes
Route::get('/adminprojects', [ProjectController::class, 'index'])->name('admin.projects');
Route::get('/addeditprojects/{id?}', [ProjectController::class, 'addOrEdit'])->name('addeditprojects');
Route::get('/viewprojects/{id}', [ProjectController::class, 'show'])->name('viewprojects.show');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');



// templates 
// Route::get('/admintemplates', [TemplateController::class, 'get'])->name('admin.templates');

Route::get('/admintemplates', [TemplateController::class, 'index'])->name('admin.templates');
Route::get('/addedittemplates', [TemplateController::class, 'create'])->name('addedittemplates.create');
Route::get('/addedittemplates/{id}', [TemplateController::class, 'edit'])->name('addedittemplates.edit');
Route::get('/viewtemplates/{id}', [TemplateController::class, 'show'])->name('viewtemplates.show');

// Lab Routes
Route::get('/admin/lab', [LabController::class, 'index'])->name('admin.lab');

// Lab Routes
// Route::get('/admin/lab', [LabController::class, 'index'])->name('admin.lab');
Route::get('/admin/lab/create', [LabController::class, 'create'])->name('addeditlab.create');
Route::post('/admin/lab/store', [LabController::class, 'store'])->name('addeditlab.store');
Route::get('/admin/lab/{id}/edit', [LabController::class, 'edit'])->name('addeditlab.edit');
Route::put('/admin/lab/{id}/update', [LabController::class, 'update'])->name('addeditlab.update');
Route::delete('/admin/lab/{id}/delete', [LabController::class, 'destroy'])->name('addeditlab.delete');
Route::get('/admin/lab/{id}', [LabController::class, 'show'])->name('viewlab.show');
});




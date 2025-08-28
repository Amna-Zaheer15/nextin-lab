<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function showAdminCourses($id = null)
    {
        if ($id) {
            // Return a single course
            $course = Course::findOrFail($id);
            return response()->json($course);
        }
        
        // Return all courses for the admin view
        $courses = Course::all();
        return view('admin.adminpages.admincourse', compact('courses'));
    }
    
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topics' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'views' => 'nullable|integer',
            'time' => 'nullable|integer',
            'category' => 'required|string|max:100',
            'level' => 'required|string|max:100',
            'duration' => 'nullable|integer',
            'lessons' => 'nullable|integer',
            'price' => 'nullable|integer',
        ]);

        $courseData = $validated;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $courseData['thumbnail'] = Storage::url($path);
        }

        $course = Course::create($courseData);

        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course
        ], 201);
    }

    /**
     * Display the specified course.
     */
    public function ViewCourse($id)
    {
        
        $course = Course::findOrFail($id);
        return view('Admin.AdminPages.ViewCourse', compact('course'));
    }

     public function show($id)
    {
        
        $course = Course::findOrFail($id);
        
        return view('pages.coursedetail', compact('course'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('admin.adminpages.AddCourse');
    }
   /**
     * Show the form for editing an existing course.
     */
    public function edit($id)
    {
    
        try {
            $course = Course::findOrFail($id);
            \Log::info("Editing course with ID: {$course->id}");
            return view('admin.adminpages.EditCourse', compact('course'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Course not found for ID: {$id}");
            return redirect()->route('admin.courses')->with('error', 'Course not found.');
        }
    }




    /**
     * Update the specified course in storage.
     */
public function update(Request $request, $id)
{
    // Find the course
    $course = Course::findOrFail($id);
    
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'instructor' => 'required|string|max:255',
        'description' => 'nullable|string',
        'topics' => 'nullable|string',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'views' => 'nullable|integer',
        'time' => 'nullable|integer',
        'category' => 'required|string|max:100',
        'level' => 'required|string|max:100',
        'duration' => 'nullable|integer',
        'lessons' => 'nullable|integer',
        'price' => 'nullable|integer',
    ]);

    $courseData = $validated;

    if ($request->hasFile('thumbnail')) {
        if ($course->thumbnail) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $course->thumbnail));
        }
        $path = $request->file('thumbnail')->store('thumbnails', 'public');
        $courseData['thumbnail'] = Storage::url($path);
    }

    $course->update($courseData);

    return redirect()->route('admin.course')->with('success', 'Course updated successfully');
}

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $course->thumbnail));
        }
        
        $course->delete();
        
        return response()->json([
            'message' => 'Course deleted successfully'
        ]);
    }
}
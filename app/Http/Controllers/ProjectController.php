<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('admin.adminpages.adminprojects', compact('projects'));
    }

    public function addOrEdit($id = null)
    {
        $project = $id ? Project::findOrFail($id) : new Project(['status' => 'active', 'downloads' => 0, 'purchases' => 0]);
        return view('admin.adminpages.addeditprojects', compact('project'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image_url' => 'required|url',
            'technology' => 'required|string|max:255',
            'price' => 'required|string|max:50',
            'downloads' => 'nullable|integer|min:0',
            'purchases' => 'nullable|integer|min:0',
        ]);

        Project::create($validated);

        return redirect()->route('admin.projects')
                         ->with('success', 'Project created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image_url' => 'required|url',
            'technology' => 'required|string|max:255',
            'price' => 'required|string|max:50',
            'downloads' => 'nullable|integer|min:0',
            'purchases' => 'nullable|integer|min:0',
        ]);

        $project = Project::findOrFail($id);
        $project->update($validated);

        return redirect()->route('admin.projects')
                         ->with('success', 'Project updated successfully.');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.adminpages.viewprojects', compact('project'));
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects')
                         ->with('success', 'Project deleted successfully.');
    }
}
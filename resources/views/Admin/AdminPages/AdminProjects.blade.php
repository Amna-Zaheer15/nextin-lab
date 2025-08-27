@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 font-poppins">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-semibold text-gray-800">Admin Projects</h1>
            <a href="{{ route('addeditprojects') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg">Add New Project</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-green-900 text-white text-sm">
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Description</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Image</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-100 text-gray-800 text-sm">
                            <td class="p-3 border-b border-gray-200">{{ $project->title }}</td>
                            <td class="p-3 border-b border-gray-200">{{ $project->short_description }}</td>
                            <td class="p-3 border-b border-gray-200">
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs">{{ ucfirst($project->status) }}</span>
                            </td>
                            <td class="p-3 border-b border-gray-200">
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-24 h-14 object-cover rounded">
                            </td>
                            <td class="p-3 border-b border-gray-200 flex space-x-3">
                                <a href="{{ route('addeditprojects', $project->id) }}" class="text-green-700 hover:text-green-900 transition-transform transform hover:scale-110" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('viewprojects.show', $project->id) }}" class="text-green-700 hover:text-green-900 transition-transform transform hover:scale-110" title="View"><i class="fas fa-eye"></i></a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-transform transform hover:scale-110" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-600">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        @media (max-width: 768px) {
            .content-area {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .bg-white.rounded-lg {
                padding: 1rem;
            }

            .text-xl.font-semibold {
                font-size: 1.25rem;
            }

            .bg-green-700.text-white {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }

            .w-full.border-collapse {
                font-size: 0.875rem;
            }

            .w-full.border-collapse th,
            .w-full.border-collapse td {
                padding: 0.75rem;
            }

            .w-24.h-14 {
                width: 5rem;
                height: 3rem;
            }

            .text-sm {
                font-size: 0.75rem;
            }

            .text-xs {
                font-size: 0.65rem;
            }
        }
    </style>
@endsection
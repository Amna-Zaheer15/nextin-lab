@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 font-poppins">
        <h1 class="text-xl font-semibold text-gray-800 mb-6">View Project: {{ $project->title }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Title</label>
                <p>{{ $project->title }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Technology</label>
                <p>{{ $project->technology }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Price</label>
                <p>{{ $project->price }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Status</label>
                <p>{{ ucfirst($project->status) }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Short Description</label>
                <p>{{ $project->short_description }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Full Description</label>
                <p>{{ $project->full_description ?? 'N/A' }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Image</label>
                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-32 h-20 object-cover rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Downloads</label>
                <p>{{ $project->downloads }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Purchases</label>
                <p>{{ $project->purchases }}</p>
            </div>
        </div>
        <a href="{{ route('admin.projects') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-transform transform hover:scale-105 text-sm">Back to Projects</a>
    </div>

    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        @media (max-width: 768px) {
            .bg-white.rounded-lg {
                padding: 1rem;
            }

            .text-xl.font-semibold {
                font-size: 1.25rem;
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
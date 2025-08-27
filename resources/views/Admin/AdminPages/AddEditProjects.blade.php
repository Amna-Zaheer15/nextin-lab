@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 font-poppins">
        <h1 class="text-xl font-semibold text-gray-800 mb-6">{{ $project->id ? 'Edit Project' : 'Add New Project' }}</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $project->id ? route('projects.update', $project->id) : route('projects.store') }}" method="POST">
            @csrf
            @if($project->id)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-medium">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $project->title ?? '') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="technology" class="block text-gray-700 text-sm font-medium">Technology</label>
                    <input type="text" name="technology" id="technology" value="{{ old('technology', $project->technology ?? '') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" required>
                    @error('technology')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 text-sm font-medium">Price</label>
                    <input type="text" name="price" id="price" value="{{ old('price', $project->price ?? '') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" required>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-medium">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" required>
                        <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $project->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="short_description" class="block text-gray-700 text-sm font-medium">Short Description</label>
                <textarea name="short_description" id="short_description" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" required>{{ old('short_description', $project->short_description ?? '') }}</textarea>
                @error('short_description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="full_description" class="block text-gray-700 text-sm font-medium">Full Description</label>
                <textarea name="full_description" id="full_description" rows="5" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700">{{ old('full_description', $project->full_description ?? '') }}</textarea>
                @error('full_description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image_url" class="block text-gray-700 text-sm font-medium">Image URL</label>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $project->image_url ?? '') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" required>
                @if($project->image_url)
                    <img src="{{ $project->image_url }}" alt="Project Image" class="mt-2 w-32 h-20 object-cover rounded">
                @endif
                @error('image_url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="downloads" class="block text-gray-700 text-sm font-medium">Downloads</label>
                    <input type="number" name="downloads" id="downloads" value="{{ old('downloads', $project->downloads ?? 0) }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" min="0">
                    @error('downloads')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="purchases" class="block text-gray-700 text-sm font-medium">Purchases</label>
                    <input type="number" name="purchases" id="purchases" value="{{ old('purchases', $project->purchases ?? 0) }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-700" min="0">
                    @error('purchases')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition-transform transform hover:scale-105 text-sm">
                    {{ $project->id ? 'Update Project' : 'Save Project' }}
                </button>
                <a href="{{ route('admin.projects') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-transform transform hover:scale-105 text-sm">Cancel</a>
            </div>
        </form>
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
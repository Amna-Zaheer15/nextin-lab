@extends('layouts.admin')

@section('content')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 1000px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h1 {
        color: #00695C;
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    .card-header {
        background: #35978d;
        color: white;
        padding: 15px;
    }
    .card-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 500;
    }
    .card-body {
        padding: 20px;
    }
    .course-details {
        line-height: 1.6;
    }
    .course-details p {
        margin: 10px 0;
    }
    .course-details strong {
        font-size: 1.1rem;
        color: #333;
        display: inline-block;
        width: 150px;
    }
    .course-thumbnail {
        max-width: 200px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }
    .btn-primary {
        background: #00695C;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary:hover {
        background: #004D40;
    }
</style>

<div class="container">
    <h1>Course Details</h1>
    <div class="card">
        <div class="card-header">
            <h2>{{ $course->title }}</h2>
        </div>
        <div class="card-body">
            <div class="course-details">
                @if($course->thumbnail)
                    <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="course-thumbnail">
                @else
                    <p><strong>Thumbnail:</strong> No thumbnail available</p>
                @endif
                <p><strong>ID:</strong> {{ $course->id }}</p>
                <p><strong>Instructor:</strong> {{ $course->instructor ?? 'N/A' }}</p>
                <p><strong>Description:</strong> {{ $course->description ?? 'No description available' }}</p>
                <p><strong>Topics:</strong> {!! $course->topics ?? 'N/A' !!}</p>
                <p><strong>Category:</strong> {{ $course->category ?? 'N/A' }}</p>
                <p><strong>Level:</strong> {{ $course->level ?? 'N/A' }}</p>
                <p><strong>Duration:</strong> {{ $course->duration ? $course->duration . ' minutes' : 'N/A' }}</p>
                <p><strong>Lessons:</strong> {{ $course->lessons ?? 'N/A' }}</p>
                <p><strong>Price:</strong> {{ $course->price ? '$' . number_format($course->price / 100, 2) : 'N/A' }}</p>
                <p><strong>Views:</strong> {{ $course->views ?? 'N/A' }}</p>
                <p><strong>Time:</strong> {{ $course->time ? $course->time . ' minutes ago' : 'N/A' }}</p>
                <p><strong>Created At:</strong> {{ $course->created_at ? $course->created_at->format('d M Y') : 'N/A' }}</p>
                <p><strong>Updated At:</strong> {{ $course->updated_at ? $course->updated_at->format('d M Y') : 'N/A' }}</p>
            </div>
            <a href="{{ route('admin.course') }}" class="btn-primary">Back to Courses</a>
        </div>
    </div>
</div>

@endsection
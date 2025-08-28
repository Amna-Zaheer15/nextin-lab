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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .add-course-btn {
        background: #00695C;
        color: white;
        border: none;
        padding: 10px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
        line-height: 1;
    }
    .add-course-btn:hover {
        background: #004D40;
    }
    .add-course-btn i {
        font-size: 18px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    th {
        background: #35978d;
        color: white;
        font-weight: 500;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    .actions {
        white-space: nowrap;
        
    }
    .actions a, .actions button {
        margin-right: 5px;
        padding: 6px;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        line-height: 1;
    }
    .view {
        background: #02d1d1ff;
        color: white;
        border: none;
    }
    .view:hover {
        background: #0277BD;
    }
    .edit {
        background: #078af5ff;
        color: white;
        border: none;
    }
    .edit:hover {
        background: #f57c55;
    }
    .delete {
        background: #dc3545;
        color: white;
        border: none;
    }
    .delete:hover {
        background: #c82333;
    }
    .actions i {
        font-size: 16px;
    }
    .course-thumbnail {
        width: 100px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .course-details {
        line-height: 1.5;
    }
    .course-details strong {
        font-size: 1.1rem;
        color: #333;
    }
    .course-details ol {
        margin: 0;
        padding-left: 20px;
    }
    .course-details li {
        margin-bottom: 5px;
    }
    .alert {
        padding: 12px 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        display: none;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container">
    <h1>
        Courses Management
        <a href="{{ route('courses.create') }}" class="add-course-btn" title="Add New Course">
            <i class="fas fa-plus"></i>
        </a>
    </h1>

    <!-- Success Message Alert -->
    <div id="successAlert" class="alert alert-success"></div>

    <!-- Courses Table -->
    <table>
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="coursesList">
            <!-- Courses will be loaded here via JavaScript -->
        </tbody>
    </table>
</div>

<script>
    // Show success message
    function showSuccessMessage(message) {
        const alert = document.getElementById('successAlert');
        alert.textContent = message;
        alert.style.display = 'block';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    }

    // Load courses data
    function loadCourses() {
        fetch('{{ route('admin.courses') }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const coursesList = document.getElementById('coursesList');
                coursesList.innerHTML = '';
                
                if (data.length === 0) {
                    coursesList.innerHTML = `
                        <tr>
                            <td colspan="3" style="text-align: center;">No courses found. Click "Add New Course" to create one.</td>
                        </tr>
                    `;
                    return;
                }
                
                data.forEach(course => {
                    const row = document.createElement('tr');
                    
                    // Thumbnail column
                    const thumbnailCell = document.createElement('td');
                    if (course.thumbnail) {
                        const thumbnailImg = document.createElement('img');
                        thumbnailImg.src = course.thumbnail;
                        thumbnailImg.alt = course.title;
                        thumbnailImg.className = 'course-thumbnail';
                        thumbnailCell.appendChild(thumbnailImg);
                    } else {
                        thumbnailCell.textContent = 'No thumbnail';
                    }
                    
                    // Details column
                    const detailsCell = document.createElement('td');
                    detailsCell.className = 'course-details';
                    
                    const topicsHtml = course.topics ? course.topics : 'N/A';
                    const plainDescription = course.description ? 
                        course.description.replace(/<[^>]*>/g, '').substring(0, 100) + '...' : 'N/A';
                    
                    detailsCell.innerHTML = `
                        <strong>${course.title}</strong><br>
                        <strong>Instructor:</strong> ${course.instructor}<br>
                        <strong>Description:</strong> ${plainDescription}<br>
                        <strong>Topics:</strong> ${topicsHtml}<br>
                        <strong>Category:</strong> ${course.category} | 
                        <strong>Level:</strong> ${course.level}<br>
                        <strong>Duration:</strong> ${course.duration} minutes | 
                        <strong>Lessons:</strong> ${course.lessons}<br>
                        <strong>Price:</strong> $${(course.price / 100).toFixed(2)} | 
                        <strong>Views:</strong> ${course.views} | 
                        <strong>Time:</strong> ${course.time} minutes ago
                    `;
                    
                    // Actions column
                    const actionsCell = document.createElement('td');
                    actionsCell.className = 'actions';
                    actionsCell.innerHTML = `
                        <a class="view" href="${"{{ route('courses.show', ':id') }}".replace(':id', course.id)}" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a class="edit" href="${"{{ route('courses.edit', ':id') }}".replace(':id', course.id)}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="delete" onclick="deleteCourse(${course.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    
                    row.appendChild(thumbnailCell);
                    row.appendChild(detailsCell);
                    row.appendChild(actionsCell);
                    coursesList.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error loading courses:', error);
                const coursesList = document.getElementById('coursesList');
                coursesList.innerHTML = `
                    <tr>
                        <td colspan="3" style="text-align: center; color: #dc3545;">
                            Error loading courses. Please check the console for details.
                        </td>
                    </tr>
                `;
            });
    }
    
    // Delete course function
    function deleteCourse(id) {
        if (confirm('Are you sure you want to delete this course?')) {
            fetch(`{{ route('admin.deletecourse', ':id') }}`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error('Course not found. It may have been deleted.');
                    }
                    throw new Error('Failed to delete course');
                }
                return response.json();
            })
            .then(data => {
                showSuccessMessage(data.message || 'Course deleted successfully');
                loadCourses();
            })
            .catch(error => {
                console.error('Error deleting course:', error);
                alert(error.message || 'An error occurred while deleting the course.');
            });
        }
    }
    
    // Load courses on page load
    document.addEventListener('DOMContentLoaded', loadCourses);
</script>

@endsection
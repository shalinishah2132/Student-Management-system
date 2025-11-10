<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses - Student Management System</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .header p {
            margin: 10px 0 0 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .nav-buttons {
            padding: 20px 30px;
            border-bottom: 1px solid #e1e5e9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #dee2e6;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .content {
            padding: 30px;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .courses-table th,
        .courses-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .courses-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .courses-table tr:hover {
            background: #f8f9fa;
        }
        
        .no-courses {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }
        
        .btn-view {
            background: #17a2b8;
            color: white;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .duration-badge {
            background: #e9ecef;
            color: #495057;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Course Management</h1>
            <p>Manage courses and academic programs</p>
        </div>
        
        <div class="nav-buttons">
            <div style="display: flex; gap: 15px;">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">👥 Students</a>
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">🎓 Enrollments</a>
            </div>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">+ Add New Course</a>
        </div>
        
        <div class="content">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($courses->count() > 0)
                <table class="courses-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Duration</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td><strong>{{ $course->title }}</strong></td>
                                <td>{{ Str::limit($course->description, 50) ?: 'No description' }}</td>
                                <td>
                                    @if($course->duration)
                                        <span class="duration-badge">{{ $course->duration }}</span>
                                    @else
                                        <span class="text-muted">Not specified</span>
                                    @endif
                                </td>
                                <td>{{ $course->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-view btn-sm">View</a>
                                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-edit btn-sm">Edit</a>
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-courses">
                    <h3>No Courses Found</h3>
                    <p>Start by adding your first course to the system.</p>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">Add First Course</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

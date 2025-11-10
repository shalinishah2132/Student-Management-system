<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enrollments - Student Management System</title>
    
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
        
        .enrollments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .enrollments-table th,
        .enrollments-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .enrollments-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .enrollments-table tr:hover {
            background: #f8f9fa;
        }
        
        .no-enrollments {
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
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .student-name {
            font-weight: bold;
            color: #333;
        }
        
        .course-title {
            font-weight: bold;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Enrollment Management</h1>
            <p>Manage student course enrollments</p>
        </div>
        
        <div class="nav-buttons">
            <div style="display: flex; gap: 15px;">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">👥 Students</a>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">📚 Courses</a>
            </div>
            <a href="{{ route('enrollments.create') }}" class="btn btn-primary">+ Enroll Student</a>
        </div>
        
        <div class="content">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($enrollments->count() > 0)
                <table class="enrollments-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Enrolled On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            <tr>
                                <td>
                                    <div class="student-name">{{ $enrollment->student->student_name }}</div>
                                    <div style="color: #666; font-size: 0.9rem;">{{ $enrollment->student->student_email }}</div>
                                </td>
                                <td>
                                    <div class="course-title">{{ $enrollment->course->title }}</div>
                                    @if($enrollment->course->duration)
                                        <div style="color: #666; font-size: 0.9rem;">Duration: {{ $enrollment->course->duration }}</div>
                                    @endif
                                </td>
                                <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('enrollments.show', $enrollment) }}" class="btn btn-view btn-sm">View</a>
                                        <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this enrollment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete btn-sm">Remove</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-enrollments">
                    <h3>No Enrollments Found</h3>
                    <p>Start by enrolling students in courses.</p>
                    <a href="{{ route('enrollments.create') }}" class="btn btn-primary">Enroll First Student</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

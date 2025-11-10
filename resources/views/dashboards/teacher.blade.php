<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Dashboard - Student Management System</title>
    
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
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
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
            opacity: 0.8;
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
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .content {
            padding: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #ffc107;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 1rem;
            color: #666;
            font-weight: 600;
        }
        
        .recent-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e1e5e9;
        }
        
        .recent-list {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }
        
        .recent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .recent-item:last-child {
            border-bottom: none;
        }
        
        .recent-item-info {
            flex: 1;
        }
        
        .recent-item-name {
            font-weight: 600;
            color: #333;
        }
        
        .recent-item-detail {
            font-size: 0.9rem;
            color: #666;
        }
        
        .recent-item-date {
            font-size: 0.85rem;
            color: #999;
        }
        
        .teacher-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }
        
        .action-card {
            background: white;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.2s ease;
        }
        
        .action-card:hover {
            border-color: #ffc107;
            transform: translateY(-2px);
        }
        
        .action-card h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .action-card p {
            margin: 0 0 15px 0;
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">
            <h1>👩‍🏫 Teacher Dashboard</h1>
            <p>Manage your classes and students</p>
        </div>
        
        <div class="nav-buttons">
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">👥 My Students</a>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">📚 My Courses</a>
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">🎓 Enrollments</a>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
        
        <div class="content">
            <!-- Statistics Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_students'] }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_courses'] }}</div>
                    <div class="stat-label">Available Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_enrollments'] }}</div>
                    <div class="stat-label">Active Enrollments</div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="recent-section">
                <h3 class="section-title">Recent Students</h3>
                <div class="recent-list">
                    @forelse($stats['recent_students'] as $student)
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ $student->student_name }}</div>
                                <div class="recent-item-detail">{{ $student->student_email }} | Marks: {{ $student->total_marks }} | Rank: {{ $student->rank }}</div>
                            </div>
                            <div class="recent-item-date">{{ $student->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p>No students found.</p>
                    @endforelse
                </div>
            </div>
            
            <div class="recent-section">
                <h3 class="section-title">Recent Courses</h3>
                <div class="recent-list">
                    @forelse($stats['recent_courses'] as $course)
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ $course->title }}</div>
                                <div class="recent-item-detail">
                                    @if($course->description)
                                        {{ Str::limit($course->description, 50) }}
                                    @endif
                                    @if($course->duration)
                                        | Duration: {{ $course->duration }}
                                    @endif
                                </div>
                            </div>
                            <div class="recent-item-date">{{ $course->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p>No courses found.</p>
                    @endforelse
                </div>
            </div>
            
            <div class="recent-section">
                <h3 class="section-title">Recent Enrollments</h3>
                <div class="recent-list">
                    @forelse($stats['recent_enrollments'] as $enrollment)
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ $enrollment->student->student_name }}</div>
                                <div class="recent-item-detail">Enrolled in: {{ $enrollment->course->title }}</div>
                            </div>
                            <div class="recent-item-date">{{ $enrollment->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p>No enrollments found.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Teacher Actions -->
            <div class="teacher-actions">
                <div class="action-card">
                    <h4>Student Management</h4>
                    <p>View and manage student records and performance</p>
                    <a href="{{ route('students.index') }}" class="btn btn-primary">Manage Students</a>
                </div>
                
                <div class="action-card">
                    <h4>Course Management</h4>
                    <p>Create and update course information</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">Manage Courses</a>
                </div>
                
                <div class="action-card">
                    <h4>Class Enrollment</h4>
                    <p>Enroll students in courses and track progress</p>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-primary">Manage Enrollments</a>
                </div>
                
                <div class="action-card">
                    <h4>Add New Student</h4>
                    <p>Register new students to the system</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
                </div>
                
                <div class="action-card">
                    <h4>Create New Course</h4>
                    <p>Set up new courses for enrollment</p>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">Create Course</a>
                </div>
                
                <div class="action-card">
                    <h4>Enroll Student</h4>
                    <p>Quickly enroll students in available courses</p>
                    <a href="{{ route('enrollments.create') }}" class="btn btn-primary">Enroll Student</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

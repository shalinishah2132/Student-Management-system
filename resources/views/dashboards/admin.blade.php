<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Student Management System</title>
    
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #667eea;
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
        
        .admin-actions {
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
            border-color: #667eea;
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
        
            <h1>🛡️ Administrator Dashboard</h1>
            <p>Full system control and oversight</p>
        </div>
        
        <div class="nav-buttons">
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">👥 Manage Students</a>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">📚 Manage Courses</a>
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">🎓 Manage Enrollments</a>
                <a href="{{ route('setup.index') }}" class="btn btn-secondary">⚙️ System Setup</a>
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
                    <div class="stat-number">{{ $stats['total_users'] }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_students'] }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_courses'] }}</div>
                    <div class="stat-label">Total Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_enrollments'] }}</div>
                    <div class="stat-label">Total Enrollments</div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="recent-section">
                <h3 class="section-title">Recent Users</h3>
                <div class="recent-list">
                    @forelse($stats['recent_users'] as $user)
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ $user->name }}</div>
                                <div class="recent-item-detail">{{ $user->email }}</div>
                            </div>
                            <div class="recent-item-date">{{ $user->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p>No users found.</p>
                    @endforelse
                </div>
            </div>
            
            <div class="recent-section">
                <h3 class="section-title">Recent Students</h3>
                <div class="recent-list">
                    @forelse($stats['recent_students'] as $student)
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ $student->student_name }}</div>
                                <div class="recent-item-detail">{{ $student->student_email }} | Marks: {{ $student->total_marks }}</div>
                            </div>
                            <div class="recent-item-date">{{ $student->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p>No students found.</p>
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
            
            <!-- Admin Actions -->
            <div class="admin-actions">
                <div class="action-card">
                    <h4>User Management</h4>
                    <p>Manage user accounts and assign roles</p>
                    <a href="{{ route('setup.index') }}" class="btn btn-primary">Manage Users</a>
                </div>
                
                <div class="action-card">
                    <h4>Student Records</h4>
                    <p>Add, edit, and manage student information</p>
                    <a href="{{ route('students.index') }}" class="btn btn-primary">Manage Students</a>
                </div>
                
                <div class="action-card">
                    <h4>Course Catalog</h4>
                    <p>Create and manage course offerings</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">Manage Courses</a>
                </div>
                
                <div class="action-card">
                    <h4>Enrollment System</h4>
                    <p>Oversee student course enrollments</p>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-primary">Manage Enrollments</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

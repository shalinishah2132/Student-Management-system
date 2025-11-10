<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard - Student Management System</title>
    
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
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
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
        
        .profile-section {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid #17a2b8;
        }
        
        .profile-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .profile-item {
            text-align: center;
        }
        
        .profile-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        
        .profile-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135d, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #17a2b8;
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
            padding: 15px 0;
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
            margin-bottom: 5px;
        }
        
        .recent-item-detail {
            font-size: 0.9rem;
            color: #666;
        }
        
        .recent-item-date {
            font-size: 0.85rem;
            color: #999;
        }
        
        .student-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            border-color: #17a2b8;
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
        
        .welcome-message {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .welcome-message h3 {
            margin: 0 0 10px 0;
            color: #155724;
        }
        
        .welcome-message p {
            margin: 0;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 Student Dashboard</h1>
            <p>Your academic journey starts here</p>
        </div>
        
        <div class="nav-buttons">
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">👥 View Students</a>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">📚 Browse Courses</a>
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">🎓 View Enrollments</a>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
        
        <div class="content">
            <!-- Welcome Message -->
            <div class="welcome-message">
                <h3>Welcome, {{ $stats['user_info']->name }}! 👋</h3>
                <p>Here's your personalized dashboard to track your academic progress and explore available courses.</p>
            </div>
            
            <!-- Profile Information -->
            <div class="profile-section">
                <h3 style="margin: 0 0 20px 0; color: #333;">Your Profile</h3>
                <div class="profile-info">
                    <div class="profile-item">
                        <div class="profile-label">Full Name</div>
                        <div class="profile-value">{{ $stats['user_info']->name }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Email Address</div>
                        <div class="profile-value">{{ $stats['user_info']->email }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Member Since</div>
                        <div class="profile-value">{{ $stats['user_info']->created_at->format('M Y') }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Account Status</div>
                        <div class="profile-value" style="color: #28a745;">Active</div>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['available_courses'] }}</div>
                    <div class="stat-label">Available Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_students'] }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
            </div>
            
            <!-- Available Courses -->
            <div class="recent-section">
                <h3 class="section-title">Available Courses</h3>
                <div class="recent-list">
                    @forelse($stats['recent_courses'] as $course)
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ $course->title }}</div>
                                <div class="recent-item-detail">
                                    @if($course->description)
                                        {{ Str::limit($course->description, 80) }}
                                    @endif
                                    @if($course->duration)
                                        <br><strong>Duration:</strong> {{ $course->duration }}
                                    @endif
                                </div>
                            </div>
                            <div class="recent-item-date">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-primary btn-sm" style="padding: 8px 16px; font-size: 0.85rem;">View Details</a>
                            </div>
                        </div>
                    @empty
                        <p>No courses available at the moment.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Student Actions -->
            <div class="student-actions">
                <div class="action-card">
                    <h4>Browse All Courses</h4>
                    <p>Explore all available courses and find the perfect fit for your academic goals</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">Browse Courses</a>
                </div>
                
                <div class="action-card">
                    <h4>View Student Directory</h4>
                    <p>Connect with fellow students and see who's enrolled in the system</p>
                    <a href="{{ route('students.index') }}" class="btn btn-primary">Student Directory</a>
                </div>
                
                <div class="action-card">
                    <h4>Check Enrollments</h4>
                    <p>See current enrollment status and track academic progress</p>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-primary">View Enrollments</a>
                </div>
            </div>
            
            <!-- Academic Tips -->
            <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-top: 30px;">
                <h4 style="margin: 0 0 15px 0; color: #333;">📚 Academic Tips</h4>
                <ul style="margin: 0; padding-left: 20px; color: #666;">
                    <li>Stay organized with your course schedule</li>
                    <li>Participate actively in class discussions</li>
                    <li>Don't hesitate to ask questions</li>
                    <li>Form study groups with fellow students</li>
                    <li>Keep track of assignment deadlines</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>

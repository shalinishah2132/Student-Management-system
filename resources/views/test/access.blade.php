<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Test - Student Management System</title>
    
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
            max-width: 800px;
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
        
        .content {
            padding: 30px;
        }
        
        .info-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .permission-list {
            list-style: none;
            padding: 0;
        }
        
        .permission-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .permission-list li:last-child {
            border-bottom: none;
        }
        
        .yes { color: #28a745; font-weight: bold; }
        .no { color: #dc3545; font-weight: bold; }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        
        .test-links {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Access Test</h1>
            <p>Check your current permissions and access levels</p>
        </div>
        
        <div class="content">
            <div class="info-card">
                <h3>👤 User Information</h3>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Roles:</strong> 
                    @if($roles->count() > 0)
                        {{ $roles->pluck('display_name')->implode(', ') }}
                    @else
                        <span class="no">No roles assigned</span>
                    @endif
                </p>
            </div>
            
            <div class="info-card">
                <h3>🎭 Role Status</h3>
                <ul class="permission-list">
                    <li>Is Admin: <span class="{{ $is_admin ? 'yes' : 'no' }}">{{ $is_admin ? 'YES' : 'NO' }}</span></li>
                    <li>Is Teacher: <span class="{{ $is_teacher ? 'yes' : 'no' }}">{{ $is_teacher ? 'YES' : 'NO' }}</span></li>
                    <li>Is Student: <span class="{{ $is_student ? 'yes' : 'no' }}">{{ $is_student ? 'YES' : 'NO' }}</span></li>
                </ul>
            </div>
            
            <div class="info-card">
                <h3>🔑 Create Permissions</h3>
                <ul class="permission-list">
                    <li>Can Create Students: <span class="{{ $can_create_students ? 'yes' : 'no' }}">{{ $can_create_students ? 'YES' : 'NO' }}</span></li>
                    <li>Can Create Courses: <span class="{{ $can_create_courses ? 'yes' : 'no' }}">{{ $can_create_courses ? 'YES' : 'NO' }}</span></li>
                    <li>Can Create Enrollments: <span class="{{ $can_create_enrollments ? 'yes' : 'no' }}">{{ $can_create_enrollments ? 'YES' : 'NO' }}</span></li>
                </ul>
            </div>
            
            <div class="info-card">
                <h3>📋 All Permissions</h3>
                <ul class="permission-list">
                    @forelse($permissions as $permission)
                        <li>✅ {{ $permission->display_name }} ({{ $permission->name }})</li>
                    @empty
                        <li class="no">No permissions assigned</li>
                    @endforelse
                </ul>
            </div>
            
            <div class="test-links">
                <h3>🧪 Test Create Access</h3>
                <p>Try clicking these links to test your create access:</p>
                
                <a href="{{ route('students.create') }}" class="btn">Create Student</a>
                <a href="{{ route('courses.create') }}" class="btn">Create Course</a>
                <a href="{{ route('enrollments.create') }}" class="btn">Create Enrollment</a>
                
                <br><br>
                
                <a href="{{ route('dashboard') }}" class="btn">← Back to Dashboard</a>
                <a href="{{ route('setup.index') }}" class="btn">System Setup</a>
            </div>
        </div>
    </div>
</body>
</html>

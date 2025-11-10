<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students - Student Management System</title>
    
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
        
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .students-table th,
        .students-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .students-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .students-table tr:hover {
            background: #f8f9fa;
        }
        
        .rank-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .rank-first {
            background: #d4edda;
            color: #155724;
        }
        
        .rank-second {
            background: #cce7ff;
            color: #004085;
        }
        
        .rank-third {
            background: #fff3cd;
            color: #856404;
        }
        
        .rank-fail {
            background: #f8d7da;
            color: #721c24;
        }
        
        .no-students {
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
        
        .btn-edit {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="header">
            <h1>Student Management</h1>
            <p>Manage your students efficiently and track their performance</p>
        </div>
        
        <div class="nav-buttons">
            <div style="display: flex; gap: 15px;">
                <a href="{{ url('/') }}" class="btn btn-secondary">← Back to Home</a>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">📚 Courses</a>
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">🎓 Enrollments</a>
            </div>
            <a href="{{ route('students.create') }}" class="btn btn-primary">+ Add New Student</a>
        </div>
        
        <div class="content">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($students->count() > 0)
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Marks</th>
                            <th>Rank</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->student_name }}</td>
                                <td>{{ $student->student_email }}</td>
                                <td>{{ $student->student_phone ?? 'N/A' }}</td>
                                <td><strong>{{ $student->total_marks }}</strong></td>
                                <td>
                                    <span class="rank-badge 
                                        @if($student->rank == 'First Class') rank-first
                                        @elseif($student->rank == 'Second Class') rank-second
                                        @elseif($student->rank == 'Third Class') rank-third
                                        @else rank-fail
                                        @endif">
                                        {{ $student->rank ?? 'Not Ranked' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('students.show', $student) }}" class="btn btn-edit btn-sm">View</a>
                                        <a href="{{ route('students.edit', $student) }}" class="btn btn-edit btn-sm">Edit</a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this student?')">
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
                <div class="no-students">
                    <h3>No Students Found</h3>
                    <p>Start by adding your first student to the system.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">Add First Student</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

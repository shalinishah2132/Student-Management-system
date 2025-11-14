<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Details - Student Management System</title>
    
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
            max-width: 600px;
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
            font-size: 2rem;
            font-weight: 700;
        }
        
        .header p {
            margin: 10px 0 0 0;
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }
        
        .detail-value {
            color: #666;
            font-size: 1rem;
        }
        
        .rank-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
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
        
        .marks-display {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
        }
        
        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
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
        
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .student-id {
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.9rem;
        }
        
        .timestamps {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
            font-size: 0.85rem;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Student Details</h1>
            <p>View student information</p>
        </div>
        
        <div class="content">
            <div class="detail-row">
                <span class="detail-label">Student ID:</span>
                <span class="detail-value student-id">{{ $student->id }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Full Name:</span>
                <span class="detail-value">{{ $student->student_name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Email Address:</span>
                <span class="detail-value">{{ $student->student_email }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Phone Number:</span>
                <span class="detail-value">{{ $student->student_phone ?? 'Not provided' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Total Marks:</span>
                <span class="detail-value marks-display">{{ $student->total_marks }}/500</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Rank:</span>
                <span class="detail-value">
                    <span class="rank-badge 
                        @if($student->rank == 'First Class') rank-first
                        @elseif($student->rank == 'Second Class') rank-second
                        @elseif($student->rank == 'Third Class') rank-third
                        @else rank-fail
                        @endif">
                        {{ $student->rank ?? 'Not Ranked' }}
                    </span>
                </span>
            </div>
            
            <div class="timestamps">
                <div class="detail-row">
                    <span class="detail-label">Added on:</span>
                    <span class="detail-value">{{ $student->created_at->format('M d, Y \a\t g:i A') }}</span>
                </div>
                
                @if($student->updated_at != $student->created_at)
                    <div class="detail-row">
                        <span class="detail-label">Last updated:</span>
                        <span class="detail-value">{{ $student->updated_at->format('M d, Y \a\t g:i A') }}</span>
                    </div>
                @endif
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">← Back to List</a>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit Student</a>
                <a href="{{ route('students.edit-address', $student) }}" class="btn" style="background: #17a2b8; color: white;">Edit Address</a>

                <form action="{{ route('students.destroy', $student) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: #dc3545; color: white;">Delete</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enrollment Details - Student Management System</title>
    
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
        
        .detail-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e1e5e9;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .detail-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .detail-label {
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: #333;
            font-size: 1rem;
        }
        
        .description-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            margin-top: 10px;
        }
        
        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
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
        
        .enrollment-badge {
            background: #d4edda;
            color: #155724;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Enrollment Details</h1>
            <p>Student Course Enrollment Information</p>
        </div>
        
        <div class="content">
            <!-- Enrollment Status -->
            <div class="detail-section">
                <h3 class="section-title">Enrollment Status</h3>
                <div style="text-align: center; margin-bottom: 20px;">
                    <span class="enrollment-badge">Active Enrollment</span>
                </div>
            </div>
            
            <!-- Student Information -->
            <div class="detail-section">
                <h3 class="section-title">Student Information</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Student Name</div>
                        <div class="detail-value">{{ $enrollment->student->student_name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">
                            <a href="mailto:{{ $enrollment->student->student_email }}" style="color: #667eea;">
                                {{ $enrollment->student->student_email }}
                            </a>
                        </div>
                    </div>
                    @if($enrollment->student->student_phone)
                        <div class="detail-item">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value">{{ $enrollment->student->student_phone }}</div>
                        </div>
                    @endif
                    <div class="detail-item">
                        <div class="detail-label">Total Marks</div>
                        <div class="detail-value">{{ $enrollment->student->total_marks }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Rank</div>
                        <div class="detail-value">{{ $enrollment->student->rank_display }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Course Information -->
            <div class="detail-section">
                <h3 class="section-title">Course Information</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Course Title</div>
                        <div class="detail-value">{{ $enrollment->course->title }}</div>
                    </div>
                    @if($enrollment->course->duration)
                        <div class="detail-item">
                            <div class="detail-label">Duration</div>
                            <div class="detail-value">{{ $enrollment->course->duration }}</div>
                        </div>
                    @endif
                    <div class="detail-item">
                        <div class="detail-label">Enrolled Students</div>
                        <div class="detail-value">{{ $enrollment->course->enrolled_count }} students</div>
                    </div>
                </div>
                
                @if($enrollment->course->description)
                    <div class="description-box">
                        <strong>Course Description:</strong><br>
                        {{ $enrollment->course->description }}
                    </div>
                @endif
            </div>
            
            <!-- Enrollment Details -->
            <div class="detail-section">
                <h3 class="section-title">Enrollment Details</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Enrolled On</div>
                        <div class="detail-value">{{ $enrollment->created_at->format('M d, Y \a\t g:i A') }}</div>
                    </div>
                    @if($enrollment->updated_at != $enrollment->created_at)
                        <div class="detail-item">
                            <div class="detail-label">Last Updated</div>
                            <div class="detail-value">{{ $enrollment->updated_at->format('M d, Y \a\t g:i A') }}</div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">← Back to Enrollments</a>
                <a href="{{ route('students.show', $enrollment->student) }}" class="btn btn-secondary">View Student</a>
                <a href="{{ route('courses.show', $enrollment->course) }}" class="btn btn-secondary">View Course</a>
                <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this enrollment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Remove Enrollment</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

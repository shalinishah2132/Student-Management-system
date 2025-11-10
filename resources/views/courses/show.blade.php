<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course Details - Student Management System</title>
    
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
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .duration-badge {
            background: #e9ecef;
            color: #495057;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $course->title }}</h1>
            <p>Course Details & Information</p>
        </div>
        
        <div class="content">
            <!-- Basic Information -->
            <div class="detail-section">
                <h3 class="section-title">Course Information</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Course Title</div>
                        <div class="detail-value">{{ $course->title }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Duration</div>
                        <div class="detail-value">
                            @if($course->duration)
                                <span class="duration-badge">{{ $course->duration }}</span>
                            @else
                                <span style="color: #666;">Not specified</span>
                            @endif
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Created On</div>
                        <div class="detail-value">{{ $course->created_at->format('M d, Y \a\t g:i A') }}</div>
                    </div>
                    @if($course->updated_at != $course->created_at)
                        <div class="detail-item">
                            <div class="detail-label">Last Updated</div>
                            <div class="detail-value">{{ $course->updated_at->format('M d, Y \a\t g:i A') }}</div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Description -->
            @if($course->description)
                <div class="detail-section">
                    <h3 class="section-title">Course Description</h3>
                    <div class="description-box">
                        {{ $course->description }}
                    </div>
                </div>
            @endif
            
            <div class="action-buttons">
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">← Back to Courses</a>
                <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">Edit Course</a>
                <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this course?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Course</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

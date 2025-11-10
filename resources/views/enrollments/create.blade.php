<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enroll Student - Student Management System</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-header h1 {
            color: #333;
            margin: 0 0 10px 0;
            font-size: 2rem;
            font-weight: 700;
        }
        
        .form-header p {
            color: #666;
            margin: 0;
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            background: white;
        }
        
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group select.error {
            border-color: #e74c3c;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
        }
        
        .back-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e1e5e9;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .student-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .course-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .loading-message {
            background: #e3f2fd;
            color: #1976d2;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            margin-top: 10px;
            text-align: center;
        }
        
        .no-courses-message {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Enroll Student in Course</h1>
            <p>Select student and course for enrollment</p>
        </div>
        
        <form method="POST" action="{{ route('enrollments.store') }}">
            @csrf
            
            @if($errors->has('error'))
                <div class="error-message" style="background: #f8d7da; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ $errors->first('error') }}
                </div>
            @endif
            
            <!-- Student Selection -->
            <div class="form-group">
                <label for="student_id">Select Student</label>
                <select 
                    id="student_id" 
                    name="student_id" 
                    class="{{ $errors->has('student_id') ? 'error' : '' }}"
                    required
                    onchange="showStudentInfo(this)"
                >
                    <option value="">Choose a student...</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" 
                                data-email="{{ $student->student_email }}"
                                data-phone="{{ $student->student_phone }}"
                                {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->student_name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('student_id'))
                    <div class="error-message">{{ $errors->first('student_id') }}</div>
                @endif
                <div id="student-info" class="student-info" style="display: none; margin-top: 10px;"></div>
            </div>
            
            <!-- Course Selection -->
            <div class="form-group">
                <label for="course_id">Select Course</label>
                <select 
                    id="course_id" 
                    name="course_id" 
                    class="{{ $errors->has('course_id') ? 'error' : '' }}"
                    required
                    onchange="showCourseInfo(this)"
                >
                    <option value="">Choose a course...</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" 
                                data-description="{{ $course->description }}"
                                data-duration="{{ $course->duration }}"
                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <div class="error-message">{{ $errors->first('course_id') }}</div>
                @endif
                <div id="course-info" class="course-info" style="display: none; margin-top: 10px;"></div>
                <div id="course-loading" class="loading-message" style="display: none;">Loading available courses...</div>
                <div id="no-courses" class="no-courses-message" style="display: none;">This student is already enrolled in all available courses.</div>
            </div>
            
            <button type="submit" class="submit-btn">Enroll Student</button>
        </form>
        
        <div class="back-link">
            <a href="{{ route('enrollments.index') }}">← Back to Enrollments</a>
        </div>
    </div>

    <script>
        function showStudentInfo(select) {
            const infoDiv = document.getElementById('student-info');
            const selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption.value) {
                const email = selectedOption.getAttribute('data-email');
                const phone = selectedOption.getAttribute('data-phone');
                infoDiv.innerHTML = `<strong>Email:</strong> ${email}<br><strong>Phone:</strong> ${phone || 'Not provided'}`;
                infoDiv.style.display = 'block';
            } else {
                infoDiv.style.display = 'none';
            }
        }
        
        function showCourseInfo(select) {
            const infoDiv = document.getElementById('course-info');
            const selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption.value) {
                const description = selectedOption.getAttribute('data-description');
                const duration = selectedOption.getAttribute('data-duration');
                let info = '';
                if (description) info += `<strong>Description:</strong> ${description}<br>`;
                if (duration) info += `<strong>Duration:</strong> ${duration}`;
                infoDiv.innerHTML = info || 'No additional information available';
                infoDiv.style.display = 'block';
            } else {
                infoDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>

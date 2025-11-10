<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student - Student Management System</title>
    
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
            max-width: 500px;
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
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group input.error {
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
        
        .current-rank {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin-top: 5px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .rank-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 5px;
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
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Edit Student</h1>
            <p>Update student information</p>
        </div>
        
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PUT')
            
            <!-- Student Name -->
            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input 
                    type="text" 
                    id="student_name" 
                    name="student_name" 
                    value="{{ old('student_name', $student->student_name) }}" 
                    class="{{ $errors->has('student_name') ? 'error' : '' }}"
                    required 
                    autofocus
                    placeholder="Enter full name"
                >
                @if($errors->has('student_name'))
                    <div class="error-message">{{ $errors->first('student_name') }}</div>
                @endif
            </div>
            
            <!-- Email -->
            <div class="form-group">
                <label for="student_email">Email Address</label>
                <input 
                    type="email" 
                    id="student_email" 
                    name="student_email" 
                    value="{{ old('student_email', $student->student_email) }}" 
                    class="{{ $errors->has('student_email') ? 'error' : '' }}"
                    required
                    placeholder="Enter email address"
                >
                @if($errors->has('student_email'))
                    <div class="error-message">{{ $errors->first('student_email') }}</div>
                @endif
            </div>
            
            <!-- Phone -->
            <div class="form-group">
                <label for="student_phone">Phone Number</label>
                <input 
                    type="tel" 
                    id="student_phone" 
                    name="student_phone" 
                    value="{{ old('student_phone', $student->student_phone) }}" 
                    class="{{ $errors->has('student_phone') ? 'error' : '' }}"
                    placeholder="Enter phone number (optional)"
                >
                @if($errors->has('student_phone'))
                    <div class="error-message">{{ $errors->first('student_phone') }}</div>
                @endif
            </div>
            
            <!-- Total Marks -->
            <div class="form-group">
                <label for="total_marks">Total Marks</label>
                <input 
                    type="number" 
                    id="total_marks" 
                    name="total_marks" 
                    value="{{ old('total_marks', $student->total_marks) }}" 
                    class="{{ $errors->has('total_marks') ? 'error' : '' }}"
                    required
                    min="0"
                    max="500"
                    placeholder="Enter total marks (0-500)"
                >
                @if($errors->has('total_marks'))
                    <div class="error-message">{{ $errors->first('total_marks') }}</div>
                @endif
                
                @if($student->rank)
                    <div class="current-rank">
                        Current Rank: 
                        <span class="rank-badge 
                            @if($student->rank == 'First Class') rank-first
                            @elseif($student->rank == 'Second Class') rank-second
                            @elseif($student->rank == 'Third Class') rank-third
                            @else rank-fail
                            @endif">
                            {{ $student->rank }}
                        </span>
                    </div>
                @endif
            </div>
            
            <button type="submit" class="submit-btn">Update Student</button>
        </form>
        
        <div class="back-link">
            <a href="{{ route('students.index') }}">← Back to Students List</a>
        </div>
    </div>
</body>
</html>

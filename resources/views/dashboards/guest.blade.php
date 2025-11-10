<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - Student Management System</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            color: #333;
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
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 50px 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 2.8rem;
            font-weight: 800;
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 15px auto 0;
            line-height: 1.6;
        }
        
        .content {
            padding: 40px;
        }
        
        .welcome-section {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .welcome-section h2 {
            color: #4f46e5;
            margin-bottom: 20px;
            font-size: 2rem;
        }
        
        .welcome-section p {
            font-size: 1.1rem;
            color: #4b5563;
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.7;
        }
        
        .auth-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: #4f46e5;
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid #4f46e5;
            color: #4f46e5;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }
        
        .feature-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #4f46e5;
        }
        
        .feature-card h3 {
            color: #1f2937;
            margin: 0 0 15px 0;
        }
        
        .feature-card p {
            color: #6b7280;
            margin: 0;
            line-height: 1.6;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 50px 0;
            text-align: center;
        }
        
        .stat-item h3 {
            font-size: 2.5rem;
            color: #4f46e5;
            margin: 0 0 10px 0;
        }
        
        .stat-item p {
            color: #6b7280;
            margin: 0;
            font-weight: 600;
        }
        
        .footer {
            text-align: center;
            padding: 30px;
            border-top: 1px solid #e5e7eb;
            margin-top: 50px;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2.2rem;
            }
            
            .auth-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Student Management System</h1>
            <p>Streamline your academic journey with our comprehensive student management platform. 
                Access courses, track progress, and connect with educators – all in one place.</p>
            
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline">Register</a>
            </div>
        </div>
        
        <div class="content">
            <div class="welcome-section">
                <h2>Why Choose Our Platform?</h2>
                <p>Our student management system is designed to make education more accessible, organized, and efficient for everyone involved in the learning process.</p>
            </div>
            
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Track Progress</h3>
                    <p>Monitor your academic performance with detailed analytics and progress reports.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h3>Access Courses</h3>
                    <p>Browse and enroll in a variety of courses tailored to your educational needs.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">👨‍🏫</div>
                    <h3>Expert Instructors</h3>
                    <p>Learn from experienced educators dedicated to your success.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Anywhere Access</h3>
                    <p>Access your courses and materials from any device, anytime, anywhere.</p>
                </div>
            </div>
            
            <div class="stats">
                <div class="stat-item">
                    <h3>{{ $stats['total_courses'] ?? '50+' }}</h3>
                    <p>Courses Available</p>
                </div>
                <div class="stat-item">
                    <h3>{{ $stats['total_students'] ?? '1000+' }}</h3>
                    <p>Active Students</p>
                </div>
                <div class="stat-item">
                    <h3>24/7</h3>
                    <p>Support Available</p>
                </div>
                <div class="stat-item">
                    <h3>99%</h3>
                    <p>Satisfaction Rate</p>
                </div>
            </div>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} Student Management System. All rights reserved.
        </div>
    </div>
</body>
</html>
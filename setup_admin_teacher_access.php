<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

echo "=== Setting up Admin and Teacher Create Access ===\n\n";

// Step 1: Create all required permissions
echo "1. Creating/updating permissions...\n";
$permissions = [
    'view_students' => 'View Students',
    'create_students' => 'Create Students', 
    'edit_students' => 'Edit Students',
    'delete_students' => 'Delete Students',
    'view_courses' => 'View Courses',
    'create_courses' => 'Create Courses',
    'edit_courses' => 'Edit Courses', 
    'delete_courses' => 'Delete Courses',
    'view_enrollments' => 'View Enrollments',
    'create_enrollments' => 'Create Enrollments',
    'delete_enrollments' => 'Delete Enrollments',
    'manage_users' => 'Manage Users'
];

foreach ($permissions as $name => $display) {
    Permission::firstOrCreate(['name' => $name], [
        'name' => $name,
        'display_name' => $display,
        'description' => "Permission to {$display}"
    ]);
}
echo "✅ " . count($permissions) . " permissions created/updated\n";

// Step 2: Create Admin role with ALL permissions
echo "2. Setting up Admin role...\n";
$adminRole = Role::firstOrCreate(['name' => 'admin'], [
    'name' => 'admin',
    'display_name' => 'Administrator', 
    'description' => 'Full system access with all permissions'
]);

$allPermissions = Permission::all();
$adminRole->permissions()->sync($allPermissions->pluck('id'));
echo "✅ Admin role has {$allPermissions->count()} permissions\n";

// Step 3: Create Teacher role with create permissions
echo "3. Setting up Teacher role...\n";
$teacherRole = Role::firstOrCreate(['name' => 'teacher'], [
    'name' => 'teacher',
    'display_name' => 'Teacher', 
    'description' => 'Can manage students, courses, and enrollments'
]);

// Teacher gets all permissions EXCEPT manage_users
$teacherPermissions = Permission::where('name', '!=', 'manage_users')->get();
$teacherRole->permissions()->sync($teacherPermissions->pluck('id'));
echo "✅ Teacher role has {$teacherPermissions->count()} permissions (all except user management)\n";

// Step 4: Create Student role (view only)
echo "4. Setting up Student role...\n";
$studentRole = Role::firstOrCreate(['name' => 'student'], [
    'name' => 'student',
    'display_name' => 'Student', 
    'description' => 'Limited access to view information'
]);

$studentPermissions = Permission::whereIn('name', [
    'view_students', 'view_courses', 'view_enrollments'
])->get();
$studentRole->permissions()->sync($studentPermissions->pluck('id'));
echo "✅ Student role has {$studentPermissions->count()} view-only permissions\n";

// Step 5: Show what each role can do
echo "\n=== Permission Summary ===\n";

echo "\n🛡️ ADMIN can:\n";
foreach ($adminRole->permissions as $perm) {
    echo "  ✅ {$perm->display_name}\n";
}

echo "\n👩‍🏫 TEACHER can:\n";
foreach ($teacherRole->permissions as $perm) {
    echo "  ✅ {$perm->display_name}\n";
}

echo "\n🎓 STUDENT can:\n";
foreach ($studentRole->permissions as $perm) {
    echo "  ✅ {$perm->display_name}\n";
}

// Step 6: Assign roles to users
echo "\n5. Assigning roles to users...\n";
$users = User::all();

if ($users->count() > 0) {
    // Make first user admin
    $firstUser = $users->first();
    $firstUser->roles()->sync([$adminRole->id]);
    echo "✅ {$firstUser->email} is now an Administrator\n";
    
    // If there are more users, you can assign different roles
    if ($users->count() > 1) {
        $secondUser = $users->skip(1)->first();
        $secondUser->roles()->sync([$teacherRole->id]);
        echo "✅ {$secondUser->email} is now a Teacher\n";
    }
    
    if ($users->count() > 2) {
        $thirdUser = $users->skip(2)->first();
        $thirdUser->roles()->sync([$studentRole->id]);
        echo "✅ {$thirdUser->email} is now a Student\n";
    }
} else {
    echo "❌ No users found! Please register some users first.\n";
}

echo "\n=== CREATE ACCESS VERIFICATION ===\n";
echo "Both Admin and Teacher roles now have access to:\n";
echo "  ✅ Create Students (/students/create)\n";
echo "  ✅ Create Courses (/courses/create)\n";
echo "  ✅ Create Enrollments (/enrollments/create)\n";
echo "  ✅ Edit and Delete all records\n";

echo "\nOnly Admin has access to:\n";
echo "  ✅ Manage Users (/setup)\n";

echo "\nStudents can only:\n";
echo "  👀 View Students, Courses, and Enrollments\n";

echo "\n✅ Setup complete!\n";
echo "Now login as Admin or Teacher and try accessing:\n";
echo "  - http://localhost:8000/students/create\n";
echo "  - http://localhost:8000/courses/create\n";
echo "  - http://localhost:8000/enrollments/create\n";

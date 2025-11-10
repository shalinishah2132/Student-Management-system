<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;
use App\Models\Permission;

echo "=== Updating Teacher and Admin Permissions ===\n\n";

// Get roles
$adminRole = Role::where('name', 'admin')->first();
$teacherRole = Role::where('name', 'teacher')->first();
$studentRole = Role::where('name', 'student')->first();

if (!$adminRole || !$teacherRole || !$studentRole) {
    echo "❌ Roles not found! Please run the seeder first.\n";
    exit;
}

// Ensure all required permissions exist
$requiredPermissions = [
    ['name' => 'view_students', 'display_name' => 'View Students', 'description' => 'Can view student list and details'],
    ['name' => 'create_students', 'display_name' => 'Create Students', 'description' => 'Can create new students'],
    ['name' => 'edit_students', 'display_name' => 'Edit Students', 'description' => 'Can edit student information'],
    ['name' => 'delete_students', 'display_name' => 'Delete Students', 'description' => 'Can delete students'],
    ['name' => 'view_courses', 'display_name' => 'View Courses', 'description' => 'Can view course list and details'],
    ['name' => 'create_courses', 'display_name' => 'Create Courses', 'description' => 'Can create new courses'],
    ['name' => 'edit_courses', 'display_name' => 'Edit Courses', 'description' => 'Can edit course information'],
    ['name' => 'delete_courses', 'display_name' => 'Delete Courses', 'description' => 'Can delete courses'],
    ['name' => 'view_enrollments', 'display_name' => 'View Enrollments', 'description' => 'Can view enrollment list and details'],
    ['name' => 'create_enrollments', 'display_name' => 'Create Enrollments', 'description' => 'Can enroll students in courses'],
    ['name' => 'delete_enrollments', 'display_name' => 'Delete Enrollments', 'description' => 'Can remove student enrollments'],
    ['name' => 'manage_users', 'display_name' => 'Manage Users', 'description' => 'Can manage user accounts and roles'],
];

foreach ($requiredPermissions as $permData) {
    Permission::firstOrCreate(['name' => $permData['name']], $permData);
}

// Admin gets ALL permissions
$allPermissions = Permission::all();
$adminRole->permissions()->sync($allPermissions->pluck('id'));
echo "✅ Admin role updated with ALL permissions (" . $allPermissions->count() . " permissions)\n";

// Teacher gets all permissions EXCEPT manage_users
$teacherPermissions = Permission::where('name', '!=', 'manage_users')->get();
$teacherRole->permissions()->sync($teacherPermissions->pluck('id'));
echo "✅ Teacher role updated with permissions (" . $teacherPermissions->count() . " permissions)\n";

// Student gets only view permissions
$studentPermissions = Permission::whereIn('name', [
    'view_students', 'view_courses', 'view_enrollments'
])->get();
$studentRole->permissions()->sync($studentPermissions->pluck('id'));
echo "✅ Student role updated with view-only permissions (" . $studentPermissions->count() . " permissions)\n";

echo "\n=== Permission Summary ===\n";
echo "Admin permissions:\n";
foreach ($adminRole->permissions as $perm) {
    echo "  - {$perm->display_name} ({$perm->name})\n";
}

echo "\nTeacher permissions:\n";
foreach ($teacherRole->permissions as $perm) {
    echo "  - {$perm->display_name} ({$perm->name})\n";
}

echo "\nStudent permissions:\n";
foreach ($studentRole->permissions as $perm) {
    echo "  - {$perm->display_name} ({$perm->name})\n";
}

echo "\n✅ All permissions updated successfully!\n";
echo "\nTeachers and Admins now have access to:\n";
echo "  - Create new students\n";
echo "  - Create new courses\n";
echo "  - Enroll students in courses\n";
echo "  - Edit and delete students/courses\n";
echo "  - View all system data\n";

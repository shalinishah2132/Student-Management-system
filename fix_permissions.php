<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

echo "=== Fixing User Permissions ===\n\n";

// First, let's see what users exist
$users = User::all();
echo "Available Users:\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Email: {$user->email} | Name: {$user->name}\n";
    $roles = $user->roles;
    if ($roles->count() > 0) {
        echo "  Current roles: " . $roles->pluck('display_name')->implode(', ') . "\n";
    } else {
        echo "  No roles assigned!\n";
    }
}

echo "\n";

// Get the first user (or you can specify a specific email)
$user = User::first();
if (!$user) {
    echo "No users found!\n";
    exit;
}

echo "Working with user: {$user->email}\n\n";

// Create roles and permissions if they don't exist
echo "Creating/updating roles and permissions...\n";

// Create permissions
$permissions = [
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

foreach ($permissions as $permData) {
    Permission::firstOrCreate(['name' => $permData['name']], $permData);
}

// Create admin role
$adminRole = Role::firstOrCreate(
    ['name' => 'admin'],
    [
        'display_name' => 'Administrator',
        'description' => 'Full system access with all permissions'
    ]
);

// Assign ALL permissions to admin role
$allPermissions = Permission::all();
$adminRole->permissions()->sync($allPermissions->pluck('id'));

echo "✅ Admin role created with " . $allPermissions->count() . " permissions\n";

// Remove any existing roles from the user
$user->roles()->detach();

// Assign admin role to the user
$user->roles()->attach($adminRole->id);

echo "✅ Admin role assigned to user: {$user->email}\n";

// Verify the assignment
$user->load('roles.permissions');
echo "\nUser's current roles:\n";
foreach ($user->roles as $role) {
    echo "- {$role->display_name} ({$role->name})\n";
    echo "  Permissions: " . $role->permissions->count() . "\n";
}

// Test specific permissions
echo "\nTesting key permissions:\n";
echo "- Can create courses: " . ($user->hasPermission('create_courses') ? 'YES' : 'NO') . "\n";
echo "- Can create students: " . ($user->hasPermission('create_students') ? 'YES' : 'NO') . "\n";
echo "- Can create enrollments: " . ($user->hasPermission('create_enrollments') ? 'YES' : 'NO') . "\n";

echo "\n✅ Done! User should now have full access to create courses, students, and enrollments.\n";
echo "Try accessing /courses/create again.\n";

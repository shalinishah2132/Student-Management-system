<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

echo "=== Quick Setup for Permissions ===\n\n";

// Step 1: Create all required permissions
echo "1. Creating permissions...\n";
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
echo "✅ " . count($permissions) . " permissions created\n";

// Step 2: Create admin role
echo "2. Creating admin role...\n";
$adminRole = Role::firstOrCreate(['name' => 'admin'], [
    'name' => 'admin',
    'display_name' => 'Administrator', 
    'description' => 'Full system access'
]);

// Step 3: Assign ALL permissions to admin
$allPermissions = Permission::all();
$adminRole->permissions()->sync($allPermissions->pluck('id'));
echo "✅ Admin role created with {$allPermissions->count()} permissions\n";

// Step 4: Get first user and make them admin
$user = User::first();
if ($user) {
    echo "3. Assigning admin role to user: {$user->email}\n";
    
    // Clear existing roles
    $user->roles()->detach();
    
    // Assign admin role
    $user->roles()->attach($adminRole->id);
    
    // Verify
    $user->load('roles.permissions');
    echo "✅ User now has " . $user->roles->count() . " role(s)\n";
    
    // Test permissions
    echo "4. Testing permissions...\n";
    echo "   - Can create courses: " . ($user->hasPermission('create_courses') ? 'YES' : 'NO') . "\n";
    echo "   - Can create students: " . ($user->hasPermission('create_students') ? 'YES' : 'NO') . "\n";
    echo "   - Can create enrollments: " . ($user->hasPermission('create_enrollments') ? 'YES' : 'NO') . "\n";
    echo "   - Is admin: " . ($user->isAdmin() ? 'YES' : 'NO') . "\n";
    
} else {
    echo "❌ No users found!\n";
}

echo "\n✅ Setup complete!\n";
echo "Now try accessing: http://localhost:8000/courses/create\n";

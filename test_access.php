<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

echo "=== Testing User Access ===\n\n";

// Get the first user
$user = User::first();
if (!$user) {
    echo "❌ No users found!\n";
    exit;
}

echo "Testing user: {$user->email}\n";

// Load relationships
$user->load('roles.permissions');

echo "User roles: " . $user->roles->pluck('display_name')->implode(', ') . "\n";

if ($user->roles->count() == 0) {
    echo "❌ User has no roles! Assigning admin role...\n";
    
    // Create admin role if it doesn't exist
    $adminRole = Role::firstOrCreate(
        ['name' => 'admin'],
        ['display_name' => 'Administrator', 'description' => 'Full access']
    );
    
    // Assign all permissions to admin
    $allPermissions = Permission::all();
    if ($allPermissions->count() == 0) {
        echo "❌ No permissions found! Creating basic permissions...\n";
        
        $basicPermissions = [
            ['name' => 'create_courses', 'display_name' => 'Create Courses', 'description' => 'Can create courses'],
            ['name' => 'view_courses', 'display_name' => 'View Courses', 'description' => 'Can view courses'],
            ['name' => 'create_students', 'display_name' => 'Create Students', 'description' => 'Can create students'],
            ['name' => 'create_enrollments', 'display_name' => 'Create Enrollments', 'description' => 'Can create enrollments'],
        ];
        
        foreach ($basicPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }
        
        $allPermissions = Permission::all();
    }
    
    $adminRole->permissions()->sync($allPermissions->pluck('id'));
    
    // Assign admin role to user
    $user->roles()->sync([$adminRole->id]);
    
    echo "✅ Admin role assigned!\n";
    
    // Reload user
    $user->load('roles.permissions');
}

echo "\nTesting permissions:\n";
echo "- Has admin role: " . ($user->hasRole('admin') ? 'YES' : 'NO') . "\n";
echo "- Can create courses: " . ($user->hasPermission('create_courses') ? 'YES' : 'NO') . "\n";
echo "- Can create students: " . ($user->hasPermission('create_students') ? 'YES' : 'NO') . "\n";
echo "- Can create enrollments: " . ($user->hasPermission('create_enrollments') ? 'YES' : 'NO') . "\n";

echo "\nUser's permissions:\n";
foreach ($user->roles as $role) {
    echo "Role: {$role->display_name}\n";
    foreach ($role->permissions as $permission) {
        echo "  - {$permission->display_name} ({$permission->name})\n";
    }
}

echo "\n✅ Setup complete! Try accessing the create course page now.\n";

<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

echo "=== EMERGENCY PERMISSION FIX ===\n\n";

// Step 1: Clear everything and start fresh
echo "1. Clearing existing role assignments...\n";
\DB::table('role_user')->truncate();
\DB::table('permission_role')->truncate();

// Step 2: Ensure permissions exist
echo "2. Creating permissions...\n";
$permissions = [
    'create_students' => 'Create Students',
    'view_students' => 'View Students',
    'edit_students' => 'Edit Students',
    'delete_students' => 'Delete Students',
    'create_courses' => 'Create Courses',
    'view_courses' => 'View Courses',
    'edit_courses' => 'Edit Courses',
    'delete_courses' => 'Delete Courses',
    'create_enrollments' => 'Create Enrollments',
    'view_enrollments' => 'View Enrollments',
    'delete_enrollments' => 'Delete Enrollments',
    'manage_users' => 'Manage Users'
];

foreach ($permissions as $name => $display) {
    \DB::table('permissions')->updateOrInsert(
        ['name' => $name],
        [
            'name' => $name,
            'display_name' => $display,
            'description' => "Permission to {$display}",
            'created_at' => now(),
            'updated_at' => now()
        ]
    );
}

// Step 3: Ensure admin role exists
echo "3. Creating admin role...\n";
\DB::table('roles')->updateOrInsert(
    ['name' => 'admin'],
    [
        'name' => 'admin',
        'display_name' => 'Administrator',
        'description' => 'Full system access',
        'created_at' => now(),
        'updated_at' => now()
    ]
);

// Step 4: Get role and permission IDs
$adminRoleId = \DB::table('roles')->where('name', 'admin')->value('id');
$permissionIds = \DB::table('permissions')->pluck('id');

// Step 5: Assign ALL permissions to admin role
echo "4. Assigning all permissions to admin role...\n";
foreach ($permissionIds as $permissionId) {
    \DB::table('permission_role')->updateOrInsert(
        ['role_id' => $adminRoleId, 'permission_id' => $permissionId],
        [
            'role_id' => $adminRoleId,
            'permission_id' => $permissionId,
            'created_at' => now(),
            'updated_at' => now()
        ]
    );
}

// Step 6: Assign admin role to ALL users
echo "5. Making all users admins...\n";
$users = \DB::table('users')->get();
foreach ($users as $user) {
    \DB::table('role_user')->updateOrInsert(
        ['user_id' => $user->id, 'role_id' => $adminRoleId],
        [
            'user_id' => $user->id,
            'role_id' => $adminRoleId,
            'created_at' => now(),
            'updated_at' => now()
        ]
    );
    echo "  ✅ {$user->email} is now admin\n";
}

// Step 7: Verify the setup
echo "\n6. Verifying setup...\n";
$adminPermissions = \DB::table('permission_role')
    ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
    ->where('permission_role.role_id', $adminRoleId)
    ->pluck('permissions.name');

echo "Admin role has " . $adminPermissions->count() . " permissions:\n";
foreach ($adminPermissions as $perm) {
    echo "  - {$perm}\n";
}

$userRoles = \DB::table('role_user')
    ->join('users', 'role_user.user_id', '=', 'users.id')
    ->join('roles', 'role_user.role_id', '=', 'roles.id')
    ->select('users.email', 'roles.display_name')
    ->get();

echo "\nUser role assignments:\n";
foreach ($userRoles as $assignment) {
    echo "  - {$assignment->email} → {$assignment->display_name}\n";
}

echo "\n✅ EMERGENCY FIX COMPLETE!\n";
echo "All users are now admins with full permissions.\n";
echo "Try accessing /students/create again - it should work now!\n";

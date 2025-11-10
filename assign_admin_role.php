<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;

echo "=== Assign Admin Role ===\n\n";

// Show all users
$users = User::all();
echo "Available Users:\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Email: {$user->email} | Name: {$user->name}\n";
}

echo "\n";

// Show all roles
$roles = Role::all();
echo "Available Roles:\n";
foreach ($roles as $role) {
    echo "ID: {$role->id} | Name: {$role->name} | Display: {$role->display_name}\n";
}

echo "\n";

// Get the first user (or you can specify email)
$user = User::first();
if (!$user) {
    echo "No users found!\n";
    exit;
}

// Get admin role
$adminRole = Role::where('name', 'admin')->first();
if (!$adminRole) {
    echo "Admin role not found!\n";
    exit;
}

// Assign admin role to user
if (!$user->hasRole('admin')) {
    $user->assignRole('admin');
    echo "✅ Admin role assigned to: {$user->email}\n";
} else {
    echo "ℹ️ User {$user->email} already has admin role\n";
}

// Show user's current roles
echo "\nUser's current roles:\n";
foreach ($user->roles as $role) {
    echo "- {$role->display_name} ({$role->name})\n";
}

echo "\n✅ Done! You can now login with {$user->email} and access all features.\n";

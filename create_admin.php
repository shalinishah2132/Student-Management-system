<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

// Create admin user
$admin = User::firstOrCreate(
    ['email' => 'admin@example.com'],
    [
        'name' => 'Administrator',
        'password' => Hash::make('password123'),
    ]
);

// Assign admin role
$adminRole = Role::where('name', 'admin')->first();
if ($adminRole && !$admin->hasRole('admin')) {
    $admin->assignRole('admin');
    echo "Admin user created successfully!\n";
    echo "Email: admin@example.com\n";
    echo "Password: password123\n";
} else {
    echo "Admin user already exists!\n";
}

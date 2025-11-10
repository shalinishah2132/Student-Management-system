<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        $permissions = [
            // Student permissions
            ['name' => 'view_students', 'display_name' => 'View Students', 'description' => 'Can view student list and details'],
            ['name' => 'create_students', 'display_name' => 'Create Students', 'description' => 'Can create new students'],
            ['name' => 'edit_students', 'display_name' => 'Edit Students', 'description' => 'Can edit student information'],
            ['name' => 'delete_students', 'display_name' => 'Delete Students', 'description' => 'Can delete students'],
            
            // Course permissions
            ['name' => 'view_courses', 'display_name' => 'View Courses', 'description' => 'Can view course list and details'],
            ['name' => 'create_courses', 'display_name' => 'Create Courses', 'description' => 'Can create new courses'],
            ['name' => 'edit_courses', 'display_name' => 'Edit Courses', 'description' => 'Can edit course information'],
            ['name' => 'delete_courses', 'display_name' => 'Delete Courses', 'description' => 'Can delete courses'],
            
            // Enrollment permissions
            ['name' => 'view_enrollments', 'display_name' => 'View Enrollments', 'description' => 'Can view enrollment list and details'],
            ['name' => 'create_enrollments', 'display_name' => 'Create Enrollments', 'description' => 'Can enroll students in courses'],
            ['name' => 'delete_enrollments', 'display_name' => 'Delete Enrollments', 'description' => 'Can remove student enrollments'],
            
            // Admin permissions
            ['name' => 'manage_users', 'display_name' => 'Manage Users', 'description' => 'Can manage user accounts and roles'],
            ['name' => 'view_reports', 'display_name' => 'View Reports', 'description' => 'Can view system reports and analytics'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Full system access with all permissions'
            ]
        );

        $teacherRole = Role::firstOrCreate(
            ['name' => 'teacher'],
            [
                'display_name' => 'Teacher',
                'description' => 'Can manage students, courses, and enrollments'
            ]
        );

        $studentRole = Role::firstOrCreate(
            ['name' => 'student'],
            [
                'display_name' => 'Student',
                'description' => 'Limited access to view own information'
            ]
        );

        // Assign permissions to roles
        
        // Admin gets all permissions
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Teacher gets most permissions except user management
        $teacherPermissions = Permission::whereIn('name', [
            'view_students', 'create_students', 'edit_students', 'delete_students',
            'view_courses', 'create_courses', 'edit_courses', 'delete_courses',
            'view_enrollments', 'create_enrollments', 'delete_enrollments',
            'view_reports'
        ])->get();
        $teacherRole->permissions()->sync($teacherPermissions->pluck('id'));

        // Student gets limited view permissions
        $studentPermissions = Permission::whereIn('name', [
            'view_students', 'view_courses', 'view_enrollments'
        ])->get();
        $studentRole->permissions()->sync($studentPermissions->pluck('id'));

        $this->command->info('Roles and permissions seeded successfully!');
    }
}

-- Create roles table
CREATE TABLE IF NOT EXISTS `roles` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `display_name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create permissions table
CREATE TABLE IF NOT EXISTS `permissions` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `display_name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create role_user pivot table
CREATE TABLE IF NOT EXISTS `role_user` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_user_role` (`user_id`, `role_id`)
);

-- Create permission_role pivot table
CREATE TABLE IF NOT EXISTS `permission_role` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `permission_id` BIGINT UNSIGNED NOT NULL,
    `role_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_permission_role` (`permission_id`, `role_id`)
);

-- Insert default roles
INSERT IGNORE INTO `roles` (`name`, `display_name`, `description`) VALUES
('admin', 'Administrator', 'Full system access with all permissions'),
('teacher', 'Teacher', 'Can manage students, courses, and enrollments'),
('student', 'Student', 'Limited access to view own information');

-- Insert default permissions
INSERT IGNORE INTO `permissions` (`name`, `display_name`, `description`) VALUES
('view_students', 'View Students', 'Can view student list and details'),
('create_students', 'Create Students', 'Can create new students'),
('edit_students', 'Edit Students', 'Can edit student information'),
('delete_students', 'Delete Students', 'Can delete students'),
('view_courses', 'View Courses', 'Can view course list and details'),
('create_courses', 'Create Courses', 'Can create new courses'),
('edit_courses', 'Edit Courses', 'Can edit course information'),
('delete_courses', 'Delete Courses', 'Can delete courses'),
('view_enrollments', 'View Enrollments', 'Can view enrollment list and details'),
('create_enrollments', 'Create Enrollments', 'Can enroll students in courses'),
('delete_enrollments', 'Delete Enrollments', 'Can remove student enrollments'),
('manage_users', 'Manage Users', 'Can manage user accounts and roles'),
('view_reports', 'View Reports', 'Can view system reports and analytics');

-- Assign all permissions to admin role
INSERT IGNORE INTO `permission_role` (`permission_id`, `role_id`)
SELECT p.id, r.id FROM permissions p, roles r WHERE r.name = 'admin';

-- Assign teacher permissions
INSERT IGNORE INTO `permission_role` (`permission_id`, `role_id`)
SELECT p.id, r.id FROM permissions p, roles r 
WHERE r.name = 'teacher' AND p.name IN (
    'view_students', 'create_students', 'edit_students', 'delete_students',
    'view_courses', 'create_courses', 'edit_courses', 'delete_courses',
    'view_enrollments', 'create_enrollments', 'delete_enrollments',
    'view_reports'
);

-- Assign student permissions
INSERT IGNORE INTO `permission_role` (`permission_id`, `role_id`)
SELECT p.id, r.id FROM permissions p, roles r 
WHERE r.name = 'student' AND p.name IN (
    'view_students', 'view_courses', 'view_enrollments'
);

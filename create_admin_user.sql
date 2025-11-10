-- Create admin user
INSERT IGNORE INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Assign admin role to the user
INSERT IGNORE INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`)
SELECT u.id, r.id, NOW(), NOW()
FROM users u, roles r 
WHERE u.email = 'admin@example.com' AND r.name = 'admin';

-- Direct SQL fix for permissions

-- First, let's see what we have
SELECT 'Current Users:' as Info;
SELECT id, name, email FROM users;

SELECT 'Current Roles:' as Info;
SELECT id, name, display_name FROM roles;

SELECT 'Current Permissions:' as Info;
SELECT id, name, display_name FROM permissions;

-- Clear existing role assignments for user ID 1 (first user)
DELETE FROM role_user WHERE user_id = 1;

-- Assign admin role to user ID 1
INSERT INTO role_user (user_id, role_id, created_at, updated_at)
SELECT 1, r.id, NOW(), NOW()
FROM roles r 
WHERE r.name = 'admin'
LIMIT 1;

-- Verify the assignment
SELECT 'User Role Assignment:' as Info;
SELECT u.name, u.email, r.display_name as role
FROM users u
JOIN role_user ru ON u.id = ru.user_id
JOIN roles r ON ru.role_id = r.id
WHERE u.id = 1;

-- Show admin permissions
SELECT 'Admin Permissions:' as Info;
SELECT p.name, p.display_name
FROM roles r
JOIN permission_role pr ON r.id = pr.role_id
JOIN permissions p ON pr.permission_id = p.id
WHERE r.name = 'admin'
ORDER BY p.name;

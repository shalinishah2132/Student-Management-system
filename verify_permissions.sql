-- Verify that Teachers and Admins have the required permissions

-- Check Admin permissions
SELECT 
    r.display_name as Role,
    p.display_name as Permission,
    p.name as PermissionCode
FROM roles r
JOIN permission_role pr ON r.id = pr.role_id
JOIN permissions p ON pr.permission_id = p.id
WHERE r.name = 'admin'
ORDER BY p.name;

-- Check Teacher permissions  
SELECT 
    r.display_name as Role,
    p.display_name as Permission,
    p.name as PermissionCode
FROM roles r
JOIN permission_role pr ON r.id = pr.role_id
JOIN permissions p ON pr.permission_id = p.id
WHERE r.name = 'teacher'
ORDER BY p.name;

-- Specifically check for the key permissions
SELECT 
    r.display_name as Role,
    COUNT(CASE WHEN p.name = 'create_students' THEN 1 END) as CanCreateStudents,
    COUNT(CASE WHEN p.name = 'create_courses' THEN 1 END) as CanCreateCourses,
    COUNT(CASE WHEN p.name = 'create_enrollments' THEN 1 END) as CanCreateEnrollments
FROM roles r
LEFT JOIN permission_role pr ON r.id = pr.role_id
LEFT JOIN permissions p ON pr.permission_id = p.id
WHERE r.name IN ('admin', 'teacher')
GROUP BY r.id, r.display_name;

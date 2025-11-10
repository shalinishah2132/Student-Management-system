-- Create password_resets table
CREATE TABLE IF NOT EXISTS `password_resets` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `password_resets_email_index` (`email`)
);

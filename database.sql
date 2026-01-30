-- ====================================
-- WEB PLAY STORE DATABASE SCHEMA
-- ====================================

-- Create database
CREATE DATABASE IF NOT EXISTS web_playstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE web_playstore;

-- ====================================
-- Table: users
-- ====================================
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================
-- Table: categories
-- ====================================
CREATE TABLE IF NOT EXISTS categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_category_name (category_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================
-- Table: apps
-- ====================================
CREATE TABLE IF NOT EXISTS apps (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    category INT(11) NOT NULL,
    version VARCHAR(20) NOT NULL,
    app_icon VARCHAR(255) NOT NULL,
    app_file VARCHAR(255) NOT NULL,
    size VARCHAR(50) NOT NULL,
    downloads INT(11) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (category) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category),
    INDEX idx_downloads (downloads),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================
-- Table: downloads
-- ====================================
CREATE TABLE IF NOT EXISTS downloads (
    id INT(11) NOT NULL AUTO_INCREMENT,
    app_id INT(11) NOT NULL,
    user_ip VARCHAR(45) NOT NULL,
    downloaded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (app_id) REFERENCES apps(id) ON DELETE CASCADE,
    INDEX idx_app_id (app_id),
    INDEX idx_downloaded_at (downloaded_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================
-- Insert Default Admin User
-- Password: admin123 (hashed)
-- ====================================
INSERT INTO users (name, email, password, role) VALUES 
('Admin User', 'admin@webplaystore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- ====================================
-- Insert Default Categories
-- ====================================
INSERT INTO categories (category_name) VALUES 
('Games'),
('Productivity'),
('Education'),
('Entertainment'),
('Business'),
('Utilities'),
('Social'),
('Communication'),
('Photography'),
('Music & Audio');

-- ====================================
-- Insert Sample Apps (for testing)
-- ====================================
INSERT INTO apps (name, description, category, version, app_icon, app_file, size, downloads) VALUES 
('Task Manager Pro', 'Manage your daily tasks efficiently with this powerful task management application. Features include priorities, deadlines, and categories.', 2, '1.0.0', 'default-icon.png', 'sample-app.zip', '2.5 MB', 150),
('Photo Editor Plus', 'Professional photo editing tool with filters, effects, and advanced editing features.', 9, '2.1.0', 'default-icon.png', 'sample-app.zip', '5.8 MB', 320),
('Music Player X', 'Beautiful music player with equalizer and playlist management.', 10, '1.5.2', 'default-icon.png', 'sample-app.zip', '3.2 MB', 280);

-- =========================================
-- DATABASE: neighbor_system
-- =========================================

-- 1. Create Database
CREATE DATABASE IF NOT EXISTS neighbor_system;
USE neighbor_system;

-- 2. Users Table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    address VARCHAR(200) NOT NULL,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    dob DATE NOT NULL,
    password VARCHAR(255) NOT NULL,        -- store hashed passwords
    role ENUM('user','admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS complaints (
    complaint_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    type VARCHAR(50) NOT NULL,
    severity VARCHAR(50),
    urgency VARCHAR(20),
    description TEXT NOT NULL,
    incident_date DATE,
    location VARCHAR(255),
    priority INT,
    images VARCHAR(255),
    status ENUM('pending','in_progress','resolved') DEFAULT 'pending',
    remarks TEXT NOT NULL DEFAULT 'Waiting for remarks',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);


INSERT INTO users (full_name, address, phone, dob, email, password, role)
VALUES (
    'System Administrator',
    'Head Office',
    '0771234567',
    '1990-01-01',
    'admin@neighbor.com',
    '$2y$10$uzr35.KGn8vgm92nUKR3DehamxMp4RUp48DBHpNSBk/frtdr3TC.q',
    'admin'
);

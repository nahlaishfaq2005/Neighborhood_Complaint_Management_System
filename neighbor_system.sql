-- Create database
CREATE DATABASE neighbor_system;

-- Use the database
USE neighbor_system;

-- Create users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    address VARCHAR(200) NOT NULL,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    dob DATE NOT NULL,
    password VARCHAR(255) NOT NULL, -- store hashed
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

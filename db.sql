-- MySQL Database Schema for Luminara Blog CMS

CREATE DATABASE IF NOT EXISTS luminara;
USE luminara;

-- Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL -- hashed password
);

-- Posts Table
CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft',
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE
);
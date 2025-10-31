CREATE DATABASE IF NOT EXISTS project3rd_db;
USE project3rd_db;

CREATE TABLE IF NOT EXISTS access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    password VARCHAR(255),
    status ENUM('pending','approved','denied') DEFAULT 'pending',
    request_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    decision_time TIMESTAMP NULL
);
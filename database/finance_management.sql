CREATE DATABASE IF NOT EXISTS finance_management;
USE finance_management;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('USER', 'ADMIN') DEFAULT 'USER',
    status ENUM('ACTIVE', 'BLOCKED') DEFAULT 'ACTIVE',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(255) NOT NULL,
    user_email VARCHAR(150) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (id, name, email, password, role, status) VALUES 
(1, 'Abhinav Bhadoriya', 'abhinav@example.com', 'admin123', 'ADMIN', 'ACTIVE'),
(2, 'Demo User', 'user@example.com', 'user123', 'USER', 'ACTIVE');

INSERT INTO expenses (user_id, title, category, amount, date) VALUES 
(1, 'Cloud Hosting', 'Bills', 1250.00, '2026-10-10'),
(1, 'Gym Membership', 'Fitness', 2000.00, '2026-10-05'),
(1, 'Groceries', 'Food', 3200.00, '2026-10-02');

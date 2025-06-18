CREATE DATABASE IF NOT EXISTS login_db;
USE login_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- User mặc định: user / 123
INSERT INTO users (username, password_hash)
VALUES (
    'user',
    '$2y$10$KukOxJT7.xhEFJnQIMdnD.X8CRlF9fyMQRrzuwEsqswqB3zd7wVqy'
);
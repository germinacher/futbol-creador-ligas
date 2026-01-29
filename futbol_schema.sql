
CREATE DATABASE IF NOT EXISTS sesionesfutbol CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sesionesfutbol;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabla de equipos
CREATE TABLE IF NOT EXISTS register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team VARCHAR(255) NOT NULL,
    played INT DEFAULT 0,
    win INT DEFAULT 0,
    draw INT DEFAULT 0,
    defeat INT DEFAULT 0,
    gf INT DEFAULT 0,
    gc INT DEFAULT 0,
    points INT DEFAULT 0,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla de partidos
CREATE TABLE IF NOT EXISTS matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    home_team VARCHAR(255) NOT NULL,
    away_team VARCHAR(255) NOT NULL,
    home_score INT NOT NULL,
    away_score INT NOT NULL,
    home_result CHAR(1),
    away_result CHAR(1),
    date DATETIME NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

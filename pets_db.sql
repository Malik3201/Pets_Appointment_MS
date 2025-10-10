-- MySQL SQL dump for Pet Care Management System
CREATE DATABASE IF NOT EXISTS pet_care_db;
USE pet_care_db;

-- Owners table
CREATE TABLE IF NOT EXISTS owners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  owner_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  address VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Pets table
CREATE TABLE IF NOT EXISTS pets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pet_name VARCHAR(100) NOT NULL,
  type VARCHAR(50) NOT NULL,
  age INT NOT NULL DEFAULT 0,
  owner_id INT NOT NULL,
  CONSTRAINT fk_pets_owner_id FOREIGN KEY (owner_id) REFERENCES owners(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pet_id INT NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  service VARCHAR(100) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Pending',
  CONSTRAINT fk_appointments_pet_id FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Admin table
CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Seed admin user (username: admin, password: admin123)
INSERT INTO admin (username, password)
VALUES ('admin', '$2y$10$7I8g0j8pJx0v2o3yq9mK4eM0i9dG6D7e8fC0q2NqV3R3YcQm9gO2a')
ON DUPLICATE KEY UPDATE username = VALUES(username);



<?php
/**
 * PETS APPOINTMENT MANAGEMENT SYSTEM - CONFIGURATION FILE
 * 
 * This file contains the core configuration settings for the veterinary clinic
 * appointment management system. It handles database connections, session
 * management, and provides utility functions for data sanitization.
 * 
 * @author: Student Project
 * @version: 1.0
 * @description: Canberra Pets Care Hospital Management System
 */

// Start session management for user authentication and data persistence
session_start();

/**
 * DATABASE CONFIGURATION
 * 
 * These variables define the connection parameters for the MySQL database.
 * In a production environment, these should be stored in environment variables
 * for security purposes.
 */
$db_host = 'localhost';    // Database server hostname
$db_user = 'root';         // Database username
$db_pass = '';             // Database password (empty for local development)
$db_name = 'pets_db';      // Database name containing pets and appointments data

/**
 * DATABASE CONNECTION
 * 
 * Creates a new MySQLi connection object and checks for connection errors.
 * If connection fails, the script terminates with an error message.
 */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check for connection errors
if ($mysqli->connect_error) {
	die('Database connection failed: ' . $mysqli->connect_error);
}

/**
 * INPUT SANITIZATION FUNCTION
 * 
 * This function sanitizes user input to prevent XSS attacks and ensures
 * data integrity. It removes whitespace and converts special characters
 * to HTML entities.
 * 
 * @param string $value - The input value to sanitize
 * @return string - Sanitized value safe for database storage and display
 */
function sanitize($value) {
	// Remove leading/trailing whitespace and convert special characters to HTML entities
	return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

?>



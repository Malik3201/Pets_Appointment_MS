<?php
session_start();

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'pet_care_db';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_error) {
	die('Database connection failed: ' . $mysqli->connect_error);
}

// Helper: sanitize input (basic trimming)
function sanitize($value) {
	return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

?>



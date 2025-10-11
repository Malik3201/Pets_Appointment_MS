<?php
/**
 * PETS APPOINTMENT MANAGEMENT SYSTEM - AJAX PET FETCHER
 * 
 * This file provides an AJAX endpoint that fetches pets for a given owner
 * based on their email or phone number. It's used by the appointment booking
 * form to dynamically populate the pet selection dropdown.
 * 
 * Features:
 * - Accepts email or phone number as search criteria
 * - Returns JSON response with pet information
 * - Uses prepared statements for security
 * - Joins pets and owners tables for data retrieval
 * 
 * Usage:
 * Called via AJAX from book_appointment.php when user enters email/phone
 * 
 * @author: Student Project
 * @version: 1.0
 */

// Include the main configuration file for database connection
require_once __DIR__ . '/config.php';

// Set the response content type to JSON for AJAX requests
header('Content-Type: application/json');

// Sanitize the input parameters from GET request
$email = sanitize($_GET['email'] ?? '');
$phone = sanitize($_GET['phone'] ?? '');

// Initialize pets array to store results
$pets = [];

// Only search if at least one search criteria is provided
if ($email || $phone) {
	// Query to find pets belonging to owners with matching email or phone
	// Uses JOIN to connect pets table with owners table
	$stmt = $mysqli->prepare('SELECT pets.id, pets.pet_name FROM pets JOIN owners ON pets.owner_id = owners.id WHERE (owners.email = ? OR owners.phone = ?) ORDER BY pets.pet_name');
	$stmt->bind_param('ss', $email, $phone);
	$stmt->execute();
	$result = $stmt->get_result();
	
	// Loop through results and add each pet to the pets array
	while ($row = $result->fetch_assoc()) { 
		$pets[] = $row; 
	}
	$stmt->close();
}

// Return the pets data as JSON response
echo json_encode(['pets' => $pets]);
exit;
?>



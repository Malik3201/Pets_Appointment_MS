<?php
// Test script for receipt generation
require_once __DIR__ . '/config.php';

// Check if there are any appointments
$result = $mysqli->query('SELECT COUNT(*) as count FROM appointments');
$row = $result->fetch_assoc();
echo "Total appointments in database: " . $row['count'] . "\n";

if ($row['count'] > 0) {
    // Get the first appointment
    $result = $mysqli->query('SELECT id, status FROM appointments LIMIT 1');
    $appointment = $result->fetch_assoc();
    echo "Sample appointment ID: " . $appointment['id'] . " (Status: " . $appointment['status'] . ")\n";
    echo "You can test the receipt by visiting: generate_receipt.php?id=" . $appointment['id'] . "\n";
} else {
    echo "No appointments found in database.\n";
    echo "Please create some test data first by:\n";
    echo "1. Registering a pet at register_pet.php\n";
    echo "2. Booking an appointment at book_appointment.php\n";
}

// Test the receipt generation function
if ($row['count'] > 0) {
    echo "\nTesting receipt generation...\n";
    include 'generate_receipt.php';
    
    $result = $mysqli->query('SELECT id FROM appointments LIMIT 1');
    $appointment = $result->fetch_assoc();
    
    $receiptPath = generate_receipt_professional($appointment['id'], true);
    if ($receiptPath) {
        echo "Receipt generated successfully at: " . $receiptPath . "\n";
        echo "You can open this file in your browser to view the receipt.\n";
    } else {
        echo "Failed to generate receipt.\n";
    }
}
?>


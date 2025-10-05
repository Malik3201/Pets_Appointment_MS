<?php
// Basic header include
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pet Care Management System</title>
	<link rel="stylesheet" href="/Pets_Appointment_MS/css/style.css">
</head>
<body>
<header class="site-header">
	<div class="site-header-inner container">
		<a class="brand" href="index.php" aria-label="PetCare Home">
			<span class="brand__logo">🐾</span>
			<span class="brand__text">PetCare</span>
		</a>

		<input type="checkbox" id="nav-toggle" class="nav-toggle" aria-label="Toggle navigation">
		<label for="nav-toggle" class="hamburger" aria-hidden="true">
			<span></span><span></span><span></span>
		</label>

		<nav class="nav" aria-label="Primary navigation">
			<a href="index.php">Home</a>
			<a href="register_pet.php">Register Pet</a>
			<a href="book_appointment.php">Book Appointment</a>
			<a href="view_appointments.php">View Appointments</a>
		</nav>
	</div>
	<nav class="nav-drawer container" aria-label="Mobile navigation">
		<a href="index.php">Home</a>
		<a href="register_pet.php">Register Pet</a>
		<a href="book_appointment.php">Book Appointment</a>
		<a href="view_appointments.php">View Appointments</a>
	</nav>
</header>
<main>



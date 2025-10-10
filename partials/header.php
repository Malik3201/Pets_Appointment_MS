<?php
// Header partial for veterinary website
// Includes sticky transparent/solid header with navigation
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Pets Care - Veterinary Care'; ?></title>
    
    <!-- Performance optimizations -->
    <link rel="preload" as="font" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" crossorigin>
    <link rel="preload" as="video" href="assets/bgVideo/Hero-bg-video.mp4" type="video/mp4">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/main.css">
    
    <!-- Meta tags -->
    <meta name="description" content="Professional veterinary care for your beloved pets. Book appointments, access services, and get expert medical care.">
    <meta name="keywords" content="veterinary, pet care, animal hospital, vet clinic, pet health">
    <meta name="author" content="Pets & Vets">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Pets & Vets - Veterinary Care">
    <meta property="og:description" content="Professional veterinary care for your beloved pets.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $_SERVER['REQUEST_URI']; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🐾</text></svg>">
</head>
<body>
    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link sr-only">Skip to main content</a>

    <!-- Header -->
    <header class="site-header" role="banner">
        <div class="site-header-inner container">
            <!-- Logo -->
            <a class="brand" href="index.php" aria-label="Pets Care Home">
                <div class="brand__logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"/>
                        <path d="M19 15L19.5 17L21.5 17L19.5 18L20 20L19 19L18 20L18.5 18L16.5 17L18.5 17L19 15Z"/>
                        <path d="M5 15L5.5 17L7.5 17L5.5 18L6 20L5 19L4 20L4.5 18L2.5 17L4.5 17L5 15Z"/>
                    </svg>
                </div>
                <span class="brand__text">PETS CARE</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="nav" role="navigation" aria-label="Primary navigation">
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <!-- Admin Navigation -->
                    <a href="admin_dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? 'aria-current="page"' : ''; ?>>Dashboard</a>
                    <a href="?action=logout" class="logout-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                        Logout
                    </a>
                <?php else: ?>
                    <!-- Regular Navigation -->
                    <a href="register_pet.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'register_pet.php') ? 'aria-current="page"' : ''; ?>>Register Pet</a>
                    <a href="book_appointment.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'book_appointment.php') ? 'aria-current="page"' : ''; ?>>Book Appointment</a>
                    <a href="view_appointments.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'view_appointments.php') ? 'aria-current="page"' : ''; ?>>View Appointments</a>
                <?php endif; ?>
            </nav>

            <!-- Mobile Menu Toggle -->
            <button class="hamburger" aria-expanded="false" aria-controls="mobile-nav" aria-label="Toggle mobile navigation">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>
        </div>

        <!-- Mobile Navigation Drawer -->
        <nav class="nav-drawer" id="mobile-nav" role="navigation" aria-label="Mobile navigation">
            <?php if (isset($_SESSION['admin_id'])): ?>
                <!-- Admin Mobile Navigation -->
                <a href="admin_dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? 'aria-current="page"' : ''; ?>>Dashboard</a>
                <a href="?action=logout" class="logout-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    Logout
                </a>
            <?php else: ?>
                <!-- Regular Mobile Navigation -->
                <a href="register_pet.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'register_pet.php') ? 'aria-current="page"' : ''; ?>>Register Pet</a>
                <a href="book_appointment.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'book_appointment.php') ? 'aria-current="page"' : ''; ?>>Book Appointment</a>
                <a href="view_appointments.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'view_appointments.php') ? 'aria-current="page"' : ''; ?>>View Appointments</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Main Content Wrapper -->
    <main id="main-content" role="main">

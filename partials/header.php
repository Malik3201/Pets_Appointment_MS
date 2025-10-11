<?php
/**
 * PETS APPOINTMENT MANAGEMENT SYSTEM - HEADER PARTIAL
 * 
 * This file contains the HTML head section and navigation header that is
 * included on every page of the website. It provides:
 * 
 * - HTML document structure and meta tags
 * - CSS and font loading with performance optimizations
 * - Responsive navigation with desktop and mobile menus
 * - Dynamic page titles
 * - Admin/User authentication-based navigation
 * - Cache-busting for CSS files
 * 
 * The header adapts based on user authentication:
 * - Regular users see: Home, Register Pet, Book Appointment, View Appointments
 * - Admin users see: Dashboard, Logout
 * 
 * @author: Student Project
 * @version: 1.0
 */

// Include the main configuration file for database connection and functions
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
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>">
    
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
                    <a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'aria-current="page"' : ''; ?>>Home</a>
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
                <a href="admin_dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? 'aria-current="page"' : ''; ?>>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z"/>
                    </svg>
                    Dashboard
                </a>
                <a href="?action=logout" class="logout-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    Logout
                </a>
            <?php else: ?>
                <!-- Regular Mobile Navigation -->
                <a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'aria-current="page"' : ''; ?>>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    Home
                </a>
                <a href="register_pet.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'register_pet.php') ? 'aria-current="page"' : ''; ?>>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H19C20.11 23 21 22.11 21 21V9M19 9H14V4H19V9Z"/>
                    </svg>
                    Register Pet
                </a>
                <a href="book_appointment.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'book_appointment.php') ? 'aria-current="page"' : ''; ?>>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M19 3H5C3.89 3 3 3.89 3 5V19C3 20.11 3.89 21 5 21H19C20.11 21 21 20.11 21 19V5C21 3.89 20.11 3 19 3M19 19H5V8H19V19M19 6H5V5H19V6M17 12H12V17H17V12M8 12V17H10V12H8M8 10H10V8H8V10M12 8V10H17V8H12Z"/>
                    </svg>
                    Book Appointment
                </a>
                <a href="view_appointments.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'view_appointments.php') ? 'aria-current="page"' : ''; ?>>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M9 11H7V9H9V11M13 11H11V9H13V11M17 11H15V9H17V11M19 4H18V2H16V4H8V2H6V4H5C3.89 4 3 4.89 3 6V20C3 21.11 3.89 22 5 22H19C20.11 22 21 21.11 21 20V6C21 4.89 20.11 4 19 4M19 20H5V9H19V20Z"/>
                    </svg>
                    View Appointments
                </a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Main Content Wrapper -->
    <main id="main-content" role="main">

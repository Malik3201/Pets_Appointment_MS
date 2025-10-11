<?php
// Include configuration
require_once __DIR__ . '/config.php';

$message = '';

// Check if admin is already logged in
if (isset($_SESSION['admin_id'])) {
	header('Location: admin_dashboard.php');
	exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = sanitize($_POST['username'] ?? '');
	$password = $_POST['password'] ?? '';
	if ($username && $password) {
		$stmt = $mysqli->prepare('SELECT id, password FROM admin WHERE username = ? LIMIT 1');
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($admin_id, $hash);
		if ($stmt->fetch()) {
			if (password_verify($password, $hash)) {
				$_SESSION['admin_id'] = $admin_id;
				header('Location: admin_dashboard.php');
				exit;
			} else {
				$message = 'Invalid credentials.';
			}
		} else {
			$message = 'Invalid credentials.';
		}
		$stmt->close();
	} else {
		$message = 'Please enter username and password.';
	}
}

// Set page title for header
$page_title = 'Admin Login - Pets Care';
require __DIR__ . '/partials/header.php';
?>

<!-- Admin Login Section -->
<section class="admin-login-section">
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <div class="admin-logo">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h1 class="admin-title">Admin Portal</h1>
                <p class="admin-subtitle">Pets Care Management System</p>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="" class="admin-login-form">
                <div class="form-group">
                    <label for="username">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        Username
                    </label>
                    <input type="text" id="username" name="username" required placeholder="Enter your username" autocomplete="username">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                        Password
                    </label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password" autocomplete="current-password">
                </div>
                
                <button type="submit" class="btn btn--admin">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/>
                    </svg>
                    Sign In to Admin Panel
                </button>
            </form>
            
            <div class="admin-login-footer">
                <div class="security-notice">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                    </svg>
                    <span>Secure Admin Access</span>
                </div>
                <p class="copyright">© 2025 Pets Care. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>



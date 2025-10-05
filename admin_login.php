<?php include 'includes/header.php'; ?>

<?php
$message = '';
if (isset($_SESSION['admin_id'])) {
	header('Location: admin_dashboard.php');
	exit;
}

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
?>

<div class="card">
	<h2>Admin Login</h2>
	<?php if ($message): ?>
		<div class="alert alert-error"><?php echo $message; ?></div>
	<?php endif; ?>
	<form method="post" action="">
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" required>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" id="password" name="password" required>
		</div>
		<input type="submit" value="Login">
	</form>
</div>

<?php include 'includes/footer.php'; ?>



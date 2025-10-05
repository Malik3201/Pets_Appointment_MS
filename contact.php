<?php include 'includes/header.php'; ?>

<?php
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = sanitize($_POST['name'] ?? '');
	$email = sanitize($_POST['email'] ?? '');
	$message = sanitize($_POST['message'] ?? '');

	if ($name && $email && $message) {
		$success = 'Thank you for your feedback!';
	} else {
		$success = 'Please fill all fields.';
	}
}
?>

<div class="card">
	<h2>Contact Us</h2>
	<?php if ($success): ?>
		<div class="alert <?php echo strpos($success, 'Thank') === 0 ? 'alert-success' : 'alert-error'; ?>"><?php echo $success; ?></div>
	<?php endif; ?>
	<form method="post" action="">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" id="name" name="name" required>
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" id="email" name="email" required>
		</div>
		<div class="form-group">
			<label for="message">Message</label>
			<textarea id="message" name="message" rows="4" required></textarea>
		</div>
		<input type="submit" value="Send">
	</form>
</div>

<?php include 'includes/footer.php'; ?>



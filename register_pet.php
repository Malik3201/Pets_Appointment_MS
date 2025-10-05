<?php include 'includes/header.php'; ?>

<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$owner_name = sanitize($_POST['owner_name'] ?? '');
	$email = sanitize($_POST['email'] ?? '');
	$phone = sanitize($_POST['phone'] ?? '');
	$address = sanitize($_POST['address'] ?? '');
	$pet_name = sanitize($_POST['pet_name'] ?? '');
	$type = sanitize($_POST['type'] ?? '');
	$age = (int)($_POST['age'] ?? 0);

	if ($owner_name && $email && $phone && $address && $pet_name && $type && $age >= 0) {
		// Upsert owner by email (assumption: unique email)
		$mysqli->begin_transaction();
		try {
			// Check if owner exists
			$owner_id = null;
			$stmt = $mysqli->prepare('SELECT id FROM owners WHERE email = ? LIMIT 1');
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->bind_result($existing_owner_id);
			if ($stmt->fetch()) {
				$owner_id = $existing_owner_id;
			}
			$stmt->close();

			if ($owner_id === null) {
				$stmt = $mysqli->prepare('INSERT INTO owners (owner_name, email, phone, address) VALUES (?, ?, ?, ?)');
				$stmt->bind_param('ssss', $owner_name, $email, $phone, $address);
				$stmt->execute();
				$owner_id = $stmt->insert_id;
				$stmt->close();
			} else {
				// Optionally update owner details
				$stmt = $mysqli->prepare('UPDATE owners SET owner_name = ?, phone = ?, address = ? WHERE id = ?');
				$stmt->bind_param('sssi', $owner_name, $phone, $address, $owner_id);
				$stmt->execute();
				$stmt->close();
			}

			// Insert pet
			$stmt = $mysqli->prepare('INSERT INTO pets (pet_name, type, age, owner_id) VALUES (?, ?, ?, ?)');
			$stmt->bind_param('ssii', $pet_name, $type, $age, $owner_id);
			$stmt->execute();
			$stmt->close();

			$mysqli->commit();
			$message = 'Pet registered successfully.';
		} catch (Exception $e) {
			$mysqli->rollback();
			$message = 'Error: Could not register pet.';
		}
	} else {
		$message = 'Please fill in all fields correctly.';
	}
}
?>

<div class="card">
	<h2>Register Pet</h2>
	<?php if ($message): ?>
		<div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>"><?php echo $message; ?></div>
	<?php endif; ?>
	<form method="post" action="" onsubmit="return validateRegisterPet();">
		<h3>Owner Details</h3>
		<div class="form-group">
			<label for="owner_name">Owner Name</label>
			<input type="text" id="owner_name" name="owner_name" required>
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" id="email" name="email" required>
		</div>
		<div class="form-group">
			<label for="phone">Phone</label>
			<input type="tel" id="phone" name="phone" required>
		</div>
		<div class="form-group">
			<label for="address">Address</label>
			<input type="text" id="address" name="address" required>
		</div>

		<h3>Pet Details</h3>
		<div class="form-group">
			<label for="pet_name">Pet Name</label>
			<input type="text" id="pet_name" name="pet_name" required>
		</div>
		<div class="form-group">
			<label for="type">Type</label>
			<input type="text" id="type" name="type" placeholder="Dog, Cat, etc." required>
		</div>
		<div class="form-group">
			<label for="age">Age</label>
			<input type="number" id="age" name="age" min="0" required>
		</div>
		<input type="submit" value="Register">
	</form>
</div>

<script>
function validateRegisterPet() {
	var requiredIds = ['owner_name','email','phone','address','pet_name','type','age'];
	for (var i=0;i<requiredIds.length;i++) {
		var el = document.getElementById(requiredIds[i]);
		if (!el || !el.value.trim()) { alert('Please fill all fields.'); return false; }
	}
	return true;
}
</script>

<?php include 'includes/footer.php'; ?>



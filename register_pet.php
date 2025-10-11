<?php
// Include configuration
require_once __DIR__ . '/config.php';

// Set page title for header
$page_title = 'Register Pet - Pets Care';
require __DIR__ . '/partials/header.php';
?>

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

<!-- Register Pet Section -->
<section class="section" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h2 class="section-title">Register Your Pet</h2>
                <p class="section-subtitle">Join our family of pet owners and give your beloved companion the best veterinary care.</p>
            </div>
            
            <div class="register-form-container">
                <div class="register-form-card">
                    <?php if ($message): ?>
                        <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="" onsubmit="return validateRegisterPet();" class="register-form">
                        <div class="form-section">
                            <h3 class="form-section-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Owner Details
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="owner_name">Owner Name *</label>
                                    <input type="text" id="owner_name" name="owner_name" required placeholder="Enter your full name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" required placeholder="+1 (234) 567-8900">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address *</label>
                                    <input type="text" id="address" name="address" required placeholder="Your complete address">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="form-section-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"/>
                                </svg>
                                Pet Details
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="pet_name">Pet Name *</label>
                                    <input type="text" id="pet_name" name="pet_name" required placeholder="Your pet's name">
                                </div>
                                <div class="form-group">
                                    <label for="type">Pet Type *</label>
                                    <select id="type" name="type" required>
                                        <option value="">Select pet type</option>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                        <option value="Bird">Bird</option>
                                        <option value="Rabbit">Rabbit</option>
                                        <option value="Hamster">Hamster</option>
                                        <option value="Fish">Fish</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="age">Age *</label>
                                    <input type="number" id="age" name="age" min="0" max="30" required placeholder="Pet's age in years">
                                </div>
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn--primary btn--large">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                        </svg>
                                        Register Pet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

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

<?php require __DIR__ . '/partials/footer.php'; ?>



<?php
/**
 * PETS APPOINTMENT MANAGEMENT SYSTEM - PET REGISTRATION PAGE
 * 
 * This page allows pet owners to register their pets in the system.
 * It handles both owner and pet information in a single form with
 * database transactions to ensure data integrity.
 * 
 * Features:
 * - Owner information collection (name, email, phone, address)
 * - Pet information collection (name, type, age)
 * - Database transaction handling for data consistency
 * - Input validation and sanitization
 * - Success/error message display
 * - Form validation with JavaScript
 * 
 * Database Operations:
 * - Checks if owner already exists by email
 * - Creates new owner record if not exists
 * - Creates pet record linked to owner
 * - Uses transactions to ensure data consistency
 * 
 * @author: Student Project
 * @version: 1.0
 */

// Include the main configuration file for database connection
require_once __DIR__ . '/config.php';

// Set the page title for the browser tab
$page_title = 'Register Pet - Canberra Pets Care Hospital';

// Include the header partial with navigation
require __DIR__ . '/partials/header.php';
?>

<?php
/**
 * FORM PROCESSING LOGIC
 * 
 * This section handles the POST request when the user submits the pet registration form.
 * It processes both owner and pet information, ensuring data integrity through
 * database transactions.
 */
$message = '';

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Sanitize and validate all form inputs
	$owner_name = sanitize($_POST['owner_name'] ?? '');
	$email = sanitize($_POST['email'] ?? '');
	$phone = sanitize($_POST['phone'] ?? '');
	$address = sanitize($_POST['address'] ?? '');
	$pet_name = sanitize($_POST['pet_name'] ?? '');
	$type = sanitize($_POST['type'] ?? '');
	$age = (int)($_POST['age'] ?? 0);

	// Validate that all required fields are provided and age is non-negative
	if ($owner_name && $email && $phone && $address && $pet_name && $type && $age >= 0) {
		// Begin database transaction to ensure data consistency
		// This ensures that either both owner and pet are created, or neither is created
		$mysqli->begin_transaction();
		try {
			// Check if owner already exists in the database by email
			// This prevents duplicate owner records for the same email address
			$owner_id = null;
			$stmt = $mysqli->prepare('SELECT id FROM owners WHERE email = ? LIMIT 1');
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->bind_result($existing_owner_id);
			if ($stmt->fetch()) {
				$owner_id = $existing_owner_id;
			}
			$stmt->close();

			// If owner doesn't exist, create a new owner record
			if ($owner_id === null) {
				$stmt = $mysqli->prepare('INSERT INTO owners (owner_name, email, phone, address) VALUES (?, ?, ?, ?)');
				$stmt->bind_param('ssss', $owner_name, $email, $phone, $address);
				$stmt->execute();
				$owner_id = $stmt->insert_id; // Get the ID of the newly created owner
				$stmt->close();
			} else {
				// If owner exists, update their information with the latest details
				$stmt = $mysqli->prepare('UPDATE owners SET owner_name = ?, phone = ?, address = ? WHERE id = ?');
				$stmt->bind_param('sssi', $owner_name, $phone, $address, $owner_id);
				$stmt->execute();
				$stmt->close();
			}

			// Create a new pet record linked to the owner
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
                                    <input type="tel" id="phone" name="phone" required placeholder="+61 2 3456 7890">
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
/**
 * CLIENT-SIDE FORM VALIDATION
 * 
 * This JavaScript function validates the pet registration form before submission.
 * It checks that all required fields are filled out to provide immediate
 * feedback to users and prevent unnecessary server requests.
 * 
 * @returns {boolean} - Returns true if all fields are valid, false otherwise
 */
function validateRegisterPet() {
	// Array of required field IDs that must be filled
	var requiredIds = ['owner_name','email','phone','address','pet_name','type','age'];
	
	// Loop through each required field and check if it has a value
	for (var i=0;i<requiredIds.length;i++) {
		var el = document.getElementById(requiredIds[i]);
		// Check if element exists and has a non-empty value (after trimming whitespace)
		if (!el || !el.value.trim()) { 
			alert('Please fill all fields.'); 
			return false; 
		}
	}
	
	// If all validations pass, return true to allow form submission
	return true;
}
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>



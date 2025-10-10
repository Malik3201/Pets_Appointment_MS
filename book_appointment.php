<?php
// Include configuration
require_once __DIR__ . '/config.php';

// Set page title for header
$page_title = 'Book Appointment - Pets Care';
require __DIR__ . '/partials/header.php';
?>

<?php
$message = '';

// Owner filter inputs
$owner_email = sanitize($_POST['owner_email'] ?? '');
$owner_phone = sanitize($_POST['owner_phone'] ?? '');

// Fetch pets for dropdown filtered by owner email/phone
$pets = [];
if ($owner_email || $owner_phone) {
	$stmt = $mysqli->prepare('SELECT pets.id, pets.pet_name, owners.owner_name FROM pets JOIN owners ON pets.owner_id = owners.id WHERE (owners.email = ? OR owners.phone = ?) ORDER BY pets.pet_name');
	$stmt->bind_param('ss', $owner_email, $owner_phone);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) { $pets[] = $row; }
	$stmt->close();
}

if (isset($_POST['submit_booking'])) {
	$pet_id = (int)($_POST['pet_id'] ?? 0);
	$date = sanitize($_POST['date'] ?? '');
	$time = sanitize($_POST['time'] ?? '');
	$service = sanitize($_POST['service'] ?? '');
	$status = 'Pending';

	// Revalidate that the selected pet belongs to provided owner
	$valid_pet = false;
	if ($pet_id > 0 && ($owner_email || $owner_phone)) {
		$stmt = $mysqli->prepare('SELECT pets.id FROM pets JOIN owners ON pets.owner_id = owners.id WHERE pets.id = ? AND (owners.email = ? OR owners.phone = ?)');
		$stmt->bind_param('iss', $pet_id, $owner_email, $owner_phone);
		$stmt->execute();
		$stmt->bind_result($pid);
		if ($stmt->fetch()) { $valid_pet = true; }
		$stmt->close();
	}

	if ($valid_pet && $date && $time && $service) {
		$stmt = $mysqli->prepare('INSERT INTO appointments (pet_id, date, time, service, status) VALUES (?, ?, ?, ?, ?)');
		$stmt->bind_param('issss', $pet_id, $date, $time, $service, $status);
		if ($stmt->execute()) {
			$message = 'Appointment booked successfully.';
		} else {
			$message = 'Error booking appointment.';
		}
		$stmt->close();
	} else {
		$message = 'Please ensure you entered your email/phone and selected your pet.';
	}
}
?>

<!-- Book Appointment Section -->
<section class="section" data-bg="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h2 class="section-title">Book Your Appointment</h2>
                <p class="section-subtitle">Schedule a visit for your beloved pet with our experienced veterinary team.</p>
            </div>
            
            <div class="appointment-form-container">
                <div class="appointment-form-card">
                    <?php if ($message): ?>
                        <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="" onsubmit="return validateBookAppointment();" class="appointment-form">
                        <div class="form-section">
                            <h3 class="form-section-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Owner Verification
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="owner_email">Email Address *</label>
                                    <input type="email" id="owner_email" name="owner_email" value="<?php echo $owner_email; ?>" required placeholder="your.email@example.com">
                                </div>
                                <div class="form-group">
                                    <label for="owner_phone">Phone Number</label>
                                    <input type="tel" id="owner_phone" name="owner_phone" value="<?php echo $owner_phone; ?>" placeholder="+1 (234) 567-8900">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="form-section-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"/>
                                </svg>
                                Pet Selection
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="pet_id">Select Your Pet *</label>
                                    <select id="pet_id" name="pet_id" required>
                                        <option value="">Choose your pet</option>
                                        <?php foreach ($pets as $p): ?>
                                            <option value="<?php echo $p['id']; ?>"><?php echo $p['pet_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="form-help">Enter your email or phone above to load your registered pets.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="form-section-title">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                                Appointment Details
                            </h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="date">Preferred Date *</label>
                                    <input type="date" id="date" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="time">Preferred Time *</label>
                                    <input type="time" id="time" name="time" required>
                                </div>
                                <div class="form-group">
                                    <label for="service">Service Type *</label>
                                    <select id="service" name="service" required>
                                        <option value="">Select service</option>
                                        <option value="General Checkup">General Checkup</option>
                                        <option value="Vaccination">Vaccination</option>
                                        <option value="Grooming">Grooming</option>
                                        <option value="Dentistry">Dentistry</option>
                                        <option value="Emergency Care">Emergency Care</option>
                                        <option value="Laboratory Test">Laboratory Test</option>
                                        <option value="Surgery">Surgery</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" name="submit_booking" class="btn btn--primary btn--large">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                        </svg>
                                        Book Appointment
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
function validateBookAppointment() {
	var requiredIds = ['date','time','service'];
	var email = document.getElementById('owner_email').value.trim();
	var phone = document.getElementById('owner_phone').value.trim();
	if (!email && !phone) { alert('Enter your email or phone to load pets.'); return false; }
	var pet = document.getElementById('pet_id').value;
	if (!pet) { alert('Select your pet.'); return false; }
	for (var i=0;i<requiredIds.length;i++) {
		var el = document.getElementById(requiredIds[i]);
		if (!el || !el.value) { alert('Please fill all fields.'); return false; }
	}
	return true;
}

// Debounced runtime fetching of pets for entered owner email/phone
var fetchTimer = null;
function scheduleFetchPets() {
	if (fetchTimer) clearTimeout(fetchTimer);
	fetchTimer = setTimeout(fetchPets, 400);
}

function fetchPets() {
	var email = document.getElementById('owner_email').value.trim();
	var phone = document.getElementById('owner_phone').value.trim();
	if (!email && !phone) {
		populatePets([]);
		return;
	}
	fetch('fetch_pets.php?email=' + encodeURIComponent(email) + '&phone=' + encodeURIComponent(phone))
		.then(function(res){ return res.json(); })
		.then(function(data){ populatePets(data.pets || []); })
		.catch(function(){ populatePets([]); });
}

function populatePets(pets) {
	var sel = document.getElementById('pet_id');
	sel.innerHTML = '';
	var opt = document.createElement('option');
	opt.value = '';
	opt.textContent = '-- Choose --';
	sel.appendChild(opt);
	for (var i=0;i<pets.length;i++) {
		var p = pets[i];
		var o = document.createElement('option');
		o.value = p.id;
		o.textContent = p.pet_name;
		sel.appendChild(o);
	}
}

document.getElementById('owner_email').addEventListener('input', scheduleFetchPets);
document.getElementById('owner_phone').addEventListener('input', scheduleFetchPets);
// Initial fetch on page load if values prefilled
window.addEventListener('DOMContentLoaded', fetchPets);
</script>

<?php require __DIR__ . '/partials/footer.php'; ?>



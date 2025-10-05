<?php include 'includes/header.php'; ?>

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

<div class="card">
	<h2>Book Appointment</h2>
	<?php if ($message): ?>
		<div class="alert <?php echo strpos($message, 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>"><?php echo $message; ?></div>
	<?php endif; ?>
	<form method="post" action="" onsubmit="return validateBookAppointment();">
		<h3>Owner Verification</h3>
		<div class="form-group">
			<label for="owner_email">Owner Email</label>
			<input type="email" id="owner_email" name="owner_email" value="<?php echo $owner_email; ?>" placeholder="Enter your email">
		</div>
		<div class="form-group">
			<label for="owner_phone">Owner Phone</label>
			<input type="tel" id="owner_phone" name="owner_phone" value="<?php echo $owner_phone; ?>" placeholder="Or your phone">
		</div>

		<div class="form-group">
			<label for="pet_id">Select Your Pet</label>
			<select id="pet_id" name="pet_id" required>
				<option value="">-- Choose --</option>
				<?php foreach ($pets as $p): ?>
					<option value="<?php echo $p['id']; ?>"><?php echo $p['pet_name']; ?></option>
				<?php endforeach; ?>
			</select>
			<p style="font-size:12px;color:#555;">Enter your email or phone to load your pets.</p>
		</div>
		<div class="form-group">
			<label for="date">Date</label>
			<input type="date" id="date" name="date" required>
		</div>
		<div class="form-group">
			<label for="time">Time</label>
			<input type="time" id="time" name="time" required>
		</div>
		<div class="form-group">
			<label for="service">Service</label>
			<select id="service" name="service" required>
				<option value="General Checkup">General Checkup</option>
				<option value="Vaccination">Vaccination</option>
				<option value="Grooming">Grooming</option>
				<option value="Dentistry">Dentistry</option>
			</select>
		</div>
		<input type="submit" name="submit_booking" value="Book">
	</form>
</div>

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

<?php include 'includes/footer.php'; ?>



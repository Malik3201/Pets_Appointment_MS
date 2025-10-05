<?php include 'includes/header.php'; ?>

<?php
if (!isset($_SESSION['admin_id'])) {
	header('Location: admin_login.php');
	exit;
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
	session_destroy();
	header('Location: admin_login.php');
	exit;
}

// Simple action router for CRUD operations
$tab = $_GET['tab'] ?? 'appointments';
$message = '';

// Delete handlers
if (isset($_GET['delete']) && isset($_GET['type'])) {
	$type = $_GET['type'];
	$id = (int)$_GET['delete'];
	if ($type === 'owner') {
		$stmt = $mysqli->prepare('DELETE FROM owners WHERE id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
		$message = 'Owner deleted.';
	} elseif ($type === 'pet') {
		$stmt = $mysqli->prepare('DELETE FROM pets WHERE id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
		$message = 'Pet deleted.';
	} elseif ($type === 'appointment') {
		$stmt = $mysqli->prepare('DELETE FROM appointments WHERE id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
		$message = 'Appointment deleted.';
	}
}

// Appointment status update
if (isset($_POST['update_status'])) {
	$id = (int)$_POST['id'];
	$status = sanitize($_POST['status'] ?? 'Pending');
	$stmt = $mysqli->prepare('UPDATE appointments SET status = ? WHERE id = ?');
	$stmt->bind_param('si', $status, $id);
	$stmt->execute();
	$stmt->close();
	$message = 'Appointment status updated.';
	// If approved, generate receipt
	if ($status === 'Approved') {
		require_once __DIR__ . '/generate_receipt.php';
		generate_receipt_pdf($id, true);
	}
}

// Simple edit owner
if (isset($_POST['save_owner'])) {
	$id = (int)$_POST['id'];
	$owner_name = sanitize($_POST['owner_name'] ?? '');
	$email = sanitize($_POST['email'] ?? '');
	$phone = sanitize($_POST['phone'] ?? '');
	$address = sanitize($_POST['address'] ?? '');
	$stmt = $mysqli->prepare('UPDATE owners SET owner_name = ?, email = ?, phone = ?, address = ? WHERE id = ?');
	$stmt->bind_param('ssssi', $owner_name, $email, $phone, $address, $id);
	$stmt->execute();
	$stmt->close();
	$message = 'Owner updated.';
}

// Simple edit pet
if (isset($_POST['save_pet'])) {
	$id = (int)$_POST['id'];
	$pet_name = sanitize($_POST['pet_name'] ?? '');
	$type = sanitize($_POST['type'] ?? '');
	$age = (int)($_POST['age'] ?? 0);
	$stmt = $mysqli->prepare('UPDATE pets SET pet_name = ?, type = ?, age = ? WHERE id = ?');
	$stmt->bind_param('ssii', $pet_name, $type, $age, $id);
	$stmt->execute();
	$stmt->close();
	$message = 'Pet updated.';
}

// Fetch tables
$owners = $mysqli->query('SELECT * FROM owners ORDER BY id DESC');
$pets = $mysqli->query('SELECT p.*, o.owner_name FROM pets p JOIN owners o ON p.owner_id = o.id ORDER BY p.id DESC');
$appointments = $mysqli->query('SELECT a.*, p.pet_name, o.owner_name FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id ORDER BY a.id DESC');
?>

<div class="card">
	<h2>Admin Dashboard</h2>
	<p>
		<a href="?tab=appointments">Appointments</a> |
		<a href="?tab=pets">Pets</a> |
		<a href="?tab=owners">Owners</a> |
		<a href="?tab=reports">Reports</a> |
		<a href="?action=logout">Logout</a>
	</p>
	<?php if ($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>

	<?php if ($tab === 'owners'): ?>
		<h3>Owners</h3>
		<table>
			<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Actions</th></tr>
			<?php while ($o = $owners->fetch_assoc()): ?>
			<tr>
				<form method="post">
					<td><?php echo $o['id']; ?><input type="hidden" name="id" value="<?php echo $o['id']; ?>"></td>
					<td><input type="text" name="owner_name" value="<?php echo $o['owner_name']; ?>"></td>
					<td><input type="email" name="email" value="<?php echo $o['email']; ?>"></td>
					<td><input type="text" name="phone" value="<?php echo $o['phone']; ?>"></td>
					<td><input type="text" name="address" value="<?php echo $o['address']; ?>"></td>
					<td>
						<button type="submit" name="save_owner">Save</button>
						<a href="?tab=owners&type=owner&delete=<?php echo $o['id']; ?>" onclick="return confirm('Delete owner? This may remove related pets/appointments depending on DB constraints.');">Delete</a>
					</td>
				</form>
			</tr>
			<?php endwhile; ?>
		</table>
	<?php elseif ($tab === 'pets'): ?>
		<h3>Pets</h3>
		<table>
			<tr><th>ID</th><th>Owner</th><th>Name</th><th>Type</th><th>Age</th><th>Actions</th></tr>
			<?php while ($p = $pets->fetch_assoc()): ?>
			<tr>
				<form method="post">
					<td><?php echo $p['id']; ?><input type="hidden" name="id" value="<?php echo $p['id']; ?>"></td>
					<td><?php echo $p['owner_name']; ?></td>
					<td><input type="text" name="pet_name" value="<?php echo $p['pet_name']; ?>"></td>
					<td><input type="text" name="type" value="<?php echo $p['type']; ?>"></td>
					<td><input type="number" name="age" value="<?php echo $p['age']; ?>"></td>
					<td>
						<button type="submit" name="save_pet">Save</button>
						<a href="?tab=pets&type=pet&delete=<?php echo $p['id']; ?>" onclick="return confirm('Delete pet?');">Delete</a>
					</td>
				</form>
			</tr>
			<?php endwhile; ?>
		</table>
	<?php elseif ($tab === 'reports'): ?>
		<h3>Reports</h3>
		<?php
		// Weekly: last 7 days, Monthly: last 30 days
		$weekly = $mysqli->query("SELECT a.id, a.date, a.status, p.pet_name, o.owner_name FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id WHERE a.date >= (CURDATE() - INTERVAL 7 DAY) ORDER BY a.date DESC, a.time DESC");
		$monthly = $mysqli->query("SELECT a.id, a.date, a.status, p.pet_name, o.owner_name FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id WHERE a.date >= (CURDATE() - INTERVAL 30 DAY) ORDER BY a.date DESC, a.time DESC");
		$weekly_count = $weekly ? $weekly->num_rows : 0;
		$monthly_count = $monthly ? $monthly->num_rows : 0;
		?>
		<p><strong>This week:</strong> <?php echo $weekly_count; ?> appointments | <strong>This month:</strong> <?php echo $monthly_count; ?> appointments</p>

		<h4>Weekly Report (Last 7 Days)</h4>
		<table>
			<tr><th>ID</th><th>Pet</th><th>Owner</th><th>Date</th><th>Status</th></tr>
			<?php if ($weekly): while ($w = $weekly->fetch_assoc()): ?>
			<tr>
				<td><?php echo $w['id']; ?></td>
				<td><?php echo $w['pet_name']; ?></td>
				<td><?php echo $w['owner_name']; ?></td>
				<td><?php echo $w['date']; ?></td>
				<td><?php echo $w['status']; ?></td>
			</tr>
			<?php endwhile; endif; ?>
		</table>

		<h4>Monthly Report (Last 30 Days)</h4>
		<table>
			<tr><th>ID</th><th>Pet</th><th>Owner</th><th>Date</th><th>Status</th></tr>
			<?php if ($monthly): while ($m = $monthly->fetch_assoc()): ?>
			<tr>
				<td><?php echo $m['id']; ?></td>
				<td><?php echo $m['pet_name']; ?></td>
				<td><?php echo $m['owner_name']; ?></td>
				<td><?php echo $m['date']; ?></td>
				<td><?php echo $m['status']; ?></td>
			</tr>
			<?php endwhile; endif; ?>
		</table>
	<?php else: ?>
		<h3>Appointments</h3>
		<table>
			<tr><th>ID</th><th>Owner</th><th>Pet</th><th>Date</th><th>Time</th><th>Service</th><th>Status</th><th>Actions</th></tr>
			<?php while ($a = $appointments->fetch_assoc()): ?>
			<tr>
				<td><?php echo $a['id']; ?></td>
				<td><?php echo $a['owner_name']; ?></td>
				<td><?php echo $a['pet_name']; ?></td>
				<td><?php echo $a['date']; ?></td>
				<td><?php echo $a['time']; ?></td>
				<td><?php echo $a['service']; ?></td>
				<td>
					<form method="post" style="display:inline-block;">
						<input type="hidden" name="id" value="<?php echo $a['id']; ?>">
						<select name="status">
							<?php foreach (['Pending','Approved','Cancelled'] as $s): ?>
								<option value="<?php echo $s; ?>" <?php echo $a['status'] === $s ? 'selected' : ''; ?>><?php echo $s; ?></option>
							<?php endforeach; ?>
						</select>
						<button type="submit" name="update_status">Update</button>
					</form>
				</td>
				<td>
					<a href="?tab=appointments&type=appointment&delete=<?php echo $a['id']; ?>" onclick="return confirm('Delete appointment?');">Delete</a>
				</td>
			</tr>
			<?php endwhile; ?>
		</table>
	<?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>



<?php
// Include configuration
require_once __DIR__ . '/config.php';

// Check admin authentication BEFORE any output
if (!isset($_SESSION['admin_id'])) {
	header('Location: admin_login.php');
	exit;
}

// Handle logout BEFORE any output
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
	session_destroy();
	header('Location: admin_login.php');
	exit;
}

// Set page title for header
$page_title = 'Admin Dashboard - Pets Care';
require __DIR__ . '/partials/header.php';
?>

<?php
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
		try {
			require_once __DIR__ . '/generate_receipt.php';
			$receiptPath = generate_receipt_professional($id, true);
			if ($receiptPath) {
				$message = 'Appointment status updated and receipt generated.';
			}
		} catch (Exception $e) {
			// Receipt generation failed, but appointment was still updated
			$message = 'Appointment status updated (receipt generation failed).';
		}
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

<!-- Admin Dashboard Section -->
<section class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <!-- Dashboard Header -->
        <div class="admin-dashboard-header">
            <div class="dashboard-title">
                <h1>Admin Dashboard</h1>
                <p>Pets Care Management System</p>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3><?php echo $appointments->num_rows; ?></h3>
                    <p>Total Appointments</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3><?php echo $pets->num_rows; ?></h3>
                    <p>Registered Pets</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3><?php echo $owners->num_rows; ?></h3>
                    <p>Pet Owners</p>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="admin-tabs">
            <a href="?tab=appointments" class="tab-link <?php echo $tab === 'appointments' ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
                Appointments
            </a>
            <a href="?tab=pets" class="tab-link <?php echo $tab === 'pets' ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"/>
                </svg>
                Pets
            </a>
            <a href="?tab=owners" class="tab-link <?php echo $tab === 'owners' ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                Owners
            </a>
            <a href="?tab=reports" class="tab-link <?php echo $tab === 'reports' ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                </svg>
                Reports
            </a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Dashboard Content -->
        <div class="dashboard-content">

	<?php if ($tab === 'owners'): ?>
                <div class="content-card">
                    <div class="content-header">
                        <h2>Pet Owners Management</h2>
                        <p>Manage registered pet owners and their information</p>
                    </div>
                    
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
			<?php while ($o = $owners->fetch_assoc()): ?>
			<tr>
				<form method="post">
                                        <td class="id-cell"><?php echo $o['id']; ?><input type="hidden" name="id" value="<?php echo $o['id']; ?>"></td>
                                        <td><input type="text" name="owner_name" value="<?php echo htmlspecialchars($o['owner_name']); ?>" class="admin-input"></td>
                                        <td><input type="email" name="email" value="<?php echo htmlspecialchars($o['email']); ?>" class="admin-input"></td>
                                        <td><input type="text" name="phone" value="<?php echo htmlspecialchars($o['phone']); ?>" class="admin-input"></td>
                                        <td><input type="text" name="address" value="<?php echo htmlspecialchars($o['address']); ?>" class="admin-input"></td>
                                        <td class="actions-cell">
                                            <button type="submit" name="save_owner" class="btn btn--small btn--primary">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                                                </svg>
                                                Save
                                            </button>
                                            <a href="?tab=owners&type=owner&delete=<?php echo $o['id']; ?>" 
                                               onclick="return confirm('Delete owner? This may remove related pets/appointments depending on DB constraints.');" 
                                               class="btn btn--small btn--danger">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                                Delete
                                            </a>
					</td>
				</form>
			</tr>
			<?php endwhile; ?>
                            </tbody>
		</table>
                    </div>
                </div>
	<?php elseif ($tab === 'pets'): ?>
                <div class="content-card">
                    <div class="content-header">
                        <h2>Pets Management</h2>
                        <p>Manage registered pets and their information</p>
                    </div>
                    
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Owner</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Age</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
			<?php while ($p = $pets->fetch_assoc()): ?>
			<tr>
				<form method="post">
                                        <td class="id-cell"><?php echo $p['id']; ?><input type="hidden" name="id" value="<?php echo $p['id']; ?>"></td>
                                        <td><?php echo htmlspecialchars($p['owner_name']); ?></td>
                                        <td><input type="text" name="pet_name" value="<?php echo htmlspecialchars($p['pet_name']); ?>" class="admin-input"></td>
                                        <td><input type="text" name="type" value="<?php echo htmlspecialchars($p['type']); ?>" class="admin-input"></td>
                                        <td><input type="number" name="age" value="<?php echo $p['age']; ?>" class="admin-input" min="0" max="30"></td>
                                        <td class="actions-cell">
                                            <button type="submit" name="save_pet" class="btn btn--small btn--primary">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                                                </svg>
                                                Save
                                            </button>
                                            <a href="?tab=pets&type=pet&delete=<?php echo $p['id']; ?>" 
                                               onclick="return confirm('Delete pet?');" 
                                               class="btn btn--small btn--danger">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                                Delete
                                            </a>
					</td>
				</form>
			</tr>
			<?php endwhile; ?>
                            </tbody>
		</table>
                    </div>
                </div>
	<?php elseif ($tab === 'reports'): ?>
		<?php
		// Weekly: last 7 days, Monthly: last 30 days
		$weekly = $mysqli->query("SELECT a.id, a.date, a.status, p.pet_name, o.owner_name FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id WHERE a.date >= (CURDATE() - INTERVAL 7 DAY) ORDER BY a.date DESC, a.time DESC");
		$monthly = $mysqli->query("SELECT a.id, a.date, a.status, p.pet_name, o.owner_name FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id WHERE a.date >= (CURDATE() - INTERVAL 30 DAY) ORDER BY a.date DESC, a.time DESC");
		$weekly_count = $weekly ? $weekly->num_rows : 0;
		$monthly_count = $monthly ? $monthly->num_rows : 0;
		?>
                
                <div class="content-card">
                    <div class="content-header">
                        <h2>Reports & Analytics</h2>
                        <p>View appointment statistics and reports</p>
                    </div>
                    
                    <div class="reports-summary">
                        <div class="report-stat">
                            <div class="report-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                            </div>
                            <div class="report-content">
                                <h3><?php echo $weekly_count; ?></h3>
                                <p>This Week</p>
                            </div>
                        </div>
                        <div class="report-stat">
                            <div class="report-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                </svg>
                            </div>
                            <div class="report-content">
                                <h3><?php echo $monthly_count; ?></h3>
                                <p>This Month</p>
                            </div>
                        </div>
                    </div>

                    <div class="report-section">
                        <h3>Weekly Report (Last 7 Days)</h3>
                        <div class="table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pet</th>
                                        <th>Owner</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
			<?php if ($weekly): while ($w = $weekly->fetch_assoc()): ?>
			<tr>
				<td><?php echo $w['id']; ?></td>
                                        <td><?php echo htmlspecialchars($w['pet_name']); ?></td>
                                        <td><?php echo htmlspecialchars($w['owner_name']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($w['date'])); ?></td>
                                        <td><span class="status status--<?php echo strtolower($w['status']); ?>"><?php echo $w['status']; ?></span></td>
			</tr>
			<?php endwhile; endif; ?>
                                </tbody>
		</table>
                        </div>
                    </div>

                    <div class="report-section">
                        <h3>Monthly Report (Last 30 Days)</h3>
                        <div class="table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pet</th>
                                        <th>Owner</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
			<?php if ($monthly): while ($m = $monthly->fetch_assoc()): ?>
			<tr>
				<td><?php echo $m['id']; ?></td>
                                        <td><?php echo htmlspecialchars($m['pet_name']); ?></td>
                                        <td><?php echo htmlspecialchars($m['owner_name']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($m['date'])); ?></td>
                                        <td><span class="status status--<?php echo strtolower($m['status']); ?>"><?php echo $m['status']; ?></span></td>
			</tr>
			<?php endwhile; endif; ?>
                                </tbody>
		</table>
                        </div>
                    </div>
                </div>
	<?php else: ?>
                <div class="content-card">
                    <div class="content-header">
                        <h2>Appointments Management</h2>
                        <p>Manage and update appointment statuses</p>
                    </div>
                    
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Owner</th>
                                    <th>Pet</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
			<?php while ($a = $appointments->fetch_assoc()): ?>
			<tr>
                                    <td class="id-cell"><?php echo $a['id']; ?></td>
                                    <td><?php echo htmlspecialchars($a['owner_name']); ?></td>
                                    <td><?php echo htmlspecialchars($a['pet_name']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($a['date'])); ?></td>
                                    <td><?php echo date('g:i A', strtotime($a['time'])); ?></td>
                                    <td><?php echo htmlspecialchars($a['service']); ?></td>
                                    <td>
                                        <form method="post" class="status-form">
						<input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                                            <select name="status" class="status-select">
							<?php foreach (['Pending','Approved','Cancelled'] as $s): ?>
								<option value="<?php echo $s; ?>" <?php echo $a['status'] === $s ? 'selected' : ''; ?>><?php echo $s; ?></option>
							<?php endforeach; ?>
						</select>
                                            <button type="submit" name="update_status" class="btn btn--small btn--primary">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                                </svg>
                                                Update
                                            </button>
					</form>
				</td>
                                    <td class="actions-cell">
                                        <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                            <?php if ($a['status'] === 'Approved'): ?>
                                                <a href="generate_receipt_professional.php?id=<?php echo $a['id']; ?>" 
                                                   target="_blank" 
                                                   class="btn btn--small btn--ghost" 
                                                   style="flex: 1; min-width: 80px; font-size: 11px;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                    </svg>
                                                    Receipt
                                                </a>
                                            <?php endif; ?>
                                            <a href="?tab=appointments&type=appointment&delete=<?php echo $a['id']; ?>" 
                                               onclick="return confirm('Delete appointment?');" 
                                               class="btn btn--small btn--danger"
                                               style="flex: 1; min-width: 80px; font-size: 11px;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                                Delete
                                            </a>
                                        </div>
				</td>
			</tr>
			<?php endwhile; ?>
                            </tbody>
		</table>
                    </div>
                </div>
	<?php endif; ?>
</div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>



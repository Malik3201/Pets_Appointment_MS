<?php
// Include configuration
require_once __DIR__ . '/config.php';

// Set page title for header
$page_title = 'View Appointments - Pets Care';
require __DIR__ . '/partials/header.php';
?>

<?php
$message = '';
$appointments = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = sanitize($_POST['email'] ?? '');
	$phone = sanitize($_POST['phone'] ?? '');
	if ($email || $phone) {
		$stmt = $mysqli->prepare('SELECT a.id, a.date, a.time, a.service, a.status, p.pet_name FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id WHERE (o.email = ? OR o.phone = ?) ORDER BY a.date DESC, a.time DESC');
		$stmt->bind_param('ss', $email, $phone);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) { $appointments[] = $row; }
		$stmt->close();
		if (!$appointments) { $message = 'No appointments found.'; }
	} else {
		$message = 'Enter email or phone to search.';
	}
}
?>

<!-- View Appointments Section -->
<section class="section" data-bg="assets/bgVideo/main_bg.jpg">
    <div class="container">
        <div class="section-content">
            <div class="section-header">
                <h2 class="section-title">View Your Appointments</h2>
                <p class="section-subtitle">Check your pet's scheduled appointments and download receipts.</p>
            </div>
            
            <div class="appointments-container">
                <div class="search-form-card">
                    <h3 class="form-section-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        Search Your Appointments
                    </h3>
                    
                    <form method="post" action="" class="search-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" placeholder="your.email@example.com">
                            </div>
		<div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="+1 (234) 567-8900">
		</div>
		<div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn--primary">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                    </svg>
                                    Search Appointments
                                </button>
                            </div>
		</div>
	</form>
                </div>

	<?php if ($message): ?>
                    <div class="alert <?php echo strpos($message, 'No appointments') === 0 ? 'alert-info' : 'alert-error'; ?>">
                        <?php echo $message; ?>
                    </div>
	<?php endif; ?>

	<?php if ($appointments): ?>
                    <div class="appointments-results">
                        <h3 class="results-title">Your Appointments</h3>
                        <div class="appointments-grid">
				<?php foreach ($appointments as $a): ?>
                                <div class="appointment-card">
                                    <div class="appointment-header">
                                        <h4 class="pet-name"><?php echo $a['pet_name']; ?></h4>
                                        <span class="appointment-id">#<?php echo $a['id']; ?></span>
                                    </div>
                                    
                                    <div class="appointment-details">
                                        <div class="detail-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                            </svg>
                                            <span class="detail-label">Date:</span>
                                            <span class="detail-value"><?php echo date('M j, Y', strtotime($a['date'])); ?></span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                            </svg>
                                            <span class="detail-label">Time:</span>
                                            <span class="detail-value"><?php echo date('g:i A', strtotime($a['time'])); ?></span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            <span class="detail-label">Service:</span>
                                            <span class="detail-value"><?php echo $a['service']; ?></span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                            <span class="detail-label">Status:</span>
                                            <span class="status status--<?php echo strtolower($a['status']); ?>"><?php echo $a['status']; ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="appointment-footer">
							<?php if ($a['status'] === 'Approved'): ?>
                                            <a href="generate_receipt.php?id=<?php echo $a['id']; ?>" target="_blank" class="btn btn--ghost btn--small">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                </svg>
                                                Download Receipt
                                            </a>
								<?php else: ?>
                                            <span class="approval-info">Waiting for admin approval</span>
								<?php endif; ?>
                                    </div>
                                </div>
				<?php endforeach; ?>
                        </div>
                    </div>
	<?php endif; ?>
</div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>



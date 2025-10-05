<?php include 'includes/header.php'; ?>

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

<div class="card">
	<h2>View Appointments</h2>
	<form method="post" action="">
		<div class="form-group">
			<label for="email">Owner Email</label>
			<input type="email" id="email" name="email" placeholder="example@mail.com">
		</div>
		<div class="form-group">
			<label for="phone">Owner Phone</label>
			<input type="tel" id="phone" name="phone" placeholder="Optional if email is filled">
		</div>
		<input type="submit" value="Search">
	</form>

	<?php if ($message): ?>
		<div class="alert <?php echo strpos($message, 'No appointments') === 0 ? '' : 'alert-error'; ?>"><?php echo $message; ?></div>
	<?php endif; ?>

	<?php if ($appointments): ?>
		<table>
			<thead>
			<tr>
					<th>ID</th>
					<th>Pet</th>
					<th>Date</th>
					<th>Time</th>
					<th>Service</th>
					<th>Status</th>
					<th>Receipt</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($appointments as $a): ?>
					<tr>
						<td><?php echo $a['id']; ?></td>
						<td><?php echo $a['pet_name']; ?></td>
						<td><?php echo $a['date']; ?></td>
						<td><?php echo $a['time']; ?></td>
						<td><?php echo $a['service']; ?></td>
						<td><?php echo $a['status']; ?></td>
						<td>
							<?php if ($a['status'] === 'Approved'): ?>
								<?php $receiptPath = 'receipts/appointment_' . $a['id'] . '.pdf'; ?>
								<?php if (file_exists($receiptPath)): ?>
									<a href="<?php echo $receiptPath; ?>" target="_blank">Download Receipt (PDF)</a>
								<?php else: ?>
									<span>Receipt not generated yet.</span>
								<?php endif; ?>
							<?php else: ?>
								<span>Waiting for admin approval</span>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>



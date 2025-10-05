<?php
// Generates a PDF receipt for a specific appointment id.
// Usage (internal): include this after approving an appointment, or call via link with ?id=XX for testing.

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lib/fpdf.php';

function generate_receipt_pdf($appointment_id, $saveToFile = true) {
	global $mysqli;
	$appointment_id = (int)$appointment_id;
	$stmt = $mysqli->prepare('SELECT a.id, a.date, a.time, a.service, a.status, p.pet_name, p.type, o.owner_name FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id WHERE a.id = ? LIMIT 1');
	$stmt->bind_param('i', $appointment_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_assoc();
	$stmt->close();
	if (!$data) { return false; }

	$pdf = new FPDF();
	$pdf->SetFont('Helvetica','',14);
	$pdf->Cell(0, 10, 'Pet Care Management System - Appointment Receipt', 0, 1);
	$pdf->Ln(2);
	$pdf->SetFont('Helvetica','',12);
	$pdf->Cell(0, 8, 'Appointment ID: ' . $data['id'], 0, 1);
	$pdf->Cell(0, 8, 'Owner: ' . $data['owner_name'], 0, 1);
	$pdf->Cell(0, 8, 'Pet: ' . $data['pet_name'] . ' (' . $data['type'] . ')', 0, 1);
	$pdf->Cell(0, 8, 'Service: ' . $data['service'], 0, 1);
	$pdf->Cell(0, 8, 'Date & Time: ' . $data['date'] . ' ' . $data['time'], 0, 1);
	$pdf->Cell(0, 8, 'Status: ' . $data['status'], 0, 1);

	$receiptsDir = __DIR__ . '/receipts';
	if (!is_dir($receiptsDir)) { mkdir($receiptsDir, 0777, true); }
	$filePath = $receiptsDir . '/appointment_' . $appointment_id . '.pdf';
	if ($saveToFile) {
		$pdf->Output('F', $filePath);
		return $filePath;
	} else {
		$pdf->Output('I', 'appointment_' . $appointment_id . '.pdf');
		return true;
	}
}

// If called directly with ?id=, stream the PDF to browser for testing.
if (isset($_GET['id'])) {
	$id = (int)$_GET['id'];
	generate_receipt_pdf($id, false);
	exit;
}

?>



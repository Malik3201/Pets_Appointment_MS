<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

$email = sanitize($_GET['email'] ?? '');
$phone = sanitize($_GET['phone'] ?? '');

$pets = [];
if ($email || $phone) {
	$stmt = $mysqli->prepare('SELECT pets.id, pets.pet_name FROM pets JOIN owners ON pets.owner_id = owners.id WHERE (owners.email = ? OR owners.phone = ?) ORDER BY pets.pet_name');
	$stmt->bind_param('ss', $email, $phone);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) { $pets[] = $row; }
	$stmt->close();
}

echo json_encode(['pets' => $pets]);
exit;
?>



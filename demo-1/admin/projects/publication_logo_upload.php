<?php
// Uploads/replaces the logo for a publication name. Stored once per name in publication_logos,
// so it is immediately reused by every review (across every project) that uses that same name.
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

header('Content-Type: application/json');

$publication = trim($_POST['publication'] ?? '');
if ($publication === '') {
    echo json_encode(['error' => 'Enter the publication name first.']);
    exit;
}

if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'No file uploaded.']);
    exit;
}

$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
$extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
if (!in_array($extension, $allowed_extensions)) {
    echo json_encode(['error' => 'Invalid file type. Only JPG, JPEG, PNG, GIF, WebP and SVG are allowed.']);
    exit;
}
if ($_FILES['logo']['size'] > 2000000) {
    echo json_encode(['error' => 'File size too large. Maximum 2MB allowed.']);
    exit;
}

$upload_dir = __DIR__ . '/../../assets/img/review/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$new_name = 'pub-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($publication)) . '-' . uniqid() . '.' . $extension;
if (!move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $new_name)) {
    echo json_encode(['error' => 'Error uploading file.']);
    exit;
}

$stmt = $connect->prepare("INSERT INTO publication_logos (publication, logo) VALUES (?, ?) ON DUPLICATE KEY UPDATE logo = VALUES(logo)");
$stmt->execute([$publication, $new_name]);

echo json_encode(['logo' => 'uploads/' . $new_name]);

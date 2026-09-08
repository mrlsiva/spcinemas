<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';
header('Content-Type: application/json');

$id = (int)($_POST["id"] ?? 0);

$stmt = $connect->prepare("SELECT status FROM team_members WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    echo json_encode(['success' => false]);
    exit;
}

$new_status = $row['status'] === 'enabled' ? 'disabled' : 'enabled';
$stmt = $connect->prepare("UPDATE team_members SET status = ? WHERE id = ?");
$stmt->execute([$new_status, $id]);

echo json_encode(['success' => true, 'status' => $new_status]);

<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';
header('Content-Type: application/json');

$ids = $_POST['ids'] ?? [];

if (!is_array($ids) || empty($ids)) {
    echo json_encode(['success' => false, 'message' => 'No order provided']);
    exit;
}

$stmt = $connect->prepare("UPDATE projects SET sort_order = ? WHERE id = ?");
$order = 1;
foreach ($ids as $id) {
    $stmt->execute([$order, (int)$id]);
    $order++;
}

echo json_encode(['success' => true]);

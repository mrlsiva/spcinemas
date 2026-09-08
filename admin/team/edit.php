<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$stmt = $connect->prepare("SELECT * FROM team_members WHERE id = ?");
$stmt->execute([(int)($_POST["id"] ?? 0)]);
$row = $stmt->fetch();

$output = [];
if ($row) {
    $output = [
        'id' => $row['id'],
        'name' => $row['name'],
        'role' => $row['role'],
        'bio' => $row['bio'],
        'status' => $row['status'],
    ];
}

echo json_encode($output);

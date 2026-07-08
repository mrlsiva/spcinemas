<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$next_order = (int)$connect->query("SELECT COALESCE(MAX(sort_order), 0) + 1 FROM team_members")->fetchColumn();
$status = in_array($_POST["status"] ?? '', ['enabled', 'disabled']) ? $_POST["status"] : 'enabled';

$stmt = $connect->prepare("INSERT INTO team_members (name, role, bio, sort_order, status) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([
    $_POST["name"] ?? '',
    $_POST["role"] ?? '',
    $_POST["bio"] ?? '',
    $next_order,
    $status,
]);

echo "success";

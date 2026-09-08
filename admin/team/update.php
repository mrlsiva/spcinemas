<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$id = (int)($_POST["id"] ?? 0);
$status = in_array($_POST["status"] ?? '', ['enabled', 'disabled']) ? $_POST["status"] : 'enabled';

$stmt = $connect->prepare("UPDATE team_members SET name = ?, role = ?, bio = ?, status = ? WHERE id = ?");
$stmt->execute([
    $_POST["name"] ?? '',
    $_POST["role"] ?? '',
    $_POST["bio"] ?? '',
    $status,
    $id,
]);

echo "success";

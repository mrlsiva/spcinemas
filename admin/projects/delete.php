<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$id = (int)($_POST["id"] ?? 0);

$stmt = $connect->prepare("SELECT image FROM projects WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

$stmt = $connect->prepare("DELETE FROM projects WHERE id = ?");
$stmt->execute([$id]);

if ($row) {
    $path = __DIR__ . '/../../assets/img/portfolio/940/' . $row['image'];
    if (is_file($path)) {
        unlink($path);
    }
}

echo "success";

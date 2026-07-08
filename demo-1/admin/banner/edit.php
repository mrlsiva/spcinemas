<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$stmt = $connect->prepare("SELECT * FROM banner_slides WHERE id = ?");
$stmt->execute([(int)($_POST["id"] ?? 0)]);
$row = $stmt->fetch();

$output = [];
if ($row) {
    $output = [
        'id' => $row['id'],
        'title' => $row['title'],
        'category' => $row['category'],
        'link_url' => $row['link_url'],
        'image' => $row['image'],
        'mobile_image' => $row['mobile_image'],
        'status' => $row['status'],
    ];
}

echo json_encode($output);

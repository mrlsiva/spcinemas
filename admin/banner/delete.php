<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$id = (int)($_POST["id"] ?? 0);

$stmt = $connect->prepare("SELECT image, mobile_image FROM banner_slides WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

$stmt = $connect->prepare("DELETE FROM banner_slides WHERE id = ?");
$stmt->execute([$id]);

if ($row) {
    $path = __DIR__ . '/../../assets/img/portfolio/1920/' . $row['image'];
    if (is_file($path)) {
        unlink($path);
    }
    if ($row['mobile_image']) {
        $mobile_path = __DIR__ . '/../../assets/img/portfolio/mobile/' . $row['mobile_image'];
        if (is_file($mobile_path)) {
            unlink($mobile_path);
        }
    }
}

echo "success";

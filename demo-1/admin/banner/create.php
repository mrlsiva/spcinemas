<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';
require __DIR__ . '/_upload_helper.php';

if (!isset($_FILES["image"]) || $_FILES["image"]["error"] != 0) {
    echo "Image is required.";
    exit;
}

$upload_dir = __DIR__ . '/../../assets/img/portfolio/1920/';
$mobile_upload_dir = __DIR__ . '/../../assets/img/portfolio/mobile/';

$file_name = handle_banner_upload('image', $upload_dir);
$mobile_file_name = handle_banner_upload('mobile_image', $mobile_upload_dir);

$next_order = (int)$connect->query("SELECT COALESCE(MAX(sort_order), 0) + 1 FROM banner_slides")->fetchColumn();
$status = in_array($_POST["status"] ?? '', ['enabled', 'disabled']) ? $_POST["status"] : 'enabled';

$stmt = $connect->prepare("
INSERT INTO banner_slides (title, category, link_url, image, mobile_image, sort_order, status)
VALUES (?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([
    $_POST["title"] ?? '',
    $_POST["category"] ?? '',
    ($_POST["link_url"] ?? '') !== '' ? $_POST["link_url"] : '#',
    $file_name,
    $mobile_file_name,
    $next_order,
    $status,
]);

echo "success";

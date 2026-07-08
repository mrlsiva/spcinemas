<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';
require __DIR__ . '/_upload_helper.php';

$id = (int)($_POST["id"] ?? 0);
$title = $_POST["title"] ?? '';
$category = $_POST["category"] ?? '';
$link_url = ($_POST["link_url"] ?? '') !== '' ? $_POST["link_url"] : '#';
$status = in_array($_POST["status"] ?? '', ['enabled', 'disabled']) ? $_POST["status"] : 'enabled';

$upload_dir = __DIR__ . '/../../assets/img/portfolio/1920/';
$mobile_upload_dir = __DIR__ . '/../../assets/img/portfolio/mobile/';

$file_name = handle_banner_upload('image', $upload_dir);
$mobile_file_name = handle_banner_upload('mobile_image', $mobile_upload_dir);

$fields = ['title = ?', 'category = ?', 'link_url = ?', 'status = ?'];
$params = [$title, $category, $link_url, $status];

if ($file_name !== null) {
    $fields[] = 'image = ?';
    $params[] = $file_name;
}
if ($mobile_file_name !== null) {
    $fields[] = 'mobile_image = ?';
    $params[] = $mobile_file_name;
}

$params[] = $id;
$stmt = $connect->prepare("UPDATE banner_slides SET " . implode(', ', $fields) . " WHERE id = ?");
$stmt->execute($params);

echo "success";

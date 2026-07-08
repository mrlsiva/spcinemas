<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';
require __DIR__ . '/_save_popup_content.php';

if (!isset($_FILES["image"]) || $_FILES["image"]["error"] != 0) {
    echo "Image is required.";
    exit;
}

$file_name = $_FILES["image"]["name"];
$tmp_name = $_FILES["image"]["tmp_name"];
$file_array = explode(".", $file_name);
$file_extension = strtolower(end($file_array));

$allowed_extensions = ["jpg", "jpeg", "png", "gif", "webp"];
if (!in_array($file_extension, $allowed_extensions)) {
    echo "Invalid file type. Only JPG, JPEG, PNG, GIF, and WebP files are allowed.";
    exit;
}

if ($_FILES["image"]["size"] > 2000000) {
    echo "File size too large. Maximum 2MB allowed.";
    exit;
}

$category = in_array($_POST["category"] ?? '', ['branding', 'people', 'nature']) ? $_POST["category"] : 'branding';

$upload_dir = __DIR__ . '/../../assets/img/portfolio/940/';
if (file_exists($upload_dir . $file_name)) {
    $file_name = $file_array[0] . '-' . rand() . '.' . $file_extension;
}

if (!move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
    echo "Error uploading file.";
    exit;
}

$next_order = (int)$connect->query("SELECT COALESCE(MAX(sort_order), 0) + 1 FROM projects")->fetchColumn();
$status = in_array($_POST["status"] ?? '', ['enabled', 'disabled']) ? $_POST["status"] : 'enabled';

$stmt = $connect->prepare("
INSERT INTO projects (title, category, image, link_url, credits, synopsis, sort_order, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([
    $_POST["title"] ?? '',
    $category,
    $file_name,
    ($_POST["link_url"] ?? '') !== '' ? $_POST["link_url"] : '#',
    $_POST["credits"] ?? '',
    $_POST["synopsis"] ?? '',
    $next_order,
    $status,
]);

save_project_popup_content($connect, (int)$connect->lastInsertId());

echo "success";

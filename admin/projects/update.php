<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';
require __DIR__ . '/_save_popup_content.php';

$id = (int)($_POST["id"] ?? 0);
$title = $_POST["title"] ?? '';
$category = in_array($_POST["category"] ?? '', ['branding', 'people', 'nature']) ? $_POST["category"] : 'branding';
$link_url = ($_POST["link_url"] ?? '') !== '' ? $_POST["link_url"] : '#';
$credits = $_POST["credits"] ?? '';
$synopsis = $_POST["synopsis"] ?? '';
$status = in_array($_POST["status"] ?? '', ['enabled', 'disabled']) ? $_POST["status"] : 'enabled';

$upload_dir = __DIR__ . '/../../assets/img/portfolio/940/';

if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
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

    if (file_exists($upload_dir . $file_name)) {
        $file_name = $file_array[0] . '-' . rand() . '.' . $file_extension;
    }
    if (!move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
        echo "Error uploading file.";
        exit;
    }

    $stmt = $connect->prepare("UPDATE projects SET title = ?, category = ?, image = ?, link_url = ?, credits = ?, synopsis = ?, status = ? WHERE id = ?");
    $stmt->execute([$title, $category, $file_name, $link_url, $credits, $synopsis, $status, $id]);
} else {
    $stmt = $connect->prepare("UPDATE projects SET title = ?, category = ?, link_url = ?, credits = ?, synopsis = ?, status = ? WHERE id = ?");
    $stmt->execute([$title, $category, $link_url, $credits, $synopsis, $status, $id]);
}

save_project_popup_content($connect, $id);

echo "success";

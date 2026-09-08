<?php
// Validates and moves an uploaded image into $upload_dir, returning the (possibly
// deduped) filename. Echoes an error and exits on failure. Returns null if the
// given $_FILES field wasn't submitted (used for the optional mobile image).
function handle_banner_upload(string $field, string $upload_dir): ?string {
    if (!isset($_FILES[$field]) || $_FILES[$field]["error"] !== 0) {
        return null;
    }

    $file_name = $_FILES[$field]["name"];
    $tmp_name = $_FILES[$field]["tmp_name"];
    $file_array = explode(".", $file_name);
    $file_extension = strtolower(end($file_array));

    $allowed_extensions = ["jpg", "jpeg", "png", "gif", "webp"];
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Invalid file type. Only JPG, JPEG, PNG, GIF, and WebP files are allowed.";
        exit;
    }
    if ($_FILES[$field]["size"] > 2000000) {
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

    return $file_name;
}

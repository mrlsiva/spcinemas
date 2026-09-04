<?php
// Returns the logo already on file for a publication name (uploaded once, reused by every
// review that uses that name), plus any built-in default logo bundled with the app.
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

header('Content-Type: application/json');

$publication = trim($_POST['publication'] ?? '');
$logo = null;

if ($publication !== '') {
    try {
        $stmt = $connect->prepare("SELECT logo FROM publication_logos WHERE publication = ?");
        $stmt->execute([$publication]);
        $custom_logo = $stmt->fetchColumn();
    } catch (PDOException $e) {
        $custom_logo = false;
    }
    if ($custom_logo) {
        $logo = 'uploads/' . $custom_logo;
    } else {
        $publications = require __DIR__ . '/../publications.php';
        $logo = $publications[$publication] ?? null;
    }
}

echo json_encode(['logo' => $logo]);

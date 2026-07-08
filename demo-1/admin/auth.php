<?php
session_start();

function require_admin_login() {
    if (empty($_SESSION['admin_logged_in'])) {
        $doc_root = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/\\'));
        $admin_dir = str_replace('\\', '/', __DIR__);
        $web_path = '/' . trim(str_replace($doc_root, '', $admin_dir), '/') . '/login.php';
        header('Location: ' . $web_path);
        exit;
    }
}

function require_admin_login_ajax() {
    if (empty($_SESSION['admin_logged_in'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Not authenticated']);
        exit;
    }
}

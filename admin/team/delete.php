<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$stmt = $connect->prepare("DELETE FROM team_members WHERE id = ?");
$stmt->execute([(int)($_POST["id"] ?? 0)]);

echo "success";

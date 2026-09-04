<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$id = (int)($_POST["id"] ?? 0);

$stmt = $connect->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

$output = [];
if ($row) {
    $videos_stmt = $connect->prepare("SELECT title, youtube_url FROM project_videos WHERE project_id = ? ORDER BY sort_order ASC, id ASC");
    $videos_stmt->execute([$id]);

    $reviews_stmt = $connect->prepare("SELECT publication, review_url, logo FROM project_reviews WHERE project_id = ? ORDER BY sort_order ASC, id ASC");
    $reviews_stmt->execute([$id]);

    $output = [
        'id' => $row['id'],
        'title' => $row['title'],
        'category' => $row['category'],
        'image' => $row['image'],
        'link_url' => $row['link_url'],
        'credits' => $row['credits'],
        'synopsis' => $row['synopsis'],
        'status' => $row['status'],
        'videos' => $videos_stmt->fetchAll(PDO::FETCH_ASSOC),
        'reviews' => $reviews_stmt->fetchAll(PDO::FETCH_ASSOC),
    ];
}

echo json_encode($output);

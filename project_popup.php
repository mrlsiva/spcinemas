<?php
// Public AJAX endpoint: returns one project's popup body (synopsis/videos/reviews) as an
// HTML fragment, fetched on demand when its card is clicked. Keeps index.php from rendering
// (and loading the video iframes for) every project's popup content on every page load.
require __DIR__ . '/admin/Dbconfig.php';
require __DIR__ . '/inc/project_popup_render.php';

header('Content-Type: text/html; charset=utf-8');

$id = (int)($_GET['id'] ?? 0);

$stmt = $connect->prepare("SELECT * FROM projects WHERE id = ? AND status = 'enabled'");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    http_response_code(404);
    exit;
}

$videos_stmt = $connect->prepare("SELECT * FROM project_videos WHERE project_id = ? ORDER BY sort_order ASC, id ASC");
$videos_stmt->execute([$id]);
$videos = $videos_stmt->fetchAll();

$reviews_stmt = $connect->prepare("SELECT * FROM project_reviews WHERE project_id = ? ORDER BY sort_order ASC, id ASC");
$reviews_stmt->execute([$id]);
$reviews = $reviews_stmt->fetchAll();

$publications = require __DIR__ . '/admin/publications.php';
try {
    foreach ($connect->query("SELECT publication, logo FROM publication_logos") as $row) {
        $publications[$row['publication']] = 'uploads/' . $row['logo'];
    }
} catch (PDOException $e) {
    // publication_logos table not migrated on this environment yet; fall back to the built-in list.
}

echo render_project_popup($project, $videos, $reviews, $publications);

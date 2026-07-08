<?php
// Replaces a project's videos/reviews with what was submitted in the form.
// Shared by create.php and update.php.
function save_project_popup_content(PDO $connect, int $project_id): void {
    $connect->prepare("DELETE FROM project_videos WHERE project_id = ?")->execute([$project_id]);
    $connect->prepare("DELETE FROM project_reviews WHERE project_id = ?")->execute([$project_id]);

    $video_titles = $_POST['videos_title'] ?? [];
    $video_urls = $_POST['videos_url'] ?? [];
    $insert_video = $connect->prepare("INSERT INTO project_videos (project_id, title, youtube_url, sort_order) VALUES (?, ?, ?, ?)");
    $order = 1;
    foreach ($video_titles as $i => $title) {
        $url = trim($video_urls[$i] ?? '');
        $title = trim($title);
        if ($title === '' || $url === '') {
            continue;
        }
        $insert_video->execute([$project_id, $title, $url, $order]);
        $order++;
    }

    $review_publications = $_POST['reviews_publication'] ?? [];
    $review_urls = $_POST['reviews_url'] ?? [];
    $insert_review = $connect->prepare("INSERT INTO project_reviews (project_id, publication, review_url, sort_order) VALUES (?, ?, ?, ?)");
    $order = 1;
    foreach ($review_publications as $i => $publication) {
        $url = trim($review_urls[$i] ?? '');
        $publication = trim($publication);
        if ($publication === '' || $url === '') {
            continue;
        }
        $insert_review->execute([$project_id, $publication, $url, $order]);
        $order++;
    }
}

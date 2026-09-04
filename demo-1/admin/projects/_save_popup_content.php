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
    $review_logos_current = $_POST['reviews_logo_current'] ?? [];
    $review_logo_files = $_FILES['reviews_logo'] ?? null;
    $logo_upload_dir = __DIR__ . '/../../assets/img/review/uploads/';
    $allowed_logo_extensions = ["jpg", "jpeg", "png", "gif", "webp", "svg"];

    $insert_review = $connect->prepare("INSERT INTO project_reviews (project_id, publication, review_url, logo, sort_order) VALUES (?, ?, ?, ?, ?)");
    $order = 1;
    foreach ($review_publications as $i => $publication) {
        $url = trim($review_urls[$i] ?? '');
        $publication = trim($publication);
        if ($publication === '' || $url === '') {
            continue;
        }

        $logo = trim($review_logos_current[$i] ?? '');
        if ($review_logo_files && ($review_logo_files['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $original_name = $review_logo_files['name'][$i];
            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
            if (in_array($extension, $allowed_logo_extensions) && $review_logo_files['size'][$i] <= 2000000) {
                if (!is_dir($logo_upload_dir)) {
                    mkdir($logo_upload_dir, 0755, true);
                }
                $new_name = 'review-' . uniqid() . '.' . $extension;
                if (move_uploaded_file($review_logo_files['tmp_name'][$i], $logo_upload_dir . $new_name)) {
                    $logo = $new_name;
                }
            }
        }

        $insert_review->execute([$project_id, $publication, $url, $logo !== '' ? $logo : null, $order]);
        $order++;
    }
}

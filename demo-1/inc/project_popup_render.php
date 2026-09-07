<?php
// Accepts whatever YouTube URL form an admin pastes (watch?v=, youtu.be/, or an
// already-canonical /embed/ link) and normalizes it to an embeddable URL.
function youtube_embed_url($url) {
    if (preg_match('~(?:youtu\.be/|youtube\.com/(?:embed/|watch\?v=|watch\?.*&v=))([A-Za-z0-9_-]{6,})~', $url, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
}

// Renders a single project's popup body (synopsis/videos/reviews). Shared by
// index.php's admin-preview needs and project_popup.php, which is fetched on
// demand when a project card is clicked.
function render_project_popup(array $project, array $videos, array $reviews, array $publications) {
    ob_start();
    ?>
    <h2><?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
    <?php if (trim((string)$project['synopsis']) !== ''): ?>
    <p><strong>Synopsis:</strong></p>
    <p><?php echo nl2br(htmlspecialchars($project['synopsis'], ENT_QUOTES, 'UTF-8')); ?></p>
    <?php endif; ?>
    <?php foreach ($videos as $video): ?>
    <p><strong><?php echo htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'); ?>:</strong></p>
    <div class="tt-project-popup-video">
        <iframe src="<?php echo youtube_embed_url($video['youtube_url']); ?>" title="<?php echo htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <?php endforeach; ?>
    <?php if (!empty($reviews)): ?>
    <p><strong>Reviews:</strong></p>
    <div class="tt-project-popup-reviews">
        <?php foreach ($reviews as $review): $logo = $publications[$review['publication']] ?? null; ?>
        <a href="<?php echo htmlspecialchars($review['review_url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">
            <?php if ($logo): ?>
            <img src="assets/img/review/<?php echo htmlspecialchars($logo, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($review['publication'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php else: ?>
            <span class="tt-project-popup-review-text"><?php echo htmlspecialchars($review['publication'], ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
}

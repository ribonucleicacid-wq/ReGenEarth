<?php
session_start();
include 'inc/header.php';
include '../auth/user_only.php';
require_once '../src/db_connection.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Get current user's profile picture for comments
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentUserProfilePic = $user['profile_picture'] ?? 'default.jpg';

    // Get all posts with their media, likes, and comments
    $query = "
        SELECT 
            p.*,
            u.username,
            u.profile_picture,
            (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.post_id) as likes_count,
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.post_id) as comments_count,
            EXISTS(SELECT 1 FROM likes l WHERE l.post_id = p.post_id AND l.user_id = ?) as is_liked
        FROM posts p
        INNER JOIN users u ON p.user_id = u.user_id
        ORDER BY p.created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get media for each post
    $mediaStmt = $conn->prepare("
        SELECT * FROM post_media 
        WHERE post_id = ?
        ORDER BY media_id ASC
    ");

    foreach ($posts as &$post) {
        $mediaStmt->execute([$post['post_id']]);
        $media = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);
        
        $post['images'] = [];
        $post['videos'] = [];
        
        foreach ($media as $item) {
            if ($item['media_type'] === 'image') {
                $post['images'][] = $item['media_url'];
            } else {
                $post['videos'][] = $item['media_url'];
            }
        }
    }
    unset($post);

} catch (PDOException $e) {
    $posts = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - ReGenEarth</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    .feed-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .post-card {
      background-color: var(--prussian-blue);
      border: 1px solid var(--taupe-gray);
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
      transition: 0.3s;
    }

    /*CSS for the author/inventor section*/
    .post-author {
      display: flex;
      align-items: flex-start;
      padding: 10px;
      border-bottom: 1px solid #f0f0f0;
      position: relative;
    }

    .author-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
      margin-top: 8px;
    }

    .author-info {
      flex: 1;
    }

    .author-name {
      font-weight: bold;
      font-size: 16px;
    }

    .post-time {
      position: absolute;
      right: 10px;
      top: 10px;
      font-size: 12px;
    }

    .post-topic {
      display: inline-block;
      background-color: var(--moonstone);
      color: white;
      font-size: 12px;
      padding: 3px 5px;
      border-radius: 12px;
      margin-top: 4px;
      width: fit-content;
    }

    .post-header {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .post-content {
      font-size: 16px;
      margin-bottom: 15px;
    }

    .post-images {
      margin-bottom: 15px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 8px;
    }

    .post-images.single-image {
      grid-template-columns: 1fr;
    }

    .post-images.single-image img {
      max-height: 500px;
    }

    /* Video CSS */
    .post-videos {
      margin-bottom: 15px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 8px;
    }

    .post-videos.single-video {
      grid-template-columns: 1fr;
    }

    .video-container {
      position: relative;
      width: 100%;
      height: 0;
      padding-bottom: 75%;
      overflow: hidden;
      border-radius: 8px;
      cursor: pointer;
    }

    .video-container video {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .video-container:hover video {
      transform: scale(1.03);
    }

    .video-play-icon {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 48px;
      opacity: 0.8;
      z-index: 2;
      transition: opacity 0.3s;
    }

    .video-container:hover .video-play-icon {
      opacity: 1;
    }

    .post-footer {
      display: flex;
      gap: 20px;
      padding: 12px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin-top: 15px;
    }

    .action-btn {
      background: none;
      border: none;
      color: var(--silver);
      font-size: 15px;
      padding: 8px 12px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .action-btn:hover:not(.disabled) {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .action-btn.liked {
      color: #ff4b4b;
    }

    .action-btn.liked i {
      animation: likeAnimation 0.3s ease;
    }

    .action-btn.disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .action-btn i {
      font-size: 18px;
    }

    .action-btn .count {
      font-size: 14px;
      opacity: 0.8;
    }

    .comment-box {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .comment-box .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
    }

    .comment-box textarea {
      flex: 1;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 20px;
      padding: 8px 16px;
      color: var(--silver);
      resize: none;
      height: 36px;
      font-size: 14px;
      transition: all 0.2s ease;
    }

    .comment-box textarea:focus {
      background: rgba(255, 255, 255, 0.15);
      outline: none;
    }

    .comment-box .send-btn {
      background: none;
      border: none;
      color: var(--moonstone);
      cursor: pointer;
      padding: 8px;
      font-size: 16px;
      opacity: 0.8;
      transition: all 0.2s ease;
    }

    .comment-box .send-btn:hover {
      opacity: 1;
      transform: scale(1.1);
    }

    @keyframes likeAnimation {
      0% { transform: scale(1); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }

    .comments-list {
      margin-top: 10px;
    }

    .comment-item {
      display: flex;
      gap: 12px;
      padding: 8px 0;
    }

    .comment-item .comment-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
    }

    .comment-content-wrapper {
      flex: 1;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      padding: 10px 15px;
    }

    .comment-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 4px;
    }

    .comment-user {
      font-weight: 500;
      color: var(--moonstone);
    }

    .comment-time {
      font-size: 12px;
      opacity: 0.7;
    }

    .comment-content {
      font-size: 14px;
      line-height: 1.4;
      word-break: break-word;
    }

    .image-container {
      position: relative;
      width: 100%;
      height: 0;
      padding-bottom: 75%;
      overflow: hidden;
      border-radius: 8px;
      cursor: pointer;
    }

    .image-container img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .image-container:hover img {
      transform: scale(1.03);
    }

    .more-images-overlay,
    .more-videos-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
    }

    /*CSS  for Reply Feature*/
    .reply-btn {
      background: none;
      border: none;
      color: var(--silver);
      font-size: 12px;
      cursor: pointer;
      padding: 0px;
    }

    .reply-btn:hover {
      color: var(--moonstone);
      text-decoration: underline;
    }

    /* Reply box styles */
    .reply-box {
      display: flex;
      margin-top: 5px;
      margin-bottom: 10px;
      align-items: center;
      padding-left: 10px;
    }

    .reply-box .user-avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      margin-right: 8px;
    }

    .reply-box textarea {
      flex: 1;
      border: 1px solid var(--light-gray);
      border-radius: 18px;
      padding: 8px 12px;
      font-size: 0.9rem;
      resize: none;
      min-height: 36px;
      background-color: var(--light-gray);
      color: white;
    }

    .reply-box .icon-btn {
      background: none;
      border: none;
      color: var(--moonstone);
      cursor: pointer;
      margin-left: 8px;
    }

    .replies-list {
      margin-left: 15px;
      margin-top: 5px;
    }

    .comment-reply {
      margin-top: 5px;
    }

    .comment-reply .comment-avatar {
      width: 28px;
      height: 28px;
    }

    /* In light mode */
    .light-mode .comment-content {
      background-color: var(--lighter-gray);
    }

    .light-mode .reply-box textarea {
      background-color: var(--lighter-gray);
      border-color: var(--lighter-gray);
    }

    /* Image Gallery Lightbox */
    .lightbox-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s, visibility 0.3s;
    }

    .lightbox-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .lightbox-container {
      position: relative;
      max-width: 90%;
      max-height: 90%;
      display: flex;
      flex-direction: column;
    }

    .lightbox-image {
      max-width: 100%;
      max-height: 80vh;
      object-fit: contain;
      border-radius: 4px;
    }

    .lightbox-video {
      max-width: 100%;
      max-height: 80vh;
      object-fit: contain;
      border-radius: 4px;
    }

    .lightbox-close {
      position: absolute;
      top: -30px;
      right: 0;
      color: white;
      font-size: 20px;
      background: none;
      border: none;
      cursor: pointer;
      z-index: 1001;
    }

    .lightbox-nav {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }

    .lightbox-nav button {
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      font-size: 10px;
      padding: 7px 10px;
      cursor: pointer;
      border-radius: 50%;
      transition: background-color 0.3s;
    }

    .lightbox-nav button:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }

    .lightbox-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 0;
      color: white;
    }

    .lightbox-counter {
      color: white;
      font-size: 14px;
    }

    .lightbox-actions {
      display: flex;
      gap: 20px;
    }

    .lightbox-actions button {
      background: none;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .lightbox-actions button:hover {
      color: var(--moonstone);
    }

    .media-tab {
      display: inline-block;
      padding: 8px 12px;
      margin-right: 10px;
      margin-bottom: 10px;
      background-color: var(--rich-black);
      color: var(--silver);
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .media-tab.active {
      background-color: var(--moonstone);
      color: white;
    }

    .media-content {
      display: none;
    }

    .media-content.active {
      display: block;
    }

    .image-container:hover {
      opacity: 1;
    }

    .media-section {
      margin-bottom: 20px;
    }

    .icon-btn.disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  </style>

</head>

<body>
<div class="feed-container">
    <?php if (empty($posts)): ?>
      <div class="no-posts">
        <p>No posts found. Be the first to share something!</p>
      </div>
    <?php else: ?>
      <?php foreach ($posts as $post): ?>
    <div class="post-card">
      <div class="post-author">
            <img src="uploads/<?= htmlspecialchars($post['profile_picture'] ?? 'default.jpg') ?>" 
                 alt="<?= htmlspecialchars($post['username']) ?>" 
          class="author-avatar">
        <div class="author-info">
              <div class="author-name"><?= htmlspecialchars($post['username']) ?></div>
          <div class="post-topic"><?= htmlspecialchars($post['topic']) ?></div>
              <div class="post-time" data-timestamp="<?= $post['created_at'] ?>"></div>
        </div>
      </div>

      <div class="post-header"><?= htmlspecialchars($post['title']) ?></div>
      <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>

          <?php
          $has_images = !empty($post['images']);
          $has_videos = !empty($post['videos']);
          $images = $post['images'] ?? [];
          $videos = $post['videos'] ?? [];
          ?>

      <?php if ($has_images || $has_videos): ?>
        <div class="media-section">
          <?php if ($has_images && $has_videos): ?>
            <div class="media-tabs">
                  <div class="media-tab active" data-tab="images-<?= $post['post_id'] ?>">Images</div>
                  <div class="media-tab" data-tab="videos-<?= $post['post_id'] ?>">Videos</div>
            </div>
          <?php endif; ?>

          <?php if ($has_images): ?>
                <div class="media-content active" id="images-<?= $post['post_id'] ?>">
                  <div class="post-images <?= count($images) === 1 ? 'single-image' : '' ?>">
                <?php
                    $total_images = count($images);
                $display_count = min(4, $total_images);
                $remaining = $total_images - $display_count;

                for ($i = 0; $i < $display_count; $i++):
                      $image = $images[$i];
                  ?>
                      <div class="image-container" onclick="openMediaLightbox('<?= $post['post_id'] ?>', <?= $i ?>, 'image')">
                    <img src="uploads/<?= htmlspecialchars($image) ?>" alt="Post image">
                    <?php if ($i === 3 && $remaining > 0): ?>
                      <div class="more-images-overlay">+<?= $remaining ?></div>
                    <?php endif; ?>
                  </div>
                <?php endfor; ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($has_videos): ?>
                <div class="media-content <?= !$has_images ? 'active' : '' ?>" id="videos-<?= $post['post_id'] ?>">
                  <div class="post-videos <?= count($videos) === 1 ? 'single-video' : '' ?>">
                <?php
                    $total_videos = count($videos);
                $display_count = min(4, $total_videos);
                $remaining = $total_videos - $display_count;

                for ($i = 0; $i < $display_count; $i++):
                      $video = $videos[$i];
                  ?>
                      <div class="video-container" onclick="openMediaLightbox('<?= $post['post_id'] ?>', <?= $i ?>, 'video')">
                    <video src="uploads/<?= htmlspecialchars($video) ?>" preload="metadata"></video>
                    <div class="video-play-icon">
                      <i class="fas fa-play-circle"></i>
                    </div>
                    <?php if ($i === 3 && $remaining > 0): ?>
                      <div class="more-videos-overlay">+<?= $remaining ?></div>
                    <?php endif; ?>
                  </div>
                <?php endfor; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="post-footer">
            <?php if ($post['user_id'] != $_SESSION['user_id']): ?>
              <button id="like-btn-<?= $post['post_id'] ?>" 
                      class="action-btn <?= $post['is_liked'] ? 'liked' : '' ?>" 
                      onclick="likePost('<?= $post['post_id'] ?>')">
                <i class="far fa-heart"></i>
                <span>Like</span>
                <?php if ($post['likes_count'] > 0): ?>
                  <span class="count"><?= $post['likes_count'] ?></span>
                <?php endif; ?>
        </button>
              <button class="action-btn" onclick="focusCommentBox('<?= $post['post_id'] ?>')">
                <i class="far fa-comment"></i>
                <span>Comment</span>
                <?php if ($post['comments_count'] > 0): ?>
                  <span class="count"><?= $post['comments_count'] ?></span>
                <?php endif; ?>
        </button>
            <?php else: ?>
              <button class="action-btn disabled" disabled>
                <i class="far fa-heart"></i>
                <span>Like</span>
                <?php if ($post['likes_count'] > 0): ?>
                  <span class="count"><?= $post['likes_count'] ?></span>
                <?php endif; ?>
              </button>
              <button class="action-btn disabled" disabled>
                <i class="far fa-comment"></i>
                <span>Comment</span>
                <?php if ($post['comments_count'] > 0): ?>
                  <span class="count"><?= $post['comments_count'] ?></span>
                <?php endif; ?>
              </button>
            <?php endif; ?>
      </div>

          <?php if ($post['user_id'] != $_SESSION['user_id']): ?>
      <div class="comment-box">
            <img src="uploads/<?= htmlspecialchars($currentUserProfilePic) ?>" alt="Your Profile" class="user-avatar">
            <textarea id="comment-textarea-<?= $post['post_id'] ?>" placeholder="Write a comment..."></textarea>
            <button class="send-btn" onclick="addComment('<?= $post['post_id'] ?>')">
              <i class="fas fa-paper-plane"></i>
            </button>
      </div>
          <?php endif; ?>

          <div class="comments-list" id="comments-list-<?= $post['post_id'] ?>">
            <!-- Comments will be loaded dynamically -->
      </div>
    </div>
  <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Media Lightbox Gallery -->
<div class="lightbox-overlay" id="lightbox-overlay">
  <div class="lightbox-container">
    <button class="lightbox-close" onclick="closeLightbox()">
      <i class="fas fa-times"></i>
    </button>

    <img src="" alt="Full size image" id="lightbox-image" class="lightbox-image" style="display: none;">
    <video id="lightbox-video" class="lightbox-video" controls style="display: none;"></video>

    <div class="lightbox-nav">
      <button onclick="navigateMedia(-1)">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button onclick="navigateMedia(1)">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <div class="lightbox-footer">
      <span class="lightbox-counter" id="lightbox-counter">1 of 5</span>
    </div>
  </div>
</div>

<script>
    // Add this at the top of your JavaScript
    const currentUserProfilePic = '<?= htmlspecialchars($currentUserProfilePic) ?>';
    
  // Store post creation times
  const postCreationTimes = {};

  <?php foreach ($posts as $post): ?>
      postCreationTimes['<?= md5($post['title'] . $post['created_at']) ?>'] = '<?= $post['created_at'] ?>';
  <?php endforeach; ?>

  // Format time function
    function formatTime(date) {
    const now = new Date();
    const diff = now - date;

      if (diff < 60000) return 'Just now';
      if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`;
      if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`;
      if (diff < 604800000) return `${Math.floor(diff / 86400000)}d ago`;

      return date.toLocaleDateString('default', { month: 'short', day: 'numeric' });
  }

  // Update all timestamps
  function updateAllTimes() {
    document.querySelectorAll('[data-timestamp]').forEach(timeElement => {
      const timestamp = timeElement.getAttribute('data-timestamp');
        timeElement.textContent = formatTime(new Date(timestamp));
    });
  }

  // Initialize times and update every minute
  updateAllTimes();
  setInterval(updateAllTimes, 60000);

    // Load comments for a post
    function loadComments(postId) {
      fetch(`ajax/get_comments.php?post_id=${postId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const commentsList = document.getElementById(`comments-list-${postId}`);
            commentsList.innerHTML = '';
            data.comments.forEach(comment => {
              const commentElement = createCommentElement(comment);
              commentsList.appendChild(commentElement);
            });
          }
        });
    }

    // Load comments for all posts on page load
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.post-card').forEach(post => {
        const postId = post.querySelector('[id^="like-btn-"]').id.split('-')[2];
        loadComments(postId);
      });
    });

    // Post like functionality
    function likePost(postId) {
      fetch('ajax/like_post.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `post_id=${postId}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
    const likeButton = document.getElementById(`like-btn-${postId}`);
          const likeIcon = likeButton.querySelector('i');
          const countSpan = likeButton.querySelector('.count');

          if (data.liked) {
            likeIcon.className = "fas fa-heart";
            likeButton.classList.add('liked');
    } else {
            likeIcon.className = "far fa-heart";
            likeButton.classList.remove('liked');
          }

          if (data.likes_count > 0) {
            if (!countSpan) {
              const newCount = document.createElement('span');
              newCount.className = 'count';
              newCount.textContent = data.likes_count;
              likeButton.appendChild(newCount);
            } else {
              countSpan.textContent = data.likes_count;
            }
          } else if (countSpan) {
            countSpan.remove();
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Failed to like post',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to process like action',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      });
    }

    // Add comment functionality
    function addComment(postId) {
      const textarea = document.getElementById(`comment-textarea-${postId}`);
      const content = textarea.value.trim();

      if (!content) {
        Swal.fire({
          icon: 'warning',
          title: 'Warning',
          text: 'Please write a comment first',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        return;
      }

      fetch('ajax/add_comment.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `post_id=${postId}&content=${encodeURIComponent(content)}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Add the new comment to the list
          const commentsList = document.getElementById(`comments-list-${postId}`);
          const commentElement = document.createElement('div');
          commentElement.className = 'comment-item';
          commentElement.innerHTML = `
            <img src="uploads/${data.comment.profile_picture}" alt="${data.comment.username}" class="comment-avatar">
            <div class="comment-content-wrapper">
              <div class="comment-header">
                <span class="comment-user">${data.comment.username}</span>
                <span class="comment-time" data-timestamp="${data.comment.created_at}">${formatTime(new Date(data.comment.created_at))}</span>
              </div>
              <div class="comment-content">${data.comment.content}</div>
            </div>
          `;
          
          commentsList.insertBefore(commentElement, commentsList.firstChild);
          textarea.value = '';

          // Update comment count
          const commentButton = document.querySelector(`button[onclick="focusCommentBox('${postId}')"]`);
          const countSpan = commentButton.querySelector('.count');
          const currentCount = countSpan ? parseInt(countSpan.textContent) : 0;
          const newCount = currentCount + 1;

          if (newCount > 0) {
            if (!countSpan) {
              const newCountSpan = document.createElement('span');
              newCountSpan.className = 'count';
              newCountSpan.textContent = newCount;
              commentButton.appendChild(newCountSpan);
            } else {
              countSpan.textContent = newCount;
            }
          }

          // Show success message
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Comment added successfully',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Failed to add comment',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to add comment',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      });
    }

    function createCommentElement(comment) {
      const div = document.createElement('div');
      div.className = 'comment-item';
      div.innerHTML = `
        <img src="uploads/${comment.profile_picture}" alt="${comment.username}" class="comment-avatar">
        <div class="comment-content-wrapper">
          <div class="comment-header">
            <span class="comment-user">${comment.username}</span>
            <span class="comment-time" data-timestamp="${comment.created_at}">${formatTime(new Date(comment.created_at))}</span>
          </div>
          <div class="comment-content">${comment.content}</div>
          <div class="comment-actions">
            <button class="reply-btn" onclick="showReplyBox('${comment.comment_id}')">Reply</button>
          </div>
          <div id="reply-box-container-${comment.comment_id}" class="reply-box-container" style="display: none;">
            <div class="reply-box">
              <img src="uploads/${currentUserProfilePic}" alt="Your Profile" class="user-avatar">
              <textarea id="reply-textarea-${comment.comment_id}" placeholder="Write a reply..."></textarea>
              <button class="icon-btn" onclick="addReply('${comment.comment_id}', '${postId}')">
                <i class="fas fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </div>
      `;
      return div;
  }

  function showReplyBox(commentId) {
      const replyBox = document.getElementById(`reply-box-container-${commentId}`);
      if (replyBox.style.display === 'none') {
    document.querySelectorAll('.reply-box-container').forEach(box => {
      box.style.display = 'none';
    });
    replyBox.style.display = 'block';
    document.getElementById(`reply-textarea-${commentId}`).focus();
      } else {
        replyBox.style.display = 'none';
      }
  }

  function focusCommentBox(postId) {
      const textarea = document.getElementById(`comment-textarea-${postId}`);
      if (textarea) {
        textarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
        textarea.focus();
      }
    }

    // Auto-resize textarea
    document.addEventListener('input', function(e) {
      if (e.target.matches('.comment-box textarea')) {
        e.target.style.height = 'auto';
        e.target.style.height = (e.target.scrollHeight) + 'px';
      }
    });

    // Initialize all textareas
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.comment-box textarea').forEach(textarea => {
        textarea.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const postId = this.id.split('-')[2];
            addComment(postId);
          }
        });
      });
    });

  const postImagesData = {};
  const postVideosData = {};

  <?php foreach ($posts as $post): ?>
    <?php if (!empty($post['images'])): ?>
        postImagesData['<?= md5($post['title'] . $post['created_at']) ?>'] = [
        <?php foreach ($post['images'] as $image): ?>
                                        'uploads/<?= htmlspecialchars($image) ?>',
        <?php endforeach; ?>
      ];
    <?php endif; ?>

    <?php if (!empty($post['videos'])): ?>
        postVideosData['<?= md5($post['title'] . $post['created_at']) ?>'] = [
        <?php foreach ($post['videos'] as $video): ?>
                                        'uploads/<?= htmlspecialchars($video) ?>',
        <?php endforeach; ?>
      ];
    <?php endif; ?>
  <?php endforeach; ?>

  // Tabs switching functionality
  document.addEventListener('click', function (event) {
    if (event.target.classList.contains('media-tab')) {
      const tabId = event.target.dataset.tab;
      const tabGroup = event.target.closest('.media-tabs');

      const allTabs = tabGroup.querySelectorAll('.media-tab');
      allTabs.forEach(tab => tab.classList.remove('active'));

      const postId = tabId.split('-')[1];
      const allContents = document.querySelectorAll(`#images-${postId}, #videos-${postId}`);
      allContents.forEach(content => content.classList.remove('active'));

      // Activate clicked tab and its content
      event.target.classList.add('active');
      document.getElementById(tabId).classList.add('active');
    }
  });

  // Lightbox Gallery with support for images and videos
  let currentPostId = null;
  let currentMediaIndex = 0;
  let currentMediaType = 'image'; // 'image' or 'video'
  let currentMedia = [];

  function openMediaLightbox(postId, mediaIndex, mediaType) {
    currentPostId = postId;
    currentMediaIndex = mediaIndex;
    currentMediaType = mediaType;

    if (mediaType === 'image') {
      currentMedia = postImagesData[postId] || [];
    } else {
      currentMedia = postVideosData[postId] || [];
    }

    // Display the current media
    updateLightboxMedia();

    // Show lightbox
    document.getElementById('lightbox-overlay').classList.add('active');

    // Prevent page scrolling when lightbox is open
    document.body.style.overflow = 'hidden';
  }

  function updateLightboxMedia() {
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxVideo = document.getElementById('lightbox-video');

    // Update counter
    document.getElementById('lightbox-counter').textContent = `${currentMediaIndex + 1} of ${currentMedia.length}`;

    lightboxImage.style.display = 'none';
    lightboxVideo.style.display = 'none';

    if (currentMediaType === 'image') {
      lightboxImage.src = currentMedia[currentMediaIndex];
      lightboxImage.style.display = 'block';
    } else {
      lightboxVideo.src = currentMedia[currentMediaIndex];
      lightboxVideo.style.display = 'block';
      lightboxVideo.currentTime = 0; // Reset video to beginning
      lightboxVideo.play();
    }
  }

  function closeLightbox() {
    document.getElementById('lightbox-overlay').classList.remove('active');
    document.body.style.overflow = '';

    // Pause video if active
    const lightboxVideo = document.getElementById('lightbox-video');
    if (lightboxVideo.style.display !== 'none') {
      lightboxVideo.pause();
    }
  }

  function navigateMedia(direction) {
    currentMediaIndex += direction;

    // Handle wrapping around
    if (currentMediaIndex < 0) {
      currentMediaIndex = currentMedia.length - 1;
    } else if (currentMediaIndex >= currentMedia.length) {
      currentMediaIndex = 0;
    }

    // Update displayed media
    updateLightboxMedia();
  }

  // Close lightbox when clicking outside of media
  document.getElementById('lightbox-overlay').addEventListener('click', function (event) {
    if (event.target === this) {
      closeLightbox();
    }
  });

  // Keyboard navigation for lightbox
  document.addEventListener('keydown', function (event) {
    if (!document.getElementById('lightbox-overlay').classList.contains('active')) return;

    switch (event.key) {
      case 'Escape':
        closeLightbox();
        break;
      case 'ArrowLeft':
        navigateMedia(-1);
        break;
      case 'ArrowRight':
        navigateMedia(1);
        break;
    }
  });

  // Dark/Light mode detection
    document.addEventListener("DOMContentLoaded", function() {
    const body = document.body;
    if (localStorage.getItem('mode') === 'light') {
      body.classList.add('light-mode');
    }
  });
</script>
</body>
</html>
<?php
session_start();

include 'inc/header.php';
include '../auth/user_only.php';

date_default_timezone_set('Asia/Manila');
// Handle post submission
$new_post = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['topic'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $topic = $_POST['topic'];

  // Process uploaded images
  $uploaded_images = [];

  if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
    $upload_dir = 'uploads/';

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
      $file_name = $_FILES['images']['name'][$key];
      $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
      $new_file_name = uniqid() . '.' . $file_ext;

      if (move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
        $uploaded_images[] = $new_file_name;
      }
    }
  }

  // Process uploaded videos
  $uploaded_videos = [];

  if (isset($_FILES['videos']) && !empty($_FILES['videos']['name'][0])) {
    $upload_dir = 'uploads/';

    foreach ($_FILES['videos']['tmp_name'] as $key => $tmp_name) {
      $file_name = $_FILES['videos']['name'][$key];
      $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
      $new_file_name = uniqid() . '_video.' . $file_ext;

      if (move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
        $uploaded_videos[] = $new_file_name;
      }
    }
  }

  // Create new post with current time
  $new_post = [
    'author' => 'Juan Dela Cruz', // sample user
    'author_image' => 'profile.jpg', // sample profile image
    'post_time' => date('c'),
    'title' => $title,
    'content' => $content,
    'images' => $uploaded_images,
    'videos' => $uploaded_videos,
    'topic' => $topic,
    'likes' => 0
  ];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

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
      align-items: center;
      gap: 20px;
    }

    .icon-btn {
      border: none;
      cursor: pointer;
      color: var(--silver);
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.3s;
      background-color: transparent;
      outline: none;
    }

    .icon-btn:hover {
      color: var(--moonstone);
    }

    .icon-btn:focus {
      outline: none;
    }

    .icon-btn:active {
      outline: none;
      border: none;
    }

    .comment-box {
      margin-top: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /*CSS for commentor section*/
    .user-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      object-fit: cover;
      border: 1px solid var(--taupe-gray);
    }

    .comment-box textarea {
      flex: 1;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid var(--taupe-gray);
      background-color: var(--rich-black);
      color: var(--silver);
      resize: none;
      height: 50px;
    }

    .comment-box .icon-btn {
      background-color: var(--moonstone);
      border: none;
      color: white;
      height: 50px;
      font-size: 16px;
      padding: 10px 14px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .comments-list {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .comment-item {
      background-color: var(--rich-black);
      padding: 12px;
      border-radius: 8px;
      color: var(--silver);
      display: flex;
      gap: 10px;
    }

    .comment-avatar {
      width: 26px;
      height: 26px;
      border-radius: 50%;
      object-fit: cover;
      flex-shrink: 0;
      border: 1px solid var(--taupe-gray);
    }

    .comment-content-wrapper {
      flex: 1;
    }

    .comment-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
    }

    .comment-user {
      font-weight: 600;
      color: var(--moonstone);
    }

    .comment-time {
      font-size: 12px;
      color: var(--taupe-gray);
    }

    .comment-content {
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
  </style>

</head>

<div class="feed-container">
  <?php
  // Initialize empty posts array to store database results
  $posts = [];

  // Add the new post to the beginning of the array if it exists
  if ($new_post) {
    array_unshift($posts, $new_post);
  }

  foreach ($posts as $post):
    $post_id = md5($post['title'] . $post['post_time']);
    $has_images = !empty($post['images']);
    $has_videos = !empty($post['videos']);
    ?>
    <div class="post-card">
      <!--Author section at the top of the post -->
      <div class="post-author">
        <img src="uploads/<?= htmlspecialchars($post['author_image']) ?>" alt="<?= htmlspecialchars($post['author']) ?>"
          class="author-avatar">
        <div class="author-info">
          <div class="author-name"><?= htmlspecialchars($post['author']) ?></div>
          <div class="post-topic"><?= htmlspecialchars($post['topic']) ?></div>
          <div class="post-time" data-timestamp="<?= $post['post_time'] ?>"></div>
        </div>
      </div>
      <!--Content of the post -->
      <div class="post-header"><?= htmlspecialchars($post['title']) ?></div>
      <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>

      <?php if ($has_images || $has_videos): ?>
        <div class="media-section">
          <?php if ($has_images && $has_videos): ?>
            <div class="media-tabs">
              <div class="media-tab active" data-tab="images-<?= $post_id ?>">Images</div>
              <div class="media-tab" data-tab="videos-<?= $post_id ?>">Videos</div>
            </div>
          <?php endif; ?>

          <?php if ($has_images): ?>
            <div class="media-content active" id="images-<?= $post_id ?>">
              <div class="post-images <?= count($post['images']) === 1 ? 'single-image' : '' ?>">
                <?php
                $total_images = count($post['images']);
                $display_count = min(4, $total_images);
                $remaining = $total_images - $display_count;

                for ($i = 0; $i < $display_count; $i++):
                  $image = $post['images'][$i];
                  $image_id = md5($post_id . $i);
                  ?>
                  <div class="image-container" onclick="openMediaLightbox('<?= $post_id ?>', <?= $i ?>, 'image')">
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
            <div class="media-content <?= !$has_images ? 'active' : '' ?>" id="videos-<?= $post_id ?>">
              <div class="post-videos <?= count($post['videos']) === 1 ? 'single-video' : '' ?>">
                <?php
                $total_videos = count($post['videos']);
                $display_count = min(4, $total_videos);
                $remaining = $total_videos - $display_count;

                for ($i = 0; $i < $display_count; $i++):
                  $video = $post['videos'][$i];
                  $video_id = md5($post_id . $i . 'video');
                  ?>
                  <div class="video-container" onclick="openMediaLightbox('<?= $post_id ?>', <?= $i ?>, 'video')">
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
        <button id="like-btn-<?= $post_id ?>" class="icon-btn" onclick="likePost('<?= $post_id ?>')">
          <i id="like-icon-<?= $post_id ?>" class="fa-regular fa-heart"></i>
          Like <span id="like-count-<?= $post_id ?>"><?= $post['likes'] > 0 ? $post['likes'] : '' ?></span>
        </button>
        <button class="icon-btn" onclick="focusCommentBox('<?= $post_id ?>')">
          <i class="fa-regular fa-comment"></i>Comment
        </button>
      </div>
      <!--Comment section of the post -->
      <div class="comment-box">
        <img src="uploads/profile.jpg" alt="Your Profile" class="user-avatar">
        <textarea id="comment-textarea-<?= $post_id ?>" placeholder="Write a comment..."></textarea>
        <button class="icon-btn" onclick="addComment('<?= $post_id ?>')"><i class="fas fa-paper-plane"></i></button>
      </div>

      <div class="comments-list" id="comments-list-<?= $post_id ?>">
        <!-- Comments will be added here dynamically -->
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Media Lightbox Gallery -->
<div class="lightbox-overlay" id="lightbox-overlay">
  <div class="lightbox-container">
    <button class="lightbox-close" onclick="closeLightbox()">
      <i class="fas fa-times"></i>
    </button>

    <!-- For images -->
    <img src="" alt="Full size image" id="lightbox-image" class="lightbox-image" style="display: none;">

    <!-- For videos -->
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
  // Store post creation times
  const postCreationTimes = {};

  <?php foreach ($posts as $post): ?>
    postCreationTimes['<?= md5($post['title'] . $post['post_time']) ?>'] = '<?= $post['post_time'] ?>';
  <?php endforeach; ?>

  // Format time function
  function formatTime(dateInput) {
    let date;

    // Handle both Date objects and ISO strings
    if (typeof dateInput === 'string') {
      date = new Date(dateInput);
    } else {
      date = dateInput;
    }

    // Get current time
    const now = new Date();

    // Ensure valid date
    if (isNaN(date.getTime())) {
      return 'Invalid date';
    }

    const diff = now - date;

    // Less than a minute
    if (diff < 60000) {
      return 'Just now';
    }

    // Less than an hour
    if (diff < 3600000) {
      const minutes = Math.floor(diff / 60000);
      return `${minutes}m ago`;
    }

    // Less than a day
    if (diff < 86400000) {
      const hours = Math.floor(diff / 3600000);
      return `${hours}h ago`;
    }

    // Less than a week
    if (diff < 604800000) {
      const days = Math.floor(diff / 86400000);
      return `${days}d ago`;
    }

    // Format date
    const day = date.getDate();
    const month = date.toLocaleString('default', {
      month: 'short'
    });
    return `${month} ${day}`;
  }

  // Update all timestamps
  function updateAllTimes() {
    document.querySelectorAll('[data-timestamp]').forEach(timeElement => {
      const timestamp = timeElement.getAttribute('data-timestamp');
      timeElement.textContent = formatTime(timestamp);
    });
  }

  // Initialize times and update every minute
  updateAllTimes();
  setInterval(updateAllTimes, 60000);

  // Post like functionality
  const postLikes = {};

  function likePost(postId) {
    if (!postLikes[postId]) {
      postLikes[postId] = {
        count: 0,
        liked: false
      };
    }

    const likeData = postLikes[postId];
    const likeButton = document.getElementById(`like-btn-${postId}`);
    const likeIcon = document.getElementById(`like-icon-${postId}`);
    const likeCount = document.getElementById(`like-count-${postId}`);

    // Toggle like state
    if (likeData.liked) {
      // Unlike
      likeData.count--;
      likeData.liked = false;
      likeIcon.className = "fa-regular fa-heart";
      likeButton.style.color = "var(--silver)";
    } else {
      // Like
      likeData.count++;
      likeData.liked = true;
      likeIcon.className = "fa-solid fa-heart";
      likeButton.style.color = "var(--moonstone)";
    }

    // Update like count display
    likeCount.textContent = likeData.count > 0 ? likeData.count : '';
  }

  // Comment functionality
  function addComment(postId) {
    const commentText = document.getElementById(`comment-textarea-${postId}`).value;

    if (commentText.trim()) {
      const commentsList = document.getElementById(`comments-list-${postId}`);

      // Sample user data
      const currentUser = "Juan Dela Cruz";
      const commentDate = new Date();
      const profilePic = "uploads/profile.jpg";

      const newComment = document.createElement('div');
      newComment.classList.add('comment-item');

      // Store ISO timestamp for accurate time display
      const commentTimestamp = commentDate.toISOString();

      newComment.innerHTML = `
          <img src="${profilePic}" alt="${currentUser}" class="comment-avatar">
          <div class="comment-content-wrapper">
            <div class="comment-header">
              <span class="comment-user">${currentUser}</span>
              <span class="comment-time" data-timestamp="${commentTimestamp}">${formatTime(commentDate)}</span>
            </div>
            <div class="comment-content">${commentText}</div>
          </div>
        `;

      commentsList.appendChild(newComment);
      document.getElementById(`comment-textarea-${postId}`).value = '';
      updateAllTimes();
    }
  }

  function focusCommentBox(postId) {
    document.getElementById(`comment-textarea-${postId}`).focus();
  }

  const postImagesData = {};
  const postVideosData = {};

  <?php foreach ($posts as $post): ?>
    <?php if (!empty($post['images'])): ?>
      postImagesData['<?= md5($post['title'] . $post['post_time']) ?>'] = [
        <?php foreach ($post['images'] as $image): ?>
          'uploads/<?= htmlspecialchars($image) ?>',
        <?php endforeach; ?>
      ];
    <?php endif; ?>

    <?php if (!empty($post['videos'])): ?>
      postVideosData['<?= md5($post['title'] . $post['post_time']) ?>'] = [
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

      // Remove active class from all tabs and content in this group
      const allTabs = tabGroup.querySelectorAll('.media-tab');
      allTabs.forEach(tab => tab.classList.remove('active'));

      // Get all related content divs
      const postId = tabId.split('-')[1]; // Extract post ID from tab ID
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

    // Choose the appropriate media array based on type
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
  document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;
    if (localStorage.getItem('mode') === 'light') {
      body.classList.add('light-mode');
    }
  });
</script>
</body>

</html>
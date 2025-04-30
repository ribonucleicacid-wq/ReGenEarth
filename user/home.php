<?php

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

  // Create new post with current time
  $new_post = [
    'author' => 'Juan Dela Cruz', // sample user
    'author_image' => 'profile.jpg', // sample profile image
    'post_time' => date('c'),
    'title' => $title,
    'content' => $content,
    'images' => $uploaded_images,
    'topic' => $topic,
    'likes' => 0
  ];
}

include 'inc/header.php';
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

    /*CSS for the content section*/
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
      margin-top: 10px;
    }

    .post-content {
      font-size: 16px;
      margin-bottom: 15px;
    }

    .post-images {
      margin-bottom: 15px;
    }

    .post-images img {
      width: 100%;
      height: auto;
      max-height: 400px;
      object-fit: cover;
      border-radius: 8px;
      display: block;
      margin-bottom: 10px;
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

    .image-container {
      position: relative;
      width: 100%;
      height: 0;
      padding-bottom: 75%;
      overflow: hidden;
      border-radius: 8px;
    }

    .image-container img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .more-images-overlay {
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

  foreach ($posts as $post) :
  ?>
    <div class="post-card">
      <!--Author section at the top of the post -->
      <div class="post-author">
        <img src="uploads/<?= htmlspecialchars($post['author_image']) ?>" alt="<?= htmlspecialchars($post['author']) ?>" class="author-avatar">
        <div class="author-info">
          <div class="author-name"><?= htmlspecialchars($post['author']) ?></div>
          <div class="post-topic"><?= htmlspecialchars($post['topic']) ?></div>
          <!-- Changed post time to use data-timestamp and formatTime -->
          <div class="post-time" data-timestamp="<?= $post['post_time'] ?>"></div>
        </div>
      </div>
      <!--Content of the post -->
      <div class="post-header"><?= htmlspecialchars($post['title']) ?></div>
      <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>
      <div class="post-images <?= count($post['images']) === 1 ? 'single-image' : '' ?>">
        <?php
        $total_images = count($post['images']);
        $display_count = min(4, $total_images);
        $remaining = $total_images - $display_count;

        for ($i = 0; $i < $display_count; $i++) :
          $image = $post['images'][$i];
        ?>
          <div class="image-container">
            <img src="uploads/<?= htmlspecialchars($image) ?>" alt="Post image">
            <?php if ($i === 3 && $remaining > 0) : ?>
              <div class="more-images-overlay">+<?= $remaining ?></div>
            <?php endif; ?>
          </div>
        <?php endfor; ?>
      </div>
      <div class="post-footer">
        <button id="like-btn-<?= md5($post['title'] . $post['post_time']) ?>" class="icon-btn" onclick="likePost('<?= md5($post['title'] . $post['post_time']) ?>')">
          <i id="like-icon-<?= md5($post['title'] . $post['post_time']) ?>" class="fa-regular fa-heart"></i>
          Like <span id="like-count-<?= md5($post['title'] . $post['post_time']) ?>"><?= $post['likes'] > 0 ? $post['likes'] : '' ?></span>
        </button>
        <button class="icon-btn"><i class="fa-regular fa-comment"></i>Comment</button>
      </div>
      <!--Comment section of the post -->
      <div class="comment-box">
        <img src="uploads/profile.jpg" alt="Your Profile" class="user-avatar">
        <textarea id="comment-textarea-<?= md5($post['title'] . $post['post_time']) ?>" placeholder="Write a comment..."></textarea>
        <button class="icon-btn" onclick="addComment('<?= md5($post['title'] . $post['post_time']) ?>')"><i class="fas fa-paper-plane"></i></button>
      </div>

      <div class="comments-list" id="comments-list-<?= md5($post['title'] . $post['post_time']) ?>">
        <!-- Comments will be added here dynamically -->
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
  const postCreationTimes = {};
  
  <?php foreach ($posts as $post): ?>
  postCreationTimes['<?= md5($post['title'] . $post['post_time']) ?>'] = '<?= $post['post_time'] ?>';
  <?php endforeach; ?>

  // Function to format time
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


  function updateAllTimes() {
    // Update both comment times and post times
    document.querySelectorAll('[data-timestamp]').forEach(timeElement => {
      const timestamp = timeElement.getAttribute('data-timestamp');
      timeElement.textContent = formatTime(timestamp);
    });
  }

  updateAllTimes();

  // Update every minute to keep times current
  setInterval(updateAllTimes, 60000);

  //function for like functionality
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
    }
  }
  
</script>
<?php include 'inc/header.php'; ?>
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
  </style>

</head>

<div class="feed-container">
    <?php
    // Sample post data
    $posts = [
      [
        'title' => 'Saving the Earth',
        'content' => 'Let\'s reduce our carbon footprint!',
        'images' => ['deforestation.jpg'],
        'topic' => 'Climate Change'
      ],
      [
        'title' => 'Pollution Problem',
        'content' => 'Plastic is everywhere...',
        'images' => ['pollution.jpg'],
        'topic' => 'Pollution'
      ]
    ];

    foreach ($posts as $post) :
    ?>
      <div class="post-card">
        <div class="post-header"><?= htmlspecialchars($post['title']) ?></div>
        <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>
        <div class="post-images">
          <?php foreach ($post['images'] as $image) : ?>
            <img src="uploads/<?= htmlspecialchars($image) ?>">
          <?php endforeach; ?>
        </div>
        <div class="post-footer">
          <button class="icon-btn"><i class="fa-regular fa-heart"></i> Like</button>
          <button class="icon-btn"><i class="fa-regular fa-comment"></i>Comment</button>
        </div>

        <div class="comment-box">
          <img src="uploads/profile.jpg" alt="Your Profile" class="user-avatar">
          <textarea id="comment-textarea-<?= $post['title'] ?>" placeholder="Write a comment..."></textarea>
          <button class="icon-btn" onclick="addComment('<?= $post['title'] ?>')"><i class="fas fa-paper-plane"></i></button>
        </div>

        <div class="comments-list" id="comments-list-<?= $post['title'] ?>">
          
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <script>
    function formatTime(date) {
      // Get current time
      const now = new Date();
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
      
      // Format date
      const day = date.getDate();
      const month = date.toLocaleString('default', { month: 'short' });
      return `${month} ${day}`;
    }

    function addComment(postTitle) {
      const commentText = document.getElementById(`comment-textarea-${postTitle}`).value;

      if (commentText.trim()) {
        const commentsList = document.getElementById(`comments-list-${postTitle}`);
        
        // Sample user data
        const currentUser = "Sam Miller"; 
        const commentDate = new Date();
        const profilePic = "uploads/profile.jpg"; 
        
        const newComment = document.createElement('div');
        newComment.classList.add('comment-item');
        
        newComment.innerHTML = `
          <img src="${profilePic}" alt="${currentUser}" class="comment-avatar">
          <div class="comment-content-wrapper">
            <div class="comment-header">
              <span class="comment-user">${currentUser}</span>
              <span class="comment-time">${formatTime(commentDate)}</span>
            </div>
            <div class="comment-content">${commentText}</div>
          </div>
        `;

        commentsList.appendChild(newComment);

        document.getElementById(`comment-textarea-${postTitle}`).value = '';
      }
    }
  </script>

</body>

</html>
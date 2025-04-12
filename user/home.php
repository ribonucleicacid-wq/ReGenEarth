<?php
session_start();

include 'inc/header.php';
include '../auth/user_only.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    .feed-container {
      max-width: 800px;
      margin: 20px auto;
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
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 15px;
    }

    .post-images img {
      max-width: 150px;
      border-radius: 10px;
      object-fit: cover;
      border: 1px solid var(--taupe-gray);
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
    }

    .icon-btn:hover {
      color: var(--moonstone);
    }

    .comment-box {
      margin-top: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
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
      background-color: var(--prussian-blue);
      padding: 10px;
      border-radius: 8px;
      color: var(--silver);
    }
  </style>

</head>

<body>

  <div class="feed-container">
    <?php
    // Eme lang na post data
    $posts = [
      [
        'title' => 'Saving the Earth',
        'content' => 'Let\'s reduce our carbon footprint!',
        'images' => ['https://unsplash.com/photos/black-printing-machine-printing-on-black-and-green-pad-L_N7BaNLC5Y', 'assets/images/cover.png'],
        'topic' => 'Climate Change'
      ],
      [
        'title' => 'Pollution Problem',
        'content' => 'Plastic is everywhere...',
        'images' => ['https://unsplash.com/photos/black-printing-machine-printing-on-black-and-green-pad-L_N7BaNLC5Y'],
        'topic' => 'Pollution'
      ]
    ];

    foreach ($posts as $post):
      ?>
      <div class="post-card">
        <div class="post-header"><?= htmlspecialchars($post['title']) ?></div>
        <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>
        <div class="post-images">
          <?php foreach ($post['images'] as $image): ?>
            <img src="uploads/<?= htmlspecialchars($image) ?>" alt="Post image">
          <?php endforeach; ?>
        </div>
        <div class="post-footer">
          <button class="icon-btn"><i class="fa-regular fa-heart"></i> Like</button>
          <button class="icon-btn"><i class="fa-regular fa-comment"></i>Comment</button>
        </div>

        <div class="comment-box">
          <textarea id="comment-textarea-<?= $post['title'] ?>" placeholder="Write a comment..."></textarea>
          <button class="icon-btn" onclick="addComment('<?= $post['title'] ?>')"><i class="fas fa-paper-plane"></i>
            Send</button>
        </div>

        <div class="comments-list" id="comments-list-<?= $post['title'] ?>">

        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <script>
    function addComment(postTitle) {
      const commentText = document.getElementById(`comment-textarea-${postTitle}`).value;

      if (commentText.trim()) {
        const commentsList = document.getElementById(`comments-list-${postTitle}`);

        const newComment = document.createElement('div');
        newComment.classList.add('comment-item');
        newComment.innerText = commentText;

        commentsList.appendChild(newComment);

        document.getElementById(`comment-textarea-${postTitle}`).value = '';
      }
    }
  </script>

</body>

</html>
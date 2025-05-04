<?php include 'inc/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    :root {
      --moonstone: #57AFC3;
      --prussian-blue: #132F43;
      --silver: #CACFD3;
      --taupe-gray: #999A9C;
      --rich-black: #0B1A26;
    }

    .light-mode {
      --moonstone: #489fb5;
      --prussian-blue: #e9ecef;
      --silver: #212529;
      --taupe-gray: #6c757d;
      --rich-black: #ffffff;
    }

    body {
      background-color: var(--rich-black);
      color: var(--silver);
      transition: background-color 0.3s, color 0.3s;
    }

    .create-post-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      border: 1px solid var(--taupe-gray);
      border-radius: 12px;
      background-color: var(--prussian-blue);
      font-family: "Poppins", sans-serif;
      transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    .create-post-container h2 {
      font-size: 25px;
      text-align: center;
      margin-bottom: 20px;
      color: var(--silver);
    }

    .create-post-container label {
      font-size: 16px;
      color: var(--silver);
      padding: 8px;
    }

    #title {
      width: 100%;
      height: 50px;
      padding: 10px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid var(--taupe-gray);
      resize: none;
      background-color: var(--rich-black);
      color: var(--silver);
      transition: background-color 0.3s, color 0.3s;
    }

    .create-post-container textarea {
      width: 100%;
      height: 120px;
      padding: 10px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid var(--taupe-gray);
      resize: none;
      background-color: var(--rich-black);
      color: var(--silver);
      transition: background-color 0.3s, color 0.3s;
    }

    .choices-TPC {
      font-size: 16px;
      color: var(--silver);
      margin-left: 20px;
    }

    .create-post-container input[type="file"] {
      margin-top: 15px;
      color: var(--silver);
    }

    .media-upload-section {
      margin-top: 20px;
      border-top: 1px solid var(--taupe-gray);
      padding-top: 15px;
    }

    .media-tabs {
      display: flex;
      margin-bottom: 15px;
    }

    .media-tab {
      padding: 8px 15px;
      background-color: var(--rich-black);
      color: var(--silver);
      border: 1px solid var(--taupe-gray);
      border-radius: 8px 8px 0 0;
      cursor: pointer;
      margin-right: 5px;
      transition: all 0.3s;
    }

    .media-tab.active {
      background-color: var(--moonstone);
      color: white;
      border-color: var(--moonstone);
    }

    .media-content {
      display: none;
    }

    .media-content.active {
      display: block;
    }

    #preview-container {
      margin-top: 15px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    #preview-container img {
      max-width: 100px;
      height: auto;
      border-radius: 8px;
      object-fit: cover;
      border: 1px solid var(--taupe-gray);
    }

    #video-preview-container {
      margin-top: 15px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    #video-preview-container video {
      max-width: 150px;
      height: auto;
      border-radius: 8px;
      border: 1px solid var(--taupe-gray);
    }

    .preview-item {
      position: relative;
    }

    .remove-preview {
      position: absolute;
      top: -8px;
      right: -8px;
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      text-align: center;
      line-height: 20px;
      cursor: pointer;
      font-size: 12px;
    }

    .create-post-container button {
      margin-top: 20px;
      width: 50%;
      padding: 12px;
      background-color: var(--moonstone);
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .button-group {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 20px;
    }

    .button-group button {
      flex: 1;
      padding: 12px;
      background-color: var(--moonstone);
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .create-post-container button:hover {
      background-color: var(--prussian-blue);
      border: 1px solid var(--moonstone);
    }

    input[type="radio"] {
      accent-color: var(--moonstone);
    }

    .file-upload-info {
      font-size: 12px;
      color: var(--taupe-gray);
      margin-top: 5px;
      margin-left: 15px;
    }
  </style>
</head>

<body>

  <div class="create-post-container">
    <h2>Create New Post</h2>
    <form action="home.php" method="POST" enctype="multipart/form-data">
      <label for="title">Title</label>
      <textarea id="title" name="title" placeholder="Add your title here..." required></textarea>

      <label for="content">Caption</label>
      <textarea id="content" name="content" placeholder="Enter the details of your invention here..." required></textarea>

      <label for="topic">Target TPC:</label>
      <div class="choices-TPC">
        <input type="radio" name="topic" value="Climate Change" required> Climate Change<br>
        <input type="radio" name="topic" value="Pollution"> Pollution<br>
        <input type="radio" name="topic" value="Biodiversity Loss"> Biodiversity Loss<br><br>
      </div>

      <div class="media-upload-section">
        <div class="media-tabs">
          <div class="media-tab active" data-tab="images">Images</div>
          <div class="media-tab" data-tab="videos">Videos</div>
        </div>

        <div class="media-content active" id="images-content">
          <label for="image">Add Photo(s)</label><br>
          <input type="file" id="image" name="images[]" accept="image/*" multiple>
          <div class="file-upload-info">Supported formats: JPG, PNG, GIF (Max: 8MB per file)</div>
          <div id="preview-container"></div>
        </div>

        <div class="media-content" id="videos-content">
          <label for="video">Add Video(s)</label><br>
          <input type="file" id="video" name="videos[]" accept="video/*" multiple>
          <div class="file-upload-info">Supported formats: MP4, WebM, MOV (Max: 8MB per file)</div>
          <div id="video-preview-container"></div>
        </div>
      </div>

      <div class="button-group">
        <button type="button" onclick="window.location.href='home.php'">Cancel</button>
        <button type="submit">Share</button>
      </div>
    </form>
  </div>

  <script>
    // Tab switching functionality
    document.querySelectorAll('.media-tab').forEach(tab => {
      tab.addEventListener('click', function() {
        
        document.querySelectorAll('.media-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.media-content').forEach(c => c.classList.remove('active'));
        
        this.classList.add('active');
        document.getElementById(`${this.dataset.tab}-content`).classList.add('active');
      });
    });

    // Image preview functionality
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('preview-container');

    imageInput.addEventListener('change', function() {
      previewContainer.innerHTML = '';
      const files = this.files;

      Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = "100px";
            img.style.margin = "5px";
            
            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-preview';
            removeBtn.innerHTML = '×';
            removeBtn.onclick = function() {
              previewItem.remove();
            };
            
            previewItem.appendChild(img);
            previewItem.appendChild(removeBtn);
            previewContainer.appendChild(previewItem);
          };
          reader.readAsDataURL(file);
        }
      });
    });

    // Video preview functionality
    const videoInput = document.getElementById('video');
    const videoPreviewContainer = document.getElementById('video-preview-container');

    videoInput.addEventListener('change', function() {
      videoPreviewContainer.innerHTML = '';
      const files = this.files;

      Array.from(files).forEach(file => {
        if (file.type.startsWith('video/')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            
            const video = document.createElement('video');
            video.src = e.target.result;
            video.style.width = "150px";
            video.style.margin = "5px";
            video.controls = true;
            video.muted = true;
            
            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-preview';
            removeBtn.innerHTML = '×';
            removeBtn.onclick = function() {
              previewItem.remove();
            };
            
            previewItem.appendChild(video);
            previewItem.appendChild(removeBtn);
            videoPreviewContainer.appendChild(previewItem);
          };
          reader.readAsDataURL(file);
        }
      });
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
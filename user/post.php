<?php
session_start();
include 'inc/header.php';
include '../auth/user_only.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
  </style>
</head>

<body>

  <div class="create-post-container">
    <h2>Create New Post</h2>
    <form action="home.php" method="POST" enctype="multipart/form-data">
      <label for="title">Title</label>
      <textarea id="title" name="title" placeholder="Add your title here..." required></textarea>

      <label for="content">Caption</label>
      <textarea id="content" name="content" placeholder="Post your innovations and inspire your community..."
        required></textarea>

      <label for="topic">Target TPC:</label>
      <div class="choices-TPC">
        <input type="radio" name="topic" value="Climate Change" required> Climate Change<br>
        <input type="radio" name="topic" value="Pollution"> Pollution<br>
        <input type="radio" name="topic" value="Biodiversity Loss"> Biodiversity Loss<br><br>
      </div>

      <label for="image">Add Photo(s)</label><br>
      <input type="file" id="image" name"images[]" accept="image/*" multiple>

      <div id="preview-container"></div>

      <div class="button-group">
        <button type="button" onclick="window.location.href='home.php'">Cancel</button>
        <button type="submit">Share</button>
      </div>
    </form>
  </div>

  <!-- For Previewing images before uploading-->
  <script>
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('preview-container');

    imageInput.addEventListener('change', function () {
      previewContainer.innerHTML = '';
      const files = this.files;

      Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = "100px";
            img.style.margin = "5px";
            previewContainer.appendChild(img);
          };
          reader.readAsDataURL(file);
        }
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      const body = document.body;
      if (localStorage.getItem('mode') === 'light') {
        body.classList.add('light-mode');
      }
    });
  </script>
</body>

</html>
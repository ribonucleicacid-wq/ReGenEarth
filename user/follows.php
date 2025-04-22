<?php 
session_start();
include 'inc/header.php'; 
include '../auth/user_only.php';
?>
<?php
$followedUsers = [
  [
    'fullname' => 'Noe',
    'profile_pic' => 'https://i.pravatar.cc/50?img=1'
  ],
  [
    'fullname' => 'Jasmin',
    'profile_pic' => 'https://i.pravatar.cc/50?img=3'
  ],
  [
    'fullname' => 'Daniel',
    'profile_pic' => 'https://i.pravatar.cc/50?img=2'
  ]
];

$followers = [
  [
    'fullname' => 'John Lorcan',
    'profile_pic' => 'https://i.pravatar.cc/50?img=5'
  ],
  [
    'fullname' => 'Dianne',
    'profile_pic' => 'https://i.pravatar.cc/50?img=4'
  ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Follows</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  
  <style>
:root {
  --brunswick-green: #234F38;
  --prussian-blue: #132F43;
  --silver: #CACFD3;
  --taupe-gray: #999A9C;
  --rich-black: #0B1A26;
}

.body {
  background-color: var(--rich-black);
  color: var(--silver);
  font-family: 'Poppins', sans-serif;
}

.body, html {
  height: 100%;
  margin: 0;
}

.center-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 50vh;
  padding-top: 0px; 
}

.follow-page {
  width: 100%;
  max-width: 600px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 10px;
  padding: 30px;
  backdrop-filter: blur(8px);
  margin-top: 0px;
  display: none;
}

.follow-page.active {
  display: block;
}

.follow-page h2 {
  color: white;
  font-weight: 600;
  margin-bottom: 20px;
  text-align: center;
}

.user-card {
  display: flex;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 15px 20px;
  margin-bottom: 15px;
  transition: box-shadow 0.3s;
  gap: 15px;
}

.user-select {
  width: 14px;
  height: 14px;
  border: 2px solid #ccc;
  border-radius: 50%;
  margin-right: 15px;
  cursor: pointer;
  transition: background 0.3s, border 0.3s;
}

.user-select.selected {
  background-color: var(--brunswick-green);
  border-color: var(--brunswick-green);
}

.user-card:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.user-card img {
  width: 55px;
  height: 55px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 15px;
}

.user-info {
  flex: 1;
  color: white;
}

.user-info strong {
  display: block;
  font-size: 16px;
}

.user-info small {
  font-size: 13px;
  color: #ccc;
}

.button.unfollow {
  background-color: #f44336;
  color: white;
  padding: 8px 20px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
  font-size: 14px;
  font-weight: 500;
}

.button.unfollow:hover {
  background-color: #d32f2f;
}

.button.follow {
  background-color: var(--brunswick-green);
  color: white;
  padding: 8px 20px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
  font-size: 14px;
  font-weight: 500;
}

.button.follow:hover {
  background-color: var(--prussian-blue);
  color: white;
}

.search-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
  gap: 10px;
}

#searchInput {
  padding: 10px 15px;
  width: 60%;
  max-width: 300px;
  border-radius: 8px;
  border: none;
  outline: none;
  background-color: rgba(255, 255, 255, 0.1);
  color: #fff;
  font-size: 14px;
}

#searchInput::placeholder {
  color: #bbb;
}

.search-btn {
  padding: 10px 18px;
  background-color: var(--prussian-blue);
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.search-btn:hover {
  background-color: var(--brunswick-green);
  color: white;
}

.segmented-tabs {
  display: flex;
  justify-content: center;
  background-color: rgba(255, 255, 255, 0.05);
  border-radius: 999px;
  padding: 4px;
  width: fit-content;
  margin: 20px auto 10px;
}

.segmented-tabs .tab {
  background: transparent;
  border: none;
  color: #ccc;
  padding: 8px 20px;
  font-size: 14px;
  font-weight: 500;
  border-radius: 999px;
  cursor: pointer;
  transition: background 0.3s, color 0.3s;
}

.segmented-tabs .tab.active {
  background-color: var(--brunswick-green);
  color: white;
}

.segmented-tabs .tab:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
}

.light-mode {
  --brunswick-green: #234F38;
  --prussian-blue: #132F43;
  --silver: #CACFD3;
  --taupe-gray: #999A9C;
  --rich-black: #FFFFFF;
}

.light-mode .follow-page {
  background: rgba(202, 207, 211, 0.4);
  color: var(--rich-black);
}

.light-mode .user-card {
  background-color: rgba(202, 207, 211, 0.6);
  color: var(--rich-black);
}

.light-mode .user-select {
  border-color: var(--taupe-gray);
}

.light-mode .user-select.selected {
  background-color: var(--brunswick-green);
  border-color: var(--brunswick-green);
}

.light-mode .user-card:hover {
  box-shadow: 0 4px 8px rgba(11, 26, 38, 0.2);
}

.light-mode .user-info {
  color: var(--rich-black);
}

.light-mode .user-info strong {
  color: var(--prussian-blue);
}

.light-mode .user-info small {
  color: var(--taupe-gray);
}

.light-mode .button.follow:hover {
  background-color: var(--prussian-blue);
  color: white;
}

.light-mode #searchInput {
  background-color: var(--silver);
  color: var(--rich-black);
  border: 1px solid var(--taupe-gray);
}

.light-mode #searchInput::placeholder {
  color: var(--taupe-gray);
}

.light-mode .search-btn {
  background-color: var(--brunswick-green);
  color: white;
}

.light-mode .search-btn:hover {
  background-color: var(--prussian-blue);
  color: white;
}

.light-mode .segmented-tabs {
  background-color: rgba(202, 207, 211, 0.5);
}

.light-mode .segmented-tabs .tab {
  color: var(--prussian-blue);
}

.light-mode .segmented-tabs .tab.active {
  background-color: var(--brunswick-green);
  color: white;
}

.light-mode .segmented-tabs .tab:hover {
  background-color: rgba(35, 79, 56, 0.2);
  color: var(--rich-black);
}
</style>
</head>

<body>
<div class="search-container">
  <input type="text" id="searchInput" placeholder="Search...">
  <button class="button search-btn">Search</button>
</div>


  <div class="segmented-tabs">
    <button class="tab active" onclick="showTab('following')">Following</button>
    <button class="tab" onclick="showTab('followers')">Followers</button>
</div>

<div class="center-wrapper">

  <div class="follow-page active" id="following">
    <?php foreach ($followedUsers as $user): ?>
      <div class="user-card">

        <img src="<?= $user['profile_pic'] ?>" alt="Profile Pic">
        <div class="user-info">
          <strong><?= htmlspecialchars($user['fullname']) ?></strong>
        </div>
        <button class="button unfollow">Unfollow</button>
      </div>
    <?php endforeach; ?>
  </div>

<!--followers-->

  <div class="follow-page" id="followers">
    <?php foreach ($followers as $user): ?>
      <div class="user-card">

        <img src="<?= $user['profile_pic'] ?>" alt="Profile Pic">
        <div class="user-info">
          <strong><?= htmlspecialchars($user['fullname']) ?></strong>
        </div>
        <button class="button follow">Follow</button>
      </div>
    <?php endforeach; ?>
  </div>
</div> 
<script>
  function toggleTheme() {
    document.body.classList.toggle('light-mode');
  }
</script>


<!-- Tab toggle script -->
<script>
  function showTab(tabId) {
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.follow-page').forEach(page => page.classList.remove('active'));

    document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');
    document.getElementById(tabId).classList.add('active');
  }

  document.querySelectorAll('.user-select').forEach(dot => {
    dot.addEventListener('click', () => {
      dot.classList.toggle('selected');
    });
  });


</script>

</body>
</html>

<?php
session_start();
 include 'inc/header.php';
include '../auth/user_only.php';

$db_host = 'localhost';
$db_name = 'regenearth';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . LANDING_PAGE);
    exit;
}

$current_user_id = $_SESSION['user_id'];

// fetch followed users from db
$stmt = $pdo->prepare("CALL GetFollowedUsers(?)");
$stmt->execute([$current_user_id]);
$followedUsers = $stmt->fetchAll();
$stmt->closeCursor();

// fetch followers from db
$stmt = $pdo->prepare("CALL GetFollowers(?)");
$stmt->execute([$current_user_id]);
$followers = $stmt->fetchAll();
$stmt->closeCursor();

// follow and unfollow actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['user_id'])) {
        $target_user_id = $_POST['user_id'];
        
        if ($_POST['action'] === 'follow') {
            try {
                $stmt = $pdo->prepare("CALL FollowAUser(?, ?)");
                $stmt->execute([$current_user_id, $target_user_id]);
                $stmt->closeCursor();
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Successfully followed user!']);
                exit;
            } catch (PDOException $e) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error following user: ' . $e->getMessage()]);
                exit;
            }
        } elseif ($_POST['action'] === 'unfollow') {
            try {
                $stmt = $pdo->prepare("CALL UnfollowAUser(?, ?)");
                $stmt->execute([$current_user_id, $target_user_id]);
                $stmt->closeCursor();
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Unfollowed user']);
                exit;
            } catch (PDOException $e) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error unfollowing user: ' . $e->getMessage()]);
                exit;
            }
        }
        exit;
    }
}

// search
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $pdo->prepare("CALL SearchUsers(?, ?)");
    $stmt->execute([$search, $current_user_id]);
    $searchResults = $stmt->fetchAll();
    $stmt->closeCursor();
    header('Content-Type: application/json');
    echo json_encode($searchResults);
    exit;
}
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

        body {
            background-color: var(--rich-black);
            color: var(--silver);
            font-family: 'Arial', sans-serif;
            margin: 0;
            /* padding: 20px; */
        }

        .center-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .follow-page {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            /* padding: 20px; */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        body.light-mode {
            background-color: #f5f5f5;
            color: #333;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.light-mode .follow-page {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        body.light-mode .user-card {
            background-color:rgb(217, 213, 213);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        body.light-mode .user-info strong {
            color: #333;
        }

        body.light-mode .tab {
            color: #666;
        }

        body.light-mode .tab.active {
            background-color: #234F38;
            color: white;
        }

        body.light-mode #searchInput {
            background-color: #f0f0f0;
            color: #333;
        }

        body.light-mode .button.follow {
            background-color: #234F38;
            color: white;
        }

        body.light-mode .button.unfollow {
            background-color: #999A9C;
            color: #333;
        }

        body.light-mode .success-message {
            background-color: #4CAF50;
        }

        body.light-mode .error-message {
            background-color: #f44336;
        }

        .segmented-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 5px;
            border-radius: 10px;
        }

        .tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            background: none;
            border: none;
            color: var(--silver);
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .tab.active {
            background-color: var(--brunswick-green);
            color: white;
        }

        .search-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        #searchInput {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--silver);
        }

        .search-btn {
            padding: 10px 20px;
            background-color: var(--brunswick-green);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .user-card {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 15px;
            transition: box-shadow 0.3s;
        }

        .user-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .user-card img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
        }

        .user-info strong {
            color: var(--silver);
            font-size: 1.1em;
        }

        .button {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .button.follow {
            background-color: var(--brunswick-green);
            color: white;
        }

        .button.unfollow {
            background-color: var(--taupe-gray);
            color: var(--rich-black);
        }

        .button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .success-message {
            background-color:rgb(81, 105, 82);
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            display: none;
        }

        .error-message {
            background-color: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            display: none;
        }

        .user-card {
            transition: all 0.3s ease;
        }

        .user-card.fade-out {
            opacity: 0;
            transform: translateY(-20px);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body class="body">
    <div class="center-wrapper">
        <div class="follow-page active">
            <div class="segmented-tabs">
                <button class="tab active" data-tab="following">Following</button>
                <button class="tab" data-tab="followers">Followers</button>
            </div>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search users...">
                <button class="search-btn">Search</button>
            </div>

            <div id="messageContainer"></div>

            <!-- Following Tab -->
            <div class="tab-content active" id="following">
                <h2>Following</h2>
                <div id="followingList">
                    <?php foreach ($followedUsers as $user): ?>
                        <div class="user-card" data-user-id="<?php echo $user['id']; ?>">
                            <img src="<?php echo $user['profile_pic']; ?>" alt="Profile">
                            <div class="user-info">
                                <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                            </div>
                            <button class="button unfollow" onclick="toggleFollow(this, <?php echo $user['id']; ?>, 'unfollow')">Unfollow</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Followers Tab -->
            <div class="tab-content" id="followers">
                <h2>Followers</h2>
                <div id="followersList">
                    <?php foreach ($followers as $user): ?>
                        <div class="user-card" data-user-id="<?php echo $user['id']; ?>">
                            <img src="<?php echo $user['profile_pic']; ?>" alt="Profile">
                            <div class="user-info">
                                <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                            </div>
                            <?php if (!in_array($user['id'], array_column($followedUsers, 'id'))): ?>
                                <button class="button follow" onclick="toggleFollow(this, <?php echo $user['id']; ?>, 'follow')">Follow</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store followed users in localStorage
        let followedUsers = <?php echo json_encode(array_column($followedUsers, 'id')); ?>;
        
        // Function to show message
        function showMessage(message, type) {
            const messageContainer = document.getElementById('messageContainer');
            messageContainer.innerHTML = `<div class="${type}-message">${message}</div>`;
            messageContainer.querySelector(`.${type}-message`).style.display = 'block';
            setTimeout(() => {
                messageContainer.querySelector(`.${type}-message`).style.display = 'none';
            }, 3000);
        }

        // Function to create user card HTML
        function createUserCard(userId, username, profilePic, isFollowing) {
            return `
                <div class="user-card" data-user-id="${userId}">
                    <img src="${profilePic}" alt="Profile">
                    <div class="user-info">
                        <strong>${username}</strong>
                    </div>
                    <button class="button ${isFollowing ? 'unfollow' : 'follow'}" 
                            onclick="toggleFollow(this, ${userId}, '${isFollowing ? 'unfollow' : 'follow'}')">
                        ${isFollowing ? 'Unfollow' : 'Follow'}
                    </button>
                </div>
            `;
        }

        // Function for follow at unfollow
        function toggleFollow(button, userId, action) {
            const userCard = button.closest('.user-card');
            const username = userCard.querySelector('.user-info strong').textContent;
            const profilePic = userCard.querySelector('img').src;
            
            if (action === 'follow') {
                // Add to followed 
                followedUsers.push(userId);
                
                // Add to Following 
                const followingList = document.getElementById('followingList');
                followingList.insertAdjacentHTML('beforeend', createUserCard(userId, username, profilePic, true));
                
                // Update button 
                button.textContent = 'Unfollow';
                button.className = 'button unfollow';
                button.onclick = function() { toggleFollow(this, userId, 'unfollow'); };
                
                showMessage(`Successfully followed ${username}!`, 'success');
            } else {
                // Remove from followed users
                followedUsers = followedUsers.filter(id => id !== userId);
                
                // Remove from Following tab
                const followingList = document.getElementById('followingList');
                const cardToRemove = followingList.querySelector(`[data-user-id="${userId}"]`);
                if (cardToRemove) {
                    cardToRemove.classList.add('fade-out');
                    setTimeout(() => cardToRemove.remove(), 300);
                }
                
                // Update button in current view
                button.textContent = 'Follow';
                button.className = 'button follow';
                button.onclick = function() { toggleFollow(this, userId, 'follow'); };
                
                showMessage(`Unfollowed ${username}`, 'success');
            }
        }

        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and content
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and show corresponding content
                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });

        // Search functionality
        document.querySelector('.search-btn').addEventListener('click', () => {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const currentTab = document.querySelector('.tab.active').dataset.tab;
            const userCards = document.querySelectorAll(`#${currentTab} .user-card`);
            
            userCards.forEach(card => {
                const username = card.querySelector('.user-info strong').textContent.toLowerCase();
                card.style.display = username.includes(searchTerm) ? 'flex' : 'none';
            });
        });
    </script>
</body>
</html>
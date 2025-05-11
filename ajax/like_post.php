<?php
session_start();
require_once '../src/db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    // First check if the post belongs to the current user
    $stmt = $conn->prepare("SELECT user_id FROM posts WHERE post_id = ?");
    $stmt->execute([$_POST['post_id']]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        echo json_encode(['success' => false, 'message' => 'Post not found']);
        exit();
    }

    if ($post['user_id'] == $_SESSION['user_id']) {
        echo json_encode(['success' => false, 'message' => 'Cannot like your own post']);
        exit();
    }

    // Check if already liked
    $stmt = $conn->prepare("SELECT like_id FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$_POST['post_id'], $_SESSION['user_id']]);
    $existing_like = $stmt->fetch();

    if ($existing_like) {
        // Unlike
        $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$_POST['post_id'], $_SESSION['user_id']]);
        $liked = false;
    } else {
        // Like
        $stmt = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        $stmt->execute([$_POST['post_id'], $_SESSION['user_id']]);
        $liked = true;

        // Create notification for post owner
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, notifier_id, type, notification_data) VALUES (?, ?, 'like', ?)");
        $notification_data = json_encode(['post_id' => $_POST['post_id']]);
        $stmt->execute([$post['user_id'], $_SESSION['user_id'], $notification_data]);
    }

    // Get updated like count
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM likes WHERE post_id = ?");
    $stmt->execute([$_POST['post_id']]);
    $likes_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    echo json_encode([
        'success' => true,
        'liked' => $liked,
        'likes_count' => $likes_count
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
} 
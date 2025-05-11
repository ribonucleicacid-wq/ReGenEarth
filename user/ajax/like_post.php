<?php
session_start();
require_once '../../src/db_connection.php';
require_once '../../src/notification_handler.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $db = new Database();
    $conn = $db->getConnection();
    $notificationHandler = new NotificationHandler();
    
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];
    
    try {
        // Get post owner ID
        $stmt = $conn->prepare("SELECT user_id FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        $post_owner = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if user already liked the post
        $stmt = $conn->prepare("SELECT like_id FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);
        $existing_like = $stmt->fetch();
        
        if ($existing_like) {
            // Unlike the post
            $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
            $stmt->execute([$user_id, $post_id]);
            $liked = false;
        } else {
            // Like the post
            $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $post_id]);
            $liked = true;
            
            // Create notification for post owner
            if ($post_owner && $post_owner['user_id'] != $user_id) {
                $notificationHandler->createLikeNotification($post_id, $user_id, $post_owner['user_id']);
            }
        }
        
        // Get updated like count
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM likes WHERE post_id = ?");
        $stmt->execute([$post_id]);
        $result = $stmt->fetch();
        $likes_count = $result['count'];
        
        echo json_encode([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likes_count
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?> 
<?php
session_start();
require_once '../../src/db_connection.php';
require_once '../../src/notification_handler.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $db = new Database();
    $conn = $db->getConnection();
    $notificationHandler = new NotificationHandler();
    
    $follower_id = $_SESSION['user_id'];
    $followed_id = $_POST['user_id'];
    
    try {
        // Check if already following
        $stmt = $conn->prepare("SELECT follow_id FROM follows WHERE follower_id = ? AND followed_id = ?");
        $stmt->execute([$follower_id, $followed_id]);
        $existing_follow = $stmt->fetch();
        
        if ($existing_follow) {
            // Unfollow
            $stmt = $conn->prepare("DELETE FROM follows WHERE follower_id = ? AND followed_id = ?");
            $stmt->execute([$follower_id, $followed_id]);
            $following = false;
        } else {
            // Follow
            $stmt = $conn->prepare("INSERT INTO follows (follower_id, followed_id) VALUES (?, ?)");
            $stmt->execute([$follower_id, $followed_id]);
            $following = true;
            
            // Create notification
            $notificationHandler->createFollowNotification($follower_id, $followed_id);
        }
        
        echo json_encode([
            'success' => true,
            'following' => $following
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
} 
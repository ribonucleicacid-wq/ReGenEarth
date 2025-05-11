<?php
session_start();
require_once '../../src/db_connection.php';
require_once '../../src/notification_handler.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id']) && isset($_POST['content'])) {
    $db = new Database();
    $conn = $db->getConnection();
    $notificationHandler = new NotificationHandler();
    
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];
    $content = trim($_POST['content']);
    $parent_comment_id = isset($_POST['parent_comment_id']) ? $_POST['parent_comment_id'] : null;
    
    try {
        // Get post owner ID
        $stmt = $conn->prepare("SELECT user_id FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        $post_owner = $stmt->fetch(PDO::FETCH_ASSOC);

        // If this is a reply, get the parent comment owner
        $parent_comment_owner = null;
        if ($parent_comment_id) {
            $stmt = $conn->prepare("SELECT user_id FROM comments WHERE comment_id = ?");
            $stmt->execute([$parent_comment_id]);
            $parent_comment_owner = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        // Insert the comment
        $stmt = $conn->prepare("INSERT INTO comments (user_id, post_id, parent_comment_id, content) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $parent_comment_id, $content]);
        $comment_id = $conn->lastInsertId();
        
        // Create notification for post owner (for comments)
        if (!$parent_comment_id && $post_owner && $post_owner['user_id'] != $user_id) {
            $notificationHandler->createCommentNotification($post_id, $user_id, $post_owner['user_id'], $content);
        }
        
        // Create notification for parent comment owner (for replies)
        if ($parent_comment_id && $parent_comment_owner && $parent_comment_owner['user_id'] != $user_id) {
            $notificationHandler->createReplyNotification($post_id, $user_id, $parent_comment_owner['user_id'], $content);
        }
        
        // Get the comment details including user info
        $stmt = $conn->prepare("
            SELECT 
                c.*,
                u.username,
                u.profile_picture
            FROM comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.comment_id = ?
        ");
        $stmt->execute([$comment_id]);
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'comment' => $comment
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?> 
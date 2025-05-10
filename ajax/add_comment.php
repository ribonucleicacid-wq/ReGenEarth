<?php
session_start();
require_once '../src/db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id']) || !isset($_POST['content'])) {
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
        echo json_encode(['success' => false, 'message' => 'Cannot comment on your own post']);
        exit();
    }

    // Add the comment
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['post_id'], $_SESSION['user_id'], $_POST['content']]);
    $comment_id = $conn->lastInsertId();

    // Create notification for post owner
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, notifier_id, type, notification_data) VALUES (?, ?, 'comment', ?)");
    $notification_data = json_encode([
        'post_id' => $_POST['post_id'],
        'comment_text' => substr($_POST['content'], 0, 100) // First 100 chars of comment
    ]);
    $stmt->execute([$post['user_id'], $_SESSION['user_id'], $notification_data]);

    // Get comment data for response
    $stmt = $conn->prepare("
        SELECT c.*, u.username, u.profile_picture 
        FROM comments c 
        JOIN users u ON c.user_id = u.user_id 
        WHERE c.comment_id = ?
    ");
    $stmt->execute([$comment_id]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'comment' => [
            'comment_id' => $comment['comment_id'],
            'content' => $comment['content'],
            'username' => $comment['username'],
            'profile_picture' => $comment['profile_picture'],
            'created_at' => $comment['created_at']
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
} 
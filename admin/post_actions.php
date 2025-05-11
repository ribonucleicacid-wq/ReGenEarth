<?php
require_once '../src/db_connection.php'; // assumes $pdo is available
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

try {
    switch ($action) {
        case 'list':
            $stmt = $pdo->query("CALL sp_list_posts()");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            $stmt->closeCursor(); // Required after CALL
            break;

        case 'delete':
            $postId = (int) ($data['id'] ?? 0);
            $reason = trim($data['reason'] ?? '');

            if ($postId > 0 && $reason !== '') {
                $stmt = $pdo->prepare("CALL sp_delete_post_with_reason(:id, :reason)");
                $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
                $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
                $stmt->execute();
                echo json_encode(['success' => true]);
                $stmt->closeCursor();
            } else {
                echo json_encode(['error' => 'Missing post ID or reason']);
            }
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

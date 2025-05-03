<?php
require_once '../../src/db_connection.php';

$db = new Database();
$conn = $db->getConnection();

$action = $_POST['action'] ?? '';

function formatDate($date)
{
    return date("d-m-Y h:iA", strtotime($date));
}

try {
    switch ($action) {
        case 'list':
            $stmt = $conn->prepare("CALL DisplayUsers(:userRoles)");
            $stmt->bindValue(':userRoles', 'user');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Format date and bio
            foreach ($users as &$user) {
                $user['bio'] = $user['bio'] ?: 'The user is lazy to put bio.';
                $user['created_at'] = formatDate($user['created_at']);
                $user['updated_at'] = formatDate($user['updated_at']);
            }

            echo json_encode($users);
            break;

        case 'searchUser':
            $stmt = $conn->prepare("CALL SearchUser(:userRole, :searchTerm)");
            $stmt->bindValue(':userRole', 'user');
            $stmt->bindValue(':searchTerm', $_POST['searchTerm']);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Format date and bio
            foreach ($users as &$user) {
                $user['bio'] = $user['bio'] ?: 'The user is lazy to put bio.';
                $user['created_at'] = formatDate($user['created_at']);
                $user['updated_at'] = formatDate($user['updated_at']);
            }

            echo json_encode($users);
            break;

        case 'get':
            $stmt = $conn->prepare("CALL DisplayUsers(:userRoles)");
            $stmt->bindValue(':userRoles', 'user');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $userId = $_POST['user_id'];
            $user = array_filter($users, fn($u) => $u['user_id'] == $userId);
            echo json_encode(array_values($user)[0] ?? []);
            break;

        case 'add':
            $defaultPassword = 'ReGenEarth2025';
            $stmt = $conn->prepare("CALL AddUser(:username, :email, :password_hash, :bio, 'user')");
            $stmt->execute([
                ':username' => $_POST['username'],
                ':email' => $_POST['email'],
                ':password_hash' => password_hash($defaultPassword, PASSWORD_DEFAULT),
                ':bio' => $_POST['bio']
            ]);
            echo json_encode(['status' => 'success']);
            break;


        case 'update':
            $stmt = $conn->prepare("CALL UpdateUser(:userId, :username, :email, :bio, 'user')");
            $stmt->execute([
                ':userId' => $_POST['user_id'],
                ':username' => $_POST['username'],
                ':email' => $_POST['email'],
                ':bio' => $_POST['bio']
            ]);
            echo json_encode(['status' => 'updated']);
            break;

        case 'delete':
            $stmt = $conn->prepare("CALL DeleteUser(:userId, 'user')");
            $stmt->execute([':userId' => $_POST['user_id']]);
            echo json_encode(['status' => 'deleted']);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Unknown action']);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
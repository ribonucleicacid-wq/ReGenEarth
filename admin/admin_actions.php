<?php
session_start();
require_once '../src/db_connection.php';

$db = new Database();
$conn = $db->getConnection();

// ✅ Decode JSON input if sent via fetch()
if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $json = file_get_contents('php://input');
    $_POST = json_decode($json, true);
}

$action = $_POST['action'] ?? '';

function formatDate($date)
{
    return date("d-m-Y h:iA", strtotime($date));
}

try {
    switch ($action) {
        case 'list':
            $stmt = $conn->prepare("CALL DisplayUsers(:userRoles)");
            $stmt->bindValue(':userRoles', 'admin,staff');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as &$user) {
                $user['created_at'] = formatDate($user['created_at']);
                $user['updated_at'] = formatDate($user['updated_at']);
            }
            echo json_encode($users);
            break;

        case 'searchUser':
            $searchTerm = $_POST['searchTerm'] ?? '';
            $stmt = $conn->prepare("CALL SearchUser(:userRoles, :searchTerm)");
            $stmt->bindValue(':userRoles', 'admin,staff');
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as &$user) {
                $user['bio'] = $user['bio'] ?: 'No bio.';
                $user['created_at'] = formatDate($user['created_at']);
                $user['updated_at'] = formatDate($user['updated_at']);
            }

            echo json_encode($users);
            break;

        case 'get':
            $userId = $_POST['user_id'] ?? null;
            if (!$userId) {
                echo json_encode(['status' => 'error', 'message' => 'Missing user ID']);
                break;
            }
            $stmt = $conn->prepare("CALL GetUserById(:userId)");
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $user['bio'] = $user['bio'] ?: 'No bio.';
                $user['created_at'] = formatDate($user['created_at']);
                $user['updated_at'] = formatDate($user['updated_at']);
            }
            echo json_encode($user ?? []);
            break;

        case 'add':
            $defaultPassword = $_POST['password'] ?? 'ReGenEarth2025';
            $stmt = $conn->prepare("CALL AddUser(:username, :email, :password_hash, :bio, :role)");
            $stmt->execute([
                ':username' => $_POST['username'],
                ':email' => $_POST['email'],
                ':password_hash' => password_hash($defaultPassword, PASSWORD_DEFAULT),
                ':bio' => $_POST['bio'] ?: 'No bio.',
                ':role' => $_POST['role']
            ]);
            echo json_encode(['status' => 'success']);
            if ('status' === 'success') {
                require_once '../src/emailFunctions.php';
                sendNewUserCredentialsEmail($email, $username, $defaultPassword);
            }
            break;

        case 'update':
            $stmt = $conn->prepare("CALL UpdateUser(:userId, :username, :email, :bio, :role)");
            $stmt->execute([
                ':userId' => $_POST['user_id'],
                ':username' => $_POST['username'],
                ':email' => $_POST['email'],
                ':bio' => $_POST['bio'],
                ':role' => $_POST['role'] ?? null
            ]);
            echo json_encode(['status' => 'updated']);
            break;
        case 'delete':
            $userId = $_POST['user_id'] ?? null;
            if (!$userId) {
                echo json_encode(['status' => 'error', 'message' => 'Missing user ID']);
                break;
            }

            $stmt = $conn->prepare("CALL DeleteUser(:userId, :role)");
            $stmt->execute([
                ':userId' => $userId,
                ':role' => 'admin,staff'
            ]);
            echo json_encode(['status' => 'deleted']);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

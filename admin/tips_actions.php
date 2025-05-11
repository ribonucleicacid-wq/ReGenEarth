<?php
// Include the database connection
include_once '../src/db_connection.php';

// Set headers for JSON response
header('Content-Type: application/json');

// Instantiate the Database object and get the connection
$database = new Database();
$pdo = $database->getConnection();

// Get the POST data from the request body
$inputData = json_decode(file_get_contents("php://input"), true);  // Parse JSON data

// Extract data from the POST request
$action = $inputData['action'] ?? '';
$searchTerm = $inputData['search'] ?? '';

try {
    switch ($action) {
        case 'list':
            // Call the stored procedure to get all tips
            $stmt = $pdo->query("CALL GetAllTips()");
            $tips = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($tips);
            break;

        case 'search':
            // Search tips by term
            $stmt = $pdo->prepare("CALL SearchTips(:searchTerm)");
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $tips = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($tips);
            break;

        case 'get':
            // Get a specific tip by ID
            $id = $inputData['id'] ?? 0;
            $stmt = $pdo->prepare("CALL GetTipById(:id)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $tip = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($tip);
            break;

        case 'add':
            // Add a new tip
            $category = $inputData['category'] ?? '';
            $tip = $inputData['tip'] ?? '';
            $stmt = $pdo->prepare("CALL CreateTip(:category, :tip)");
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':tip', $tip, PDO::PARAM_STR);
            $stmt->execute();
            echo json_encode(['success' => true]);
            break;

        case 'update':
            // Update an existing tip
            $id = $inputData['id'] ?? 0;
            $category = $inputData['category'] ?? '';
            $tip = $inputData['tip'] ?? '';
            $stmt = $pdo->prepare("CALL UpdateTip(:id, :category, :tip)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':tip', $tip, PDO::PARAM_STR);
            $stmt->execute();
            echo json_encode(['success' => true]);
            break;

        case 'delete':
            // Delete a tip by ID
            $id = $inputData['id'] ?? 0;
            $stmt = $pdo->prepare("CALL DeleteTip(:id)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(['success' => true]);
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
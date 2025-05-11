<?php
include '../src/db_connection.php'; // Include the database connection class

function getRandomTip($conn) {
    try {
        $stmt = $conn->prepare("CALL GetRandomDailyTip()");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['tip'] : 'No tips available at the moment.';
    } catch (Exception $e) {
        return 'No tips available at the moment.';
    }
}

function getGeneralTips($conn) {
    try {
        $stmt = $conn->prepare("CALL GetGeneralTips()");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $results ? $results : ['No general tips available at the moment.'];
    } catch (Exception $e) {
        return ['No general tips available at the moment.'];
    }
}

// Handle different actions
$action = isset($_GET['action']) ? $_GET['action'] : 'random';

try {
    $db = new Database(); // Create a new instance of the Database class
    $conn = $db->getConnection(); // Get the PDO connection
    
    header('Content-Type: application/json');
    
    switch ($action) {
        case 'general':
            $tips = getGeneralTips($conn);
            echo json_encode(['tips' => $tips]);
            break;
        default:
            $tip = getRandomTip($conn);
            echo json_encode(['tip' => $tip]);
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['tip' => 'No tips available at the moment.']);
}
?>
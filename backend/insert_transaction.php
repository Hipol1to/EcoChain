<?php
require 'db.php'; // Include database connection

// Add CORS headers
header('Access-Control-Allow-Origin: http://localhost:3000'); // Allow requests from your React app
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Allow specific HTTP methods
header('Access-Control-Allow-Headers: Content-Type'); // Allow specific headers
header('Content-Type: application/json'); // Set response type

// Handle preflight (OPTIONS) request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    if (!isset($input['sender'], $input['receiver'], $input['amount'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Extract data from input
    $sender = $input['sender'];
    $receiver = $input['receiver'];
    $amount = $input['amount'];

    try {
        // Prepare and execute the insert query
        $stmt = $pdo->prepare("INSERT INTO transactions (sender, receiver, amount, datecreated, datemodified) 
                               VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->execute([$sender, $receiver, $amount]);

        // Respond with success
        echo json_encode(['message' => 'Transaction inserted successfully']);
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Failed to insert transaction', 'details' => $e->getMessage()]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method']);
}
?>

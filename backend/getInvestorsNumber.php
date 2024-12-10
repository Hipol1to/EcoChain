<?php
require 'db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Optional: Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Optional: Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

try {
    $stmt = $pdo->query("SELECT investorsnumber FROM investors LIMIT 1");
     $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['investorsnumber'] !== null) {
        echo $result['investorsnumber'];
    } else {
        echo 0;
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>

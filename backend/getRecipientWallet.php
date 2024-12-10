<?php
require 'db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Optional: Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Optional: Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $pdo->query("SELECT receiver FROM `transactions` WHERE id = 2 AND sender = 'dummy'");
        $account = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $account['receiver'];
}
?>

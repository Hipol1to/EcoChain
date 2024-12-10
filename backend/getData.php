<?php
require 'db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Optional: Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Optional: Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'];

    if ($type === 'transaction') {
        $stmt = $pdo->query("SELECT * FROM transactions");
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($transactions);
    } elseif ($type === 'currency') {
        $stmt = $pdo->query("SELECT * FROM currency");
        $currency = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($currency);
    } elseif ($type === 'investor') {
        $stmt = $pdo->query("SELECT * FROM investors");
        $investors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($investors);
    }
}
?>

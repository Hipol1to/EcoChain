<?php
require 'db.php';

// Get the table type and ID from the query parameters
$type = $_GET['type'];
$id = $_GET['id'];

try {
    // Determine the table to delete from based on the type
    switch ($type) {
        case 'transaction':
            $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = :id");
            break;
        case 'currency':
            $stmt = $pdo->prepare("DELETE FROM currency WHERE id = :id");
            break;
        case 'investor':
            $stmt = $pdo->prepare("DELETE FROM investors WHERE id = :id");
            break;
        default:
            throw new Exception("Invalid type specified.");
    }

    // Execute the delete query
    $stmt->execute([':id' => $id]);

    // Redirect back to the main CRUD page
    header('Location: crud.php');
    exit;
} catch (Exception $e) {
    // Handle errors gracefully
    echo "Error: " . $e->getMessage();
    exit;
}
?>

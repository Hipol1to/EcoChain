<?php
require 'db.php';

$type = $_GET['type'];
$id = $_POST['id'];

// Update logic based on the type
switch ($type) {
    case 'transaction':
        $stmt = $pdo->prepare("UPDATE transactions SET sender = :sender, receiver = :receiver, amount = :amount WHERE id = :id");
        $stmt->execute([
            ':sender' => $_POST['sender'],
            ':receiver' => $_POST['receiver'],
            ':amount' => $_POST['amount'],
            ':id' => $id
        ]);
        break;
    case 'currency':
        $stmt = $pdo->prepare("UPDATE currency SET currentvalue = :currentvalue, releasevalue = :releasevalue WHERE id = :id");
        $stmt->execute([
            ':currentvalue' => $_POST['currentvalue'],
            ':releasevalue' => $_POST['releasevalue'],
            ':id' => $id
        ]);
        break;
    case 'investor':
        $stmt = $pdo->prepare("UPDATE investors SET investorsnumber = :investorsnumber WHERE id = :id");
        $stmt->execute([
            ':investorsnumber' => $_POST['investorsnumber'],
            ':id' => $id
        ]);
        break;
}
header('Location: crud.php');
?>

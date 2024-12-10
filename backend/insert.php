<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    if ($type === 'transaction') {
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        $amount = $_POST['amount'];

        $stmt = $pdo->prepare("INSERT INTO transactions (sender, receiver, amount, datecreated, datemodified) 
                               VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->execute([$sender, $receiver, $amount]);
    } elseif ($type === 'currency') {
        $currencyName = $_POST['currencyname'];
        $currentValue = $_POST['currentvalue'];
        $releaseValue = $_POST['releasevalue'];

        $stmt = $pdo->prepare("INSERT INTO currency (currencyname, currentvalue, releasevalue, datecreated, datemodified) 
                               VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->execute([$currencyName, $currentValue, $releaseValue]);
    } elseif ($type === 'investor') {
        $investorsNumber = $_POST['investorsnumber'];

        $stmt = $pdo->prepare("INSERT INTO investors (investorsnumber, datecreated, datemodified) 
                               VALUES (?, NOW(), NOW())");
        $stmt->execute([$investorsNumber]);
    }
} else {
  $type = $_POST['type'];

try {
    switch ($type) {
        case 'transaction':
            $stmt = $pdo->prepare("INSERT INTO transactions (sender, receiver, amount, datecreated) 
                                    VALUES (:sender, :receiver, :amount, NOW())");
            $stmt->execute([
                ':sender' => $_POST['sender'],
                ':receiver' => $_POST['receiver'],
                ':amount' => $_POST['amount']
            ]);
            break;

        case 'currency':
            $stmt = $pdo->prepare("INSERT INTO currency (currencyname, currentvalue, releasevalue, datecreated) 
                                    VALUES (:currencyname, :currentvalue, :releasevalue, NOW())");
            $stmt->execute([
                ':currencyname' => $_POST['currencyname'],
                ':currentvalue' => $_POST['currentvalue'],
                ':releasevalue' => $_POST['releasevalue']
            ]);
            break;

        case 'investor':
            $stmt = $pdo->prepare("INSERT INTO investors (investorsnumber, datecreated) 
                                    VALUES (:investorsnumber, NOW())");
            $stmt->execute([
                ':investorsnumber' => $_POST['investorsnumber']
            ]);
            break;

        default:
            throw new Exception("Invalid type specified.");
    }

    // Redirect back to the CRUD page
    header('Location: crud.php');
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
}
?>

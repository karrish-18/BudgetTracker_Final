<?php
session_start();
require_once 'connection.php'; 
require_once 'Transaction.php'; 

// Bypass login for screenshots
$_SESSION['user_id'] = 1; 
$_SESSION['username'] = "Engineering Student";

$db = new Database();
$conn = $db->getConnection();
$transObj = new Transaction($conn);

if (isset($_POST['add_btn'])) {
    $transObj->add($_SESSION['user_id'], $_POST['amt'], $_POST['desc']);
    header("Location: dashboard.php");
    exit();
}

$total = $transObj->getBalance($_SESSION['user_id']);
$history = $transObj->getHistory($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Budget Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 40px; }
        .box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        .balance { background: #28a745; color: white; padding: 20px; border-radius: 8px; text-align: center; font-size: 24px; }
        input, button { width: 100%; padding: 12px; margin: 10px 0; box-sizing: border-box; border-radius: 5px; border: 1px solid #ddd; }
        button { background: #007bff; color: white; border: none; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Budget Dashboard</h2>
        <div class="balance">Balance: ₹<?= number_format($total, 2) ?></div>
        <form method="POST">
            <input type="number" name="amt" placeholder="Amount" required>
            <input type="text" name="desc" placeholder="Description" required>
            <button type="submit" name="add_btn">Add Record</button>
        </form>
        <hr>
        <h3>Recent Records</h3>
        <?php foreach($history as $h): ?>
            <p><strong>₹<?= $h['amount'] ?></strong> - <?= htmlspecialchars($h['description']) ?> <br><small><?= $h['date'] ?></small></p>
        <?php endforeach; ?>
    </div>
</body>
</html>
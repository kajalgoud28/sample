<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;
$total_amount = isset($_GET['total']) ? floatval($_GET['total']) : 0.0;

if (!$product_id && !$total_amount) {
    die("Invalid access.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Payment Method</title>
</head>
<body>
    <h2>Select Payment Method</h2>
    <form action="process_payment.php" method="post">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
        <input type="hidden" name="total_amount" value="<?= htmlspecialchars($total_amount) ?>">
        <label>
            <input type="radio" name="payment_method" value="UPI" required> UPI
        </label><br>
        <label>
            <input type="radio" name="payment_method" value="Credit/Debit Card" required> Credit/Debit Card
        </label><br>
        <label>
            <input type="radio" name="payment_method" value="Net Banking" required> Net Banking
        </label><br>
        <button type="submit">Proceed to Pay</button>
    </form>
</body>
</html>

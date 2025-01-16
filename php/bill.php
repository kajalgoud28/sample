<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;
$total_amount = isset($_GET['total']) ? floatval($_GET['total']) : 0.0;
$payment_method = isset($_GET['method']) ? $_GET['method'] : null;

if (!$product_id || !$total_amount || !$payment_method) {
    die("Invalid bill details.");
}

// Fetch product details
$sql = "SELECT name, price FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill</title>
</head>
<body>
    <h2>Bill</h2>
    <p>Product: <?= htmlspecialchars($product['name']) ?></p>
    <p>Price: ₹<?= number_format($product['price'], 2) ?></p>
    <p>Total: ₹<?= number_format($total_amount, 2) ?></p>
    <p>Payment Method: <?= htmlspecialchars($payment_method) ?></p>
    <p>Payment Status: Successful</p>
    <p><a href="products.php">Continue Shopping</a></p>
</body>
</html>

<?php
$conn->close();
?>

<?php
session_start();
include '../php/connection.php';

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT name, price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        echo "<h2>Payment Successful</h2>";
        echo "<p>Product: " . htmlspecialchars($product['name']) . "</p>";
        echo "<p>Price: ₹" . number_format($product['price'], 2) . "</p>";
        echo "<p>Total: ₹" . number_format($product['price'], 2) . "</p>";
        echo "<p>Thank you for your purchase!</p>";
        echo "<p><a href='products.php'>Continue Shopping</a></p>";
    } else {
        echo "Invalid product ID.";
    }
}
?>

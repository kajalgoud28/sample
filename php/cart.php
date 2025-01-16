<?php
session_start();
include '../php/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user_id from the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = intval($_POST['product_id']); // Ensure the product_id is an integer

    if (isset($_POST['add_to_cart'])) {
        // Add to cart
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)
                ON DUPLICATE KEY UPDATE quantity = quantity + 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();

        header("Location: products.php?added=$product_id");
        exit();
    } elseif (isset($_POST['remove_from_cart'])) {
        // Remove from cart
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();

        header("Location: view_cart.php?removed=$product_id");
        exit();
    }
}

$conn->close();
?>

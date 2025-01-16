<?php
session_start();
include '../php/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user_id from the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);

        // Delete the product from the cart
        $sql = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param('ii', $product_id, $user_id);
        if ($stmt->execute()) {
            header("Location: view_cart.php"); // Redirect back to the cart page after removal
            exit();
        } else {
            echo "Error removing product: " . $stmt->error;
        }
    } else {
        echo "Invalid product ID.";
    }
}

$conn->close();
?>

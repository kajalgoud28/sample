<?php
session_start();
include '../php/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $user_id = $_SESSION['user_id'];

        // Simulate payment process (fake UPI page)
        // After payment is "successful", redirect to receipt page
        header("Location: receipt.php?product_id=" . $product_id);
        exit();
    }
}
?>

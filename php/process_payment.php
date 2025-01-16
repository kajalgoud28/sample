<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
$total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0.0;
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;

if (!$product_id || !$total_amount || !$payment_method) {
    die("Invalid payment details.");
}

// Simulate payment success
$payment_successful = true; // Assume always successful for this fake process

if ($payment_successful) {
    // Redirect to bill page
    header("Location: bill.php?product_id=$product_id&total=$total_amount&method=$payment_method");
    exit();
} else {
    echo "Payment failed. Please try again.";
}

$conn->close();
?>

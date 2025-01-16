// In update_cart.php
<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : null;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($cart_id && $quantity > 0) {
    $sql = "UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $quantity, $cart_id, $user_id);
    if ($stmt->execute()) {
        header("Location: view_cart.php"); // Redirect back to the cart
    } else {
        echo "Error updating quantity: " . $stmt->error;
    }
} else {
    echo "Invalid quantity or cart ID.";
}

$conn->close();
?>

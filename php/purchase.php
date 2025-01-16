<?php
session_start();
include '../php/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user_id from the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);

        // Check if the product_id exists in the user's cart
        $sql = "SELECT cart.id AS cart_id, products.name, products.price, cart.quantity
                FROM cart
                JOIN products ON cart.product_id = products.id
                WHERE cart.product_id = ? AND cart.user_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('ii', $product_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === FALSE) {
            die("Error executing query: " . $conn->error);
        }

        $item = $result->fetch_assoc();

        if ($item) {
            $price = $item['price'];
            $quantity = $item['quantity'];

            // Insert into purchases table
            $sql = "INSERT INTO purchases (user_id, product_id, price, quantity) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Prepare failed: ' . $conn->error);
            }
            $stmt->bind_param('iidi', $user_id, $product_id, $price, $quantity);
            if ($stmt->execute()) {
                echo "Received Product ID: " . htmlspecialchars($_POST['product_id']) . "<br>";
echo "User ID: " . htmlspecialchars($user_id) . "<br>";

                // Display receipt
                echo "<h2>Receipt</h2>";
                echo "<p>Product: " . htmlspecialchars($item['name']) . "</p>";
                echo "<p>Price: ₹" . number_format($price, 2) . "</p>";
                echo "<p>Quantity: " . htmlspecialchars($quantity) . "</p>";
                echo "<p>Total: ₹" . number_format($price * $quantity, 2) . "</p>";
                echo "<p><a href='view_cart.php'>Back to Cart</a></p>";
            } else {
                echo "Error inserting record: " . $stmt->error;
            }
        } else {
            echo "Invalid product ID or this product is not in your cart.";
        }
    } else {
        echo "Invalid product ID.";
    }
}

$conn->close();
?>

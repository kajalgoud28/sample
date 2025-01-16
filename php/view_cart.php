<?php
session_start(); // Start the session to access session variables
include '../php/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location:../login.html"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user_id from the session

// Prepare and execute the SQL query to fetch the user's cart items
$sql = "SELECT cart.id AS cart_id, products.name, products.price, cart.quantity, products.image 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
} else {
    echo "No items found in your cart.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/products.css">
    <title>Checkout</title>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <img src="../image/logo.png" alt="Salon Elegance logo" class="logo-img">
        </div>
        <div class="salon-info">
            <h1 class="salon-title">Elegance</h1>
            <p class="salon-subtitle">Hair and Beauty Salon</p>
        </div>
        <nav class="main-nav">
            <ul>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : ''; ?>"><a href="../index.php">Home</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : ''; ?>"><a href="#services">Services</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : ''; ?>"><a href="#about">About Us</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'contact.php') !== false ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'products.php') !== false ? 'active' : ''; ?>"><a href="products.php">Products</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'view_cart.php') !== false ? 'active' : ''; ?>"><a href="view_cart.php">Cart</a></li>
            </ul>
        </nav>
        <div class="header-right">
            <form action="../php/search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
            <div class="login-form">
                <a href="../login.html"><i class="material-icons">&#xe7fd;</i></a>
            </div>
        </div>
    </div>
</header>


<div class="container">
    <?php if (count($cart_items) > 0): ?>
        <table>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="100"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>₹<?php echo number_format($item['price'], 2); ?></td>
                    <td><form action="update_cart.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $cart_item['product_id']; ?>">
    <input type="number" name="quantity" value="<?php echo $cart_item['quantity']; ?>" min="1">
    <button type="submit" name="update_quantity">Update Quantity</button>
</form>
</td>
                    <td>
    <!-- Remove from Cart -->
    <form action="cart.php" method="POST" style="display:inline;">
        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>"> <!-- Use product_id instead of cart_id -->
        <button type="submit" name="remove_from_cart">Remove</button>
    </form>
    <!-- Buy Now -->
    
    <form action="payment.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <button type="submit" name="buy_now">Buy Now</button>
</form>


</td>

                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Purchase All Button -->
        <form action="checkout.php" method="POST">
            <button type="submit" name="purchase_all">Purchase All</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<footer>
    <!-- Footer content here -->
</footer>
</body>
</html>

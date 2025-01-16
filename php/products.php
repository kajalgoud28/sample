<?php
include '../php/connection.php';

session_start(); // Start session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Prepare and execute the SQL statement
$sql = "SELECT id, name, description, price, image FROM products";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
if ($result->num_rows > 0) {
    // Fetch data and add to products array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/products.css">
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
    <?php foreach ($products as $product): ?>
        <div class="product">
            <div class="product-image">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>

            <!-- Add to Cart Button -->
            <form action="cart.php" method="POST" style="display: inline;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>
            
            <!-- Buy Now Button -->
            <form method="POST" action="checkout.php" style="display: inline;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit">Buy Now</button>
            </form>

            <?php if (isset($_GET['added']) && $_GET['added'] == $product['id']): ?>
                <p class="success-message">Your product has been added to the cart!</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/search.css"> 
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/hero.css">
</head>
<body>
    <?php
    session_start();
    ?>
    <header>
        <div class="logo">
            <img src="../image/logo.png" alt="Salon Elegance logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="../index.php#home">Home</a></li>
                <li><a href="../index.php#services">Services</a></li>
                <li><a href="../index.php#about">About Us</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="view_cart.php">Cart</a></li>
            </ul>
        </nav>
        <div class="header-right">
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
                <div class="login-form">
                    <a href="../login.html">Login</a>
                </div>
            </form>
        </div>
    </header>


    <?php 
    include '../php/connection.php';

    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        $query = $conn->real_escape_string($query);
        $sql = "SELECT id, name, description, price, image, mime_type FROM products WHERE name LIKE '%$query%' OR description LIKE '%$query%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Search results for '$query':</h2>";
            echo "<div class='product_list'>";

            while ($row = $result->fetch_assoc()) {
                $mimeType = isset($row['mime_type']) ? htmlspecialchars($row['mime_type']) : 'image/jpeg';
                $imageData = base64_encode($row['image']);
                $imageSrc = "data:$mimeType;base64,$imageData";

                echo "<div class='products'>";
                echo "<img src='$imageSrc' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
                echo "<form action='../php/cart.php' method='POST'>";
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<button type='submit'>Add to Cart</button>";
                echo "</form>";

                // Display success message if 'added' parameter is set
                if (isset($_GET['added']) && $_GET['added'] == $row['id']) {
                    echo "<p>Your product has been added to the cart!</p>";
                }

                echo "</div>";
            }
            echo "</div>";

        } else {
            echo "<h2>No results found for '$query'</h2>";
        }

    } else {
        echo "<h2>No search query provided.</h2>";
    }

    $conn->close();
    ?>
</body>
</html>

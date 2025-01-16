<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Elegance</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/hero.css">
    <!-- Material Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</head>
<body>
    <?php
    session_start();
    ?>
    <header>
    <div class="header-container">
        <div class="logo">
            <img src="image/logo.png" alt="Salon Elegance logo" class="logo-img">
        </div>
        <nav class="main-nav">
        <div class="salon-info">
        <h1 class="salon-title"> Elegance</h1>
        <h2 class="salon-subtitle">Hair and Beauty Salon</h2>
    </div>
    
    <ul>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>"><a href="#services">Services</a></li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"><a href="#about">About Us</a></li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>"><a href="php/products.php">Products</a></li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_cart.php' ? 'active' : ''; ?>"><a href="./php/view_cart.php">Cart</a></li>
    </ul>

        </nav>
        <div class="header-right">
            <form action="php/search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
            <div class="login-form">
        <a href="login.html"><i class="fas fa-user"></i></a>
    </div>
        </div>
    </div>
    
</header>

    <section id="home" class="blink">
        <div class="blink-content">
            <div class="blinking-username-container">
                <img src="image/blink1.png" alt="hair image" class="blink1-image">
                <span class="blinking-username">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo 'Welcome ' . htmlspecialchars($_SESSION['username']) . '!';
                    }
                    ?>
                </span>
            </div>
            <h1>Welcome to Salon Elegance</h1>
            <p>Your beauty, our duty.</p>
            <button id="btn1" onclick="window.location.href='appointment.html'">Book Appointment</button>
            <img src="image/hero.png" alt="Salon Elegance blink Image" class="blink-image">
            <img src="image/girl.jpg" alt="girl image" class="girl-image">
        </div>
    </section>

    <section id="services">
        <h2>Our Services</h2>
        <div class="service-container">
            <div class="service">
                <a href="skin_service.html">
                    <img src="image/facial.webp" alt="Skin Service" class="service1">
                    <h3>Skin Service</h3>
                </a>
                <p>Professional skin care services tailored to your needs.</p>
            </div>
            <div class="service">
                <a href="hair_service.html">
                    <img src="image/service2.jpg" alt="Hair Service" class="service2">
                    <h3>Hair Service</h3>
                </a>
                <p>Expert hair services for a vibrant look.</p>
            </div>
        </div>
    </section>
    
    <section id="about">
        <h2>About Us</h2>
        <p>Salon Elegance has been providing top-notch beauty services since 2000. Our team of professionals is dedicated to making you look and feel your best.</p>
    </section>
    
    <footer>
        <p>&copy; 2024 Salon Elegance. All rights reserved.</p>
    </footer>

    
    
</body>
</html>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyStore</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
<header>
    <h1>The3Guys PC Shop</h1>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <?php if ($isLoggedIn): ?>
            <a href="cart.php">Cart</a>
            <a href="orders.php">Orders</a>
            <a href="checkout.php">Checkout</a>
            <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a>
        <?php else: ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
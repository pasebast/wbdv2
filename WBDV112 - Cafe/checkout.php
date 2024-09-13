<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Process checkout
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Logic to handle checkout (e.g., save to database, clear cart, etc.)
    echo "<p>Thank you for your order!</p>";
    unset($_SESSION['cart']); // Clear the cart after checkout
} else {
    echo "<p>Your cart is empty!</p>";
}
?>

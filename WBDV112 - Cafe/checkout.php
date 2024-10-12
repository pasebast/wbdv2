<?php
session_start();

// Handle checkout confirmation
if (isset($_POST['confirm_checkout'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Process the order (e.g., store it in the database)
        // For this example, we'll just clear the cart

        // Example: Save order to database logic can go here

        // Clear the cart after checkout
        unset($_SESSION['cart']);
        echo "<p>Thank you for your order! Your order has been confirmed.</p>";
    } else {
        echo "<p>Your cart is empty. Unable to proceed with checkout.</p>";
    }
}
?>

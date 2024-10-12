<?php
session_start();

// Clear the cart session
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']); // Clear the cart
    echo json_encode(array('success' => true)); // Send success response
} else {
    echo json_encode(array('success' => false)); // Error response
}

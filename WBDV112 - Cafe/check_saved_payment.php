<?php
session_start();
include('db_connection.php'); // Include your DB connection file

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Query to check if the user has a saved payment method
    $query = "SELECT saved_payment FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($saved_payment);
    $stmt->fetch();
    $stmt->close();

    // Check if saved_payment is not empty
    if (!empty($saved_payment)) {
        echo json_encode(array('saved_payment' => true)); // Older PHP: Use array()
    } else {
        echo json_encode(array('saved_payment' => false)); // Older PHP: Use array()
    }
}
?>

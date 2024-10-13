<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db_connection.php'); // Include your database connection file

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        // If there is a SQL error, display it for debugging purposes
        echo json_encode(array('success' => false, 'error' => 'SQL error: ' . $conn->error)); // Use array() for older PHP versions
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, you can implement logic to send the reset link here

        echo json_encode(array('success' => true)); // Use array() for older PHP versions
    } else {
        // Email not found
        echo json_encode(array('success' => false, 'error' => 'Email is not registered on our website. Please re-check if there are any typographical errors.')); // Use array() for older PHP versions
    }

    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'error' => 'No email provided')); // Use array() for older PHP versions
}
$conn->close();
?>

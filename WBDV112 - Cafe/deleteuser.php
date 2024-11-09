<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['user_id'];

if ($stmt = $conn->prepare("DELETE FROM users WHERE id = ?")) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting account. Please try again.";
    }

    $stmt->close();
} else {
    echo "Error preparing statement. Please try again.";
}

$conn->close();
?>
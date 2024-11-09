<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "cafe_solstice";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID and status from URL
$user_id = $_GET['id'];
$status = $_GET['status'];

// Validate status
$valid_statuses = array('active', 'pending', 'deactivated');
if (!in_array($status, $valid_statuses)) {
    echo "Invalid status.";
    exit;
}

// Update user status
$sql = "UPDATE users SET account_status='$status' WHERE id='$user_id'";
if ($conn->query($sql) === TRUE) {
    header('Location: usersadmin.php'); // Redirect back to usersadmin.php
    exit;
} else {
    echo "Error updating status: " . $conn->error;
}

$conn->close();
?>

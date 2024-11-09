<?php
// Database connection details
$host = 'localhost'; // Your database host
$dbname = 'cafe_solstice'; // Your database name
$username = 'root'; // Your database username (default for WAMP is 'root')
$password = ''; // Your database password (default for WAMP is no password)

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

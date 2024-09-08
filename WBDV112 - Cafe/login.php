<?php
// Database configuration
$servername = "localhost"; // Change if your database server is different
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "cafe_solstice"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$login = $_POST['login']; // Can be either username or email
$password = $_POST['password'];

// Determine if login is email or username
if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
    // Login is an email
    $sql = "SELECT id, username, email, password FROM users WHERE email=?";
} else {
    // Login is a username
    $sql = "SELECT id, username, email, password FROM users WHERE username=?";
}

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $login);
$stmt->execute();

// Bind result variables
$stmt->bind_result($id, $db_username, $db_email, $db_password);

// Fetch the result
if ($stmt->fetch()) {
    // Verify the password
    if (md5($password, $db_password)) {
        echo "Login successful!";
        // Redirect to a different page or create a session
        header("Location: welcome.php"); // Redirect to a welcome page
        exit(); // Make sure to stop further execution
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username or email.";
}

// Close connection
$stmt->close();
$conn->close();
?>

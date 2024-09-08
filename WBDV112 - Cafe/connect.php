<?php
// Database connection settings
$servername = "localhost"; // Typically 'localhost', adjust if necessary
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password
$dbname = "cafe_solstice"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL query
$sql = "SELECT * FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists and verify password
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo "Login successful!";
        // Redirect to a different page or create a session
        header("Location: welcome.php"); // Redirect to a welcome page
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that email address.";
}

// Close connection
$stmt->close();
$conn->close();
?>
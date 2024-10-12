<?php
// Database connection details
$servername = "localhost";
$dbusername = "root";  // Assuming you're using 'root' as the default username for MySQL
$dbpassword = "";      // Assuming there's no password set for your local MySQL setup
$dbname = "cafe_solstice";

// Connect to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the registration form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $saved_payment = $_POST['payment']; // Validate as 16-digit card number
    $password = md5($_POST['password']);  // Use md5() for older PHP versions (less secure)

    // Check if the username or email already exists
    $checkUser = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email already taken!'); window.location.href='register.php';</script>";
    } else {
        // Insert the user into the database
        $sql = "INSERT INTO users (first_name, last_name, username, email, address, saved_payment, password) 
                VALUES ('$first_name', '$last_name', '$username', '$email', '$address', '$saved_payment', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='index.php';</script>";  // Redirect after success
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

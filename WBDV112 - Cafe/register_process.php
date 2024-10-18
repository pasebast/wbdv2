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
$sql = "INSERT INTO users (first_name, last_name, username, email, address, saved_payment, password, account_status) 
        VALUES ('$first_name', '$last_name', '$username', '$email', '$address', '$saved_payment', '$password', 'Pending')";



// After successfully inserting the user into the users table
if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id; // Get the ID of the newly registered user
    $verification_token = md5(uniqid(rand(), true)); // Generate a unique token
    $expires = date("Y-m-d H:i:s", strtotime('+1 day')); // Set expiration date

    // Insert into email_verifications table
    $insert_verification = "INSERT INTO email_verifications (user_id, token, expires_at) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_verification);

    if ($stmt === false) {
        die("Failed to prepare statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("iss", $user_id, $verification_token, $expires);
    $stmt->execute();
    $stmt->close();

    // Prepare verification email
    $verification_link = "http://localhost/WBDV112%20-%20Cafe/verify_email.php?token=" . $verification_token;


// Include PHPMailer classes
require 'src/PHPMailerAutoload.php'; // Ensure this path is correct

$mail = new PHPMailer(); // Create a new PHPMailer instance

// Set up PHPMailer
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'forgot.cafesolstice@gmail.com'; // Your email
$mail->Password   = 'llsyciobozilppwy'; // Your app password
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;

// Set email format to HTML
$mail->isHTML(true);

// Set up PHPMailer or your preferred mail method to send the email
$mail->setFrom('forgot.cafesolstice@gmail.com', 'Cafe Solstice Admin');
$mail->addAddress($email);
$mail->Subject = 'Email Verification';
$mail->Body = "Please verify your email by clicking the following link: <a href='$verification_link'>Verify Email</a>";

if(!$mail->send()) {
    echo 'Email could not be sent.';
    // Handle error accordingly
} else {
    echo "<script>alert('Registration successful! Please check your email to verify your account.'); window.location.href='index.php';</script>";  // Redirect after success
}


    }
	}
}

$conn->close();
?>

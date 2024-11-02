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
date_default_timezone_set('Asia/Manila'); // Set to your local time zone

// Process the registration form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $cellphone_number = $_POST['cellphone_number']; // Add cellphone number
    $saved_payment = $_POST['payment']; // Validate as 16-digit card number
    $expiry_date = $_POST['expiry_date']; // Assuming this is passed from the form as MM/YY
    $cvc = $_POST['cvc']; // Assuming this is passed from the form
    $password = md5($_POST['password']);  // Use md5() for older PHP versions (less secure)

    // Validate and convert MM/YY to YYYY-MM-DD if the add payment checkbox is checked
    $add_payment = isset($_POST['add_payment']) ? true : false;
    if ($add_payment) {
        $date_regex = "/^\d{2}\/\d{2}$/"; // MM/YY format
        if (!preg_match($date_regex, $expiry_date)) {
            header("Location: register.php?error=Invalid date format! Please enter as MM/YY.");
            exit();
        } else {
            list($month, $year) = explode('/', $expiry_date);
            $year = ($year > 50 ? '19' : '20') . $year; // Handle 2-digit year appropriately
            $expiry_date_sql = "$year-$month-01"; // Default to the first day of the month
        }
    }

    // Check if the username or email already exists
    $checkUser = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($checkUser);
    if ($result->num_rows > 0) {
        header("Location: register.php?error=Username or Email already taken!");
        exit();
    } else {
        // Prepare SQL query
        $sql = "INSERT INTO users (first_name, last_name, username, email, address, cellphone_number, saved_payment, password, account_status, role";
        $sql_values = "VALUES ('$first_name', '$last_name', '$username', '$email', '$address', '$cellphone_number', '$saved_payment', '$password', 'Pending', 'member'";

        if ($add_payment) {
            $sql .= ", expiry_date, cvc";
            $sql_values .= ", '$expiry_date_sql', '$cvc'";
        }

        $sql .= ") " . $sql_values . ")";
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
                header("Location: index.php?success=Registration successful! Please check your email to verify your account.");
                exit();
            }
        }
    }
}

$conn->close();
?>

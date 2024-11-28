<?php
session_start();
include('db_connection.php');

// Include PHPMailer for older PHP versions
require 'src/PHPMailerAutoload.php'; // PHPMailer 5.2 uses this file to load

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, generate a reset token and expiration
        $token = md5(uniqid(rand(), true)); // Compatible with older PHP versions
        $expires = date("Y-m-d H:i:s", strtotime('+1 day')); // Correct way to set expiry date


        // Store the token and expiration in the database
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        // Insert or update the password reset token in the database
        $insert_query = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)
                         ON DUPLICATE KEY UPDATE token=?, expires_at=?";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("issss", $user_id, $token, $expires, $token, $expires);
        $insert_stmt->execute();
        $insert_stmt->close();

        // Set up the reset link
        $reset_link = "https://certain-lovely-monkfish.ngrok-free.app/WBDV112%20-%20Cafe/reset_password.php?token=" . $token;

        // Set up PHPMailer
        $mail = new PHPMailer();


        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'forgot.cafesolstice@gmail.com'; 
            $mail->Password   = 'llsyciobozilppwy';  
            $mail->SMTPSecure = 'tls'; 
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('forgot.cafesolstice@gmail.com', 'Cafe Solstice Admin');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = 'Click here to reset your password: <a href="' . $reset_link . '">Reset Password</a>';

            // Send the email
            $mail->send();
            echo json_encode(array('success' => true)); // Old array syntax
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'error' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo)); // Send error response
        }
    } else {
        echo json_encode(array('success' => false, 'error' => 'Email not found.')); // Old array syntax
    }
} else {
    echo json_encode(array('success' => false, 'error' => 'No email provided.')); // Old array syntax
}
?>
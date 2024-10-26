<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['error'] = 'All fields are required!';
        header("Location: contact.php");
        exit();
    }

    // Include PHPMailer classes
    require 'src/PHPMailerAutoload.php'; // Ensure this path is correct
    $mail = new PHPMailer();

    // Set up PHPMailer
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'forgot.cafesolstice@gmail.com'; // Your email
    $mail->Password   = 'llsyciobozilppwy'; // Your app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email content
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress('forgot.cafesolstice@gmail.com'); // Your email address
    $mail->Subject = "New Contact Form Submission: $subject";
    $mail->Body = "<p>You have received a new message from the contact form on your website.</p>
                   <p><strong>Name:</strong> $name</p>
                   <p><strong>Email:</strong> $email</p>
                   <p><strong>Subject:</strong> $subject</p>
                   <p><strong>Message:</strong><br>$message</p>";

    // Send the email
    if ($mail->send()) {
        $_SESSION['success'] = 'Your message has been successfully sent!';
    } else {
        $_SESSION['error'] = 'There was an error sending your message. Please try again.';
    }

    header("Location: contact.php");
    exit();
} else {
    header("Location: contact.php");
    exit();
}
?>

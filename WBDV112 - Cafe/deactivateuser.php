<?php
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
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

$user_id = $_SESSION['user_id'];
$sql_user = "SELECT username, email FROM users WHERE id=?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($username, $email);
$stmt_user->fetch();
$stmt_user->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = $_POST['reason'];
    $message = $_POST['message'];

    // Update account status to Deactivated
    $sql_update_status = "UPDATE users SET account_status='Deactivated' WHERE id=?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    if (!$stmt_update_status) {
        die("Failed to prepare statement: " . htmlspecialchars($conn->error));
    }
    $stmt_update_status->bind_param("i", $user_id);

    if ($stmt_update_status->execute()) {
        // Insert the deactivation request into the database
        $sql = "INSERT INTO deactivation_requests (username, email, reason, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Failed to prepare statement: " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("ssss", $username, $email, $reason, $message);
        $stmt->execute();
        $stmt->close();

        // Send email using PHPMailer
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
        $mail->setFrom('forgot.cafesolstice@gmail.com', 'Café Solstice');
        $mail->addAddress('forgot.cafesolstice@gmail.com'); // Your email address
        $mail->Subject = "Account Deactivation Request";
        $mail->Body = "<p>A user has requested to deactivate their account.</p>
                       <p><strong>Username:</strong> $username</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Reason:</strong> $reason</p>
                       <p><strong>Message:</strong><br>$message</p>";

        if ($mail->send()) {
            $_SESSION['success'] = "Your account has been deactivated.";
			// Log out the user and redirect to the home page
			session_destroy();
			header("Location: index.php?status=deactivated");
			exit();
        } else {
            $_SESSION['error'] = "There was an error processing your request. Please try again.";
        }
    } else {
        $_SESSION['error'] = "There was an error updating your account status. Please try again.";
    }

    $stmt_update_status->close();
    header("Location: profile.php");
    exit();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deactivate Account - Café Solstice</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your main CSS file -->
	<link rel="icon" type="image/png" href="images/logo01.png">
    <style>
        .deactivate-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .deactivate-container h2 {
            text-align: center;
            color: #333;
        }
        .deactivate-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .deactivate-container select,
        .deactivate-container textarea,
        .deactivate-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .deactivate-container textarea {
            resize: vertical;
            height: 100px;
        }
        .deactivate-container button {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .deactivate-container button:hover {
            background-color: #d32f2f;
        }
		
		.profile-back-button a {
			background-color: #f8a21c;
			color: white;
			padding: 10px 20px;
			text-decoration: none;
			border-radius: 5px;
			font-weight: bold;
			display: inline-block;
			margin-top: 10px;
		}

		.profile-back-button a:hover {
			background-color: #d9534f;
			color: white;
		}
		
		/* Deactivation Modal Styling */
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0, 0, 0, 0.5);
		}

		.modal-content {
			background-color: #fff;
			margin: 15% auto;
			padding: 20px;
			border: 1px solid #ccc;
			border-radius: 10px;
			width: 80%;
		}

		.close {
			color: #aaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.close:hover,
		.close:focus {
			color: black;
			text-decoration: none;
			cursor: pointer;
		}

    </style>
</head>
<body>
<!-- Background Image -->
<img src="images/coffee02.jpg" alt="Coffee Background" class="background-image">

    <body>
    <div class="deactivate-container">
        <h2>Deactivate Account</h2>
        <form action="deactivateuser.php" method="POST" onsubmit="return showDeactivateModal(event);">
            <label for="reason">Reason for Deactivation:</label>
            <select id="reason" name="reason" required>
                <option value="Privacy Concerns">Privacy Concerns</option>
                <option value="Not Satisfied with Service">Not Satisfied with Service</option>
                <option value="Switching to a Competitor">Switching to a Competitor</option>
                <option value="Other">Other</option>
            </select>

            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Please provide any additional details..." required></textarea>

            <button type="submit">Submit Deactivation Request</button>
        </form>
        <div class="profile-back-button">
            <a href="profile.php">Back to Profile</a>
        </div>

        <!-- Modal for Deactivation Confirmation -->
        <div id="deactivateModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Are you sure you want to deactivate your account?</p>
                <button id="confirmDeactivate" class="btnn">Yes</button>
                <button id="cancelDeactivate" class="btnn">No</button>
            </div>
        </div>
    </div>



<!-- Modal for Deactivation Confirmation -->
<div id="deactivateModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Are you sure you want to deactivate your account?</p>
        <button id="confirmDeactivate" class="btnn">Yes</button>
        <button id="cancelDeactivate" class="btnn">No</button>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; text-align: center;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="loader"></div>
        <p style="color: white;">Loading...</p>
    </div>
</div>


    </div>


<script>

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById("deactivateModal");
    var confirmBtn = document.getElementById("confirmDeactivate");
    var cancelBtn = document.getElementById("cancelDeactivate");
    var loadingSpinner = document.getElementById("loadingSpinner");

    // Get the form and the submit button
    var form = document.querySelector("form");
    var submitBtn = form.querySelector("button[type='submit']");

    // When the user clicks the submit button, open the modal
    submitBtn.addEventListener('click', function (event) {
        event.preventDefault();
        modal.style.display = "block";
    });

    // When the user clicks on <span> (x) or the No button, close the modal
    cancelBtn.addEventListener('click', function () {
        modal.style.display = "none";
    });

    // When the user clicks Yes, show the loading spinner and submit the form
    confirmBtn.addEventListener('click', function () {
        loadingSpinner.style.display = "block";
        form.submit();
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

function showDeactivateModal(event) {
    event.preventDefault(); // Prevent the form from submitting immediately
    var modal = document.getElementById("deactivateModal");
    modal.style.display = "block";
}




</script>
	
</body>
</html>

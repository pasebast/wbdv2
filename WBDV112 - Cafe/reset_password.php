<?php
session_start();
include('db_connection.php');

// Check if the token is valid
if (!isset($_GET['token'])) {
    header('Location: index.php');
    exit();
}

$token = $_GET['token'];

// Check if the token exists in the database
$query = "SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "Invalid or expired token.";
    exit();
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new password from the form
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the new password
    if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[a-z]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
        $error_message = "Password must be at least 8 characters long, include at least 1 uppercase letter, 1 lowercase letter, and 1 number.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        // Hash the password using md5
        $hashed_password = md5($new_password);

        // Update the user's password in the database
        $update_query = "UPDATE users SET password = ? WHERE id = (SELECT user_id FROM password_resets WHERE token = ?)";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ss", $hashed_password, $token);
        if ($update_stmt->execute()) {
            // Successfully updated password, delete the token
            $delete_query = "DELETE FROM password_resets WHERE token = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("s", $token);
            $delete_stmt->execute();
            $delete_stmt->close();

            // Show success message
            $success_message = "Your password has been reset successfully! You can now <a href='index.php'>login</a>.";
        } else {
            $error_message = "Failed to update password.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Café Solstice</title>
    <link rel="stylesheet" href="sty.css">
    <style>
        /* Reset Password Container */
        .reset-password-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 2px solid #964B00;
            border-radius: 10px;
            background-color: #fff4e6;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .reset-password-container h2 {
            color: #964B00;
            text-align: center;
        }

        .reset-password-container label {
            display: block;
            margin-top: 10px;
        }

        .reset-password-container input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .reset-password-container button {
            margin-top: 15px;
            padding: 10px;
            background-color: #964B00;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .reset-password-container button:hover {
            background-color: #7a3e1c;
        }

        .back-to-login {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #964B00;
        }

        .error-message {
            color: red;
            text-align: center;
        }

        .success-message {
            color: green;
            text-align: center;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
        }
        .modal-content {
            background-color: #fff4e6;
            margin: 15% auto;
            padding: 20px;
            border: 2px solid #964B00;
            border-radius: 10px;
            width: 70%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
		
		
        .modal-header {
    display: flex;
    justify-content: space-between; /* Align items on opposite sides */
    align-items: center; /* Center items vertically */
}

.close-btn {
    color: #fff;
    background-color: #964B00;
    padding: 10px 15px; /* Add horizontal padding for better click area */
    text-decoration: none;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    border: none; /* Remove border for better aesthetics */
}

        .close-btn:hover {
            background-color: #7a3e1c;
        }
    </style>
</head>
<body>

<div class="reset-password-container">
    <h2>Reset Password</h2>
    
    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
    <?php elseif (!empty($success_message)): ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php else: ?>
        <form action="" method="POST" onsubmit="return validatePasswords()">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Reset Password</button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="back-to-login">Back to Login</a>
</div>

<!-- Modal for error messages -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Error</h2> <!-- You can set this dynamically -->
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
        <div id="modalBody"></div>
    </div>
</div>


<script>
function closeModal() {
    document.getElementById('myModal').style.display = 'none';
}

function validatePasswords() {
    var newPassword = document.getElementById('new_password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var modalBody = document.getElementById('modalBody');

    if (newPassword.length < 8 || !/[A-Z]/.test(newPassword) || !/[a-z]/.test(newPassword) || !/[0-9]/.test(newPassword)) {
        modalBody.innerHTML = "Password must be at least 8 characters long, include at least 1 uppercase letter, 1 lowercase letter, and 1 number.";
        document.getElementById('myModal').style.display = 'block';
        return false; // Prevent form submission
    } 
    else if (newPassword !== confirmPassword) {
        modalBody.innerHTML = "Passwords do not match. Please try again.";
        document.getElementById('myModal').style.display = 'block';
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>

</body>
</html>
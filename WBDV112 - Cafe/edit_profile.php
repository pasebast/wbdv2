<?php
session_start();

// Start output buffering to avoid "headers already sent" issues
ob_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit;
}

// Database connection
$servername = "localhost";
$dbusername = "root";  // Your database username
$dbpassword = "";      // Your database password
$dbname = "cafe_solstice";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user's data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $saved_payment = $_POST['saved_payment'];

    // Check if the username is already taken by another user
    $check_username = "SELECT id FROM users WHERE username='$username' AND id != '$user_id'";
    $username_result = $conn->query($check_username);

    // Check if the email is already taken by another user
    $check_email = "SELECT id FROM users WHERE email='$email' AND id != '$user_id'";
    $email_result = $conn->query($check_email);

    // Generate specific error messages
    if ($username_result->num_rows > 0) {
        $error = "The username '" . htmlspecialchars($username) . "' is already taken. Please choose another one.";
    } elseif ($email_result->num_rows > 0) {
        $error = "The email '" . htmlspecialchars($email) . "' is already in use by another account.";
    } else {
        // Handle profile picture upload
        $profile_picture = $user['profile_picture'];  // Keep the old picture if no new one is uploaded
        $target_dir = "uploads/";

        // Check if user wants to remove the profile picture
        if (isset($_POST['remove_picture']) && $_POST['remove_picture'] == '1') {
            // Delete the current picture if it exists and is not the default
            if (!empty($user['profile_picture']) && file_exists($target_dir . $user['profile_picture'])) {
                unlink($target_dir . $user['profile_picture']); // Delete the file
            }
            $profile_picture = NULL; // Reset the profile picture to NULL or a default value
        }

        // If a new profile picture is uploaded and the remove picture is NOT checked, process the upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
            $file_extension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
            $file_type = $_FILES['profile_picture']['type'];

            if (in_array($file_type, $allowed_types) && in_array($file_extension, $allowed_extensions)) {
                $new_file_name = time() . "_" . basename($_FILES['profile_picture']['name']); // Add timestamp to avoid overwriting
                $target_file = $target_dir . $new_file_name;

                // Move the uploaded file to the uploads directory
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                    // Delete the old picture if it's being replaced
                    if (!empty($user['profile_picture']) && file_exists($target_dir . $user['profile_picture'])) {
                        unlink($target_dir . $user['profile_picture']); // Delete the old picture
                    }
                    $profile_picture = $new_file_name; // Save the new file name
                } else {
                    $error = "Error moving uploaded file.";
                }
            } else {
                $error = "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            }
        }

        // Only proceed if there are no errors
        if (empty($error)) {
            // Update user details, including the profile picture
            $sql = "UPDATE users SET username='$username', first_name='$first_name', last_name='$last_name', email='$email', address='$address', saved_payment='$saved_payment', profile_picture='$profile_picture' WHERE id='$user_id'";
            if ($conn->query($sql) === TRUE) {
                header('Location: profile.php');
                exit;
            } else {
                $error = "Error updating profile: " . $conn->error;
            }
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
    <title>Edit Profile - Café Solstice</title>
    <link rel="stylesheet" href="sty.css">
</head>
<body>
<!-- Background Image -->
<img src="images/coffee02.jpg" alt="Coffee Background" class="background-image">

<div class="edit-profile-container">
    <h2>Edit Profile</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

        <label for="saved_payment">Saved Payment Method:</label>
        <input type="text" name="saved_payment" value="<?php echo htmlspecialchars($user['saved_payment']); ?>" placeholder="Enter card number">

        <label for="profile_picture">Upload Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*">

        <label>
            <input type="checkbox" name="remove_picture" value="1">
            Remove Profile Picture
        </label>

        <button type="submit" class="edit-btn">Save Changes</button>
    </form>
</div>

</body>
</html>

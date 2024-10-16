<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore_db";

// Create connection using old mysql functions
$conn = mysql_connect($host, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

mysql_select_db($dbname, $conn);

// Initialize variables
$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
$lastname = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';
$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
$phone_number = isset($_SESSION['phone_number']) ? $_SESSION['phone_number'] : '';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = mysql_real_escape_string($_POST['firstname']);
    $lastname = mysql_real_escape_string($_POST['lastname']);
    $gender = mysql_real_escape_string($_POST['gender']);
    $phone_number = mysql_real_escape_string($_POST['phone_number']);
    $address = mysql_real_escape_string($_POST['address']);
    
    // File upload logic for PHP 5.2.1
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = mysql_real_escape_string($_FILES["profile_picture"]["name"]);
        } else {
            echo "Failed to upload file.";
        }
    }

    // Remove profile picture if the checkbox is selected
    if (isset($_POST['remove_picture']) && $_POST['remove_picture'] == 'on') {
        $profile_picture = '';  // Set profile picture to empty string
    }

    // Update user details in the database
    $user_id = $_SESSION['user_id'];
    
    if ($profile_picture !== '') {
        // If there is a profile picture (including if it's been updated)
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', gender='$gender', phone_number='$phone_number', address='$address', profile_picture='$profile_picture' WHERE id='$user_id'";
    } else {
        // If no profile picture or it's been removed
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', gender='$gender', phone_number='$phone_number', address='$address', profile_picture=NULL WHERE id='$user_id'";
    }

    $result = mysql_query($sql, $conn);
    
    if ($result) {
        // Update session variables
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['gender'] = $gender;
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['address'] = $address;
        $_SESSION['profile_picture'] = $profile_picture;  // Set profile picture in session

        // If picture removed, unset session variable
        if ($profile_picture === '') {
            unset($_SESSION['profile_picture']);
        }
        
        // Redirect to the profile page after successful update
        header("Location: profile.php");
        exit;
    } else {
        echo "Error updating record: " . mysql_error();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f4f0e6;
            background-image: url('https://64.media.tumblr.com/c25d3b2f64c96184584b831fba6bb0e2/tumblr_oyfsbzUOey1r9co7bo1_1280.gifv');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: rgba(74, 60, 49, 0.7);
            backdrop-filter: blur(10px);
            color: white;
            padding: 10px 0;
            display: flex;
            align-items: center;
            height: 80px;
            width: 100%;
            box-sizing: border-box;
        }
        header h3 {
            font-family: 'Georgia', serif;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            flex-grow: 0.155;
            letter-spacing: 0.5px;
        }
        .profile-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            text-align: center;
            margin: 20px auto;
        }
        .profile-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #4a3c31;
        }
        .profile-container form {
            display: flex;
            flex-direction: column;
        }
        .profile-container input, .profile-container select, .profile-container textarea {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .edit-button {
            background-color: #6b5446;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
        }
        .edit-button:hover {
            background-color: #4a3c31;
        }
        footer {
            background-color: #4a3c31;
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: auto;
        }
        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h3>UPLIFT BOOKSTORE - Edit Profile</h3>
    </header>

    <div class="profile-container">
        <h2>Edit Your Profile</h2>
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>">

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>">

            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <label for="phone_number">Contact Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">

            <label for="address">Address:</label>
            <textarea id="address" name="address"><?php echo htmlspecialchars($address); ?></textarea>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture">

            <input type="checkbox" id="remove_picture" name="remove_picture">
            <label for="remove_picture">Remove Profile Picture</label>

            <input type="submit" value="Save Changes" class="edit-button">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 UPLIFT BOOKSTORE. All Rights Reserved.</p>
    </footer>
</body>
</html>

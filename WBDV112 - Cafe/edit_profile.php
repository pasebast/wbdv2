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
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : NULL;
    $cvc = $_POST['cvc'];

    // Convert MM/YY to YYYY-MM-DD for SQL
    $expiry_date_sql = NULL;
    if (!is_null($expiry_date)) {
        $expiry_parts = explode('/', $expiry_date);
        if (count($expiry_parts) === 2) {
            $month = intval($expiry_parts[0]);
            $year = intval($expiry_parts[1]) + 2000; // Add 2000 to get full year (e.g., 23 becomes 2023)
            $expiry_date_sql = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01'; // Set day to 01
        }
    }

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
            // Update user details, including the profile picture, expiry date, and CVC
            $sql = "UPDATE users SET username='$username', first_name='$first_name', last_name='$last_name', email='$email', address='$address', saved_payment='$saved_payment', expiry_date=" . ($expiry_date_sql ? "'$expiry_date_sql'" : "NULL") . ", cvc='$cvc', profile_picture='$profile_picture' WHERE id='$user_id'";
            if ($conn->query($sql) === TRUE) {
                header('Location: profile.php');
                exit;
            } else {
                $error = "Error updating profile: " . $conn->error;
            }
        }
    }
}
// Convert YYYY-MM-DD to MM/YY for display
if (!empty($user['expiry_date'])) {
    $expiry_date_parts = explode('-', $user['expiry_date']);
    if (count($expiry_date_parts) === 3) {
        $user['expiry_date'] = str_pad($expiry_date_parts[1], 2, '0', STR_PAD_LEFT) . '/' . substr($expiry_date_parts[0], -2);
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
	

<style>
/* Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background: linear-gradient(
        to top,
        rgba(255, 223, 186, 0.9),
        rgba(248, 233, 220, 0.9)
    );
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 2px solid #964B00;
    width: 80%; /* Could be more or less, depending on screen size */
    border-radius: 25px; /* Match form's border-radius */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* The Close Button */
.close {
    color: #964B00;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #ff7200;
    text-decoration: none;
    cursor: pointer;
}

/* Modal Buttons */
.modal-btn {
    padding: 10px 20px;
    margin: 10px;
    border-radius: 10px; /* Match button's border-radius */
    border: none;
    cursor: pointer;
    font-size: 18px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
    transition: background-color 0.3s ease;
}

/* Yes Button */
#confirmBtn {
    background-color: #964B00;
    color: #FFFFFF;
}

#confirmBtn:hover {
    background-color: #ff7200;
    color: #fff;
}

/* No Button */
#cancelBtn {
    background-color: #FFFFFF;
    color: #964B00;
}

#cancelBtn:hover {
    background-color: #ff7200;
    color: #fff;
}

</style>

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
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required pattern="^[a-zA-Z.]{2,50}$" title="First Name should be 2-50 characters long and can only contain letters, and periods.">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required pattern="^[a-zA-Z.]{2,50}$" title="Last Name should be 2-50 characters long and can only contain letters, and periods.">

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

        <label for="saved_payment">Card Number:</label>
        <input type="text" id="saved_payment" name="saved_payment" value="<?php echo htmlspecialchars($user['saved_payment']); ?>" placeholder="____-____-____-____" required pattern="\d{4}-\d{4}-\d{4}-\d{4}" title="Please enter a valid card number format." maxlength="19" oninput="formatCardNumber(this)">
		
		<label for="expiry_date">Expiry Date (MM/YY):</label>
		<input type="text" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($user['expiry_date']); ?>" placeholder="MM/YY" required pattern="^(0[1-9]|1[0-2])\/?([0-9]{2})$" title="Please enter a valid expiry date in MM/YY format." maxlength="5" oninput="formatExpiryDate(this)" onblur="validateExpiryDate(this)">

		<label for="cvc">CVC:</label>
		<input type="text" id="cvc" name="cvc" value="<?php echo htmlspecialchars($user['cvc']); ?>" placeholder="CVC" required maxlength="3" pattern="^\d{3}$" title="Please enter a valid 3-digit CVC code." oninput="this.value = this.value.replace(/\D/g, '').slice(0, 3);">


        <label for="profile_picture">Upload Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*">

        <label>
            <input type="checkbox" name="remove_picture" value="1">
            Remove Profile Picture
        </label>

       <!-- Modal HTML -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Are you sure you want to save these changes?</p>
        <button id="confirmBtn" class="modal-btn">Yes</button>
        <button id="cancelBtn" class="modal-btn" type="button">No</button>
    </div>
</div>

<!-- Existing form submission button -->
<button type="button" class="edit-btn" onclick="checkChanges()">Save Changes</button>


<!-- Error Modal -->
<div id="errorModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="errorMessage"></p>
    </div>
</div>


    </form>
	<a href="profile.php" class="back-btn">Back to Profile</a>



</div>

<script>
function showModal(message) {
    var modal = document.getElementById('errorModal');
    var span = document.getElementsByClassName('close')[0];
    var errorMessage = document.getElementById('errorMessage');

    errorMessage.innerText = message;
    modal.style.display = 'block';

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
}

function formatExpiryDate(input) {
    // Remove all non-digit characters
    const value = input.value.replace(/\D/g, '');

    // Format the value as MM/YY
    const formattedValue = value.replace(/(\d{2})(\d+)/, '$1/$2');

    // Set the formatted value back to the input
    input.value = formattedValue;
}

function validateExpiryDate(input) {
    const value = input.value;
    if (value) {
        const parts = value.split('/');
        const month = parseInt(parts[0], 10);
        const year = parseInt(parts[1], 10) + 2000; // Convert YY to YYYY

        // Get the current date
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth() + 1; // Months are zero-indexed

        // Check if the card is expired
        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            alert('The card has expired. Please enter a valid expiry date.');
            input.value = ''; // Clear the input field
        }
    }
}



function formatCardNumber(input) {
    // Remove all non-digit characters
    const value = input.value.replace(/\D/g, '');

    // Format the value as XXXX-XXXX-XXXX-XXXX
    const formattedValue = value.replace(/(\d{4})(?=\d)/g, '$1-');

    // Set the formatted value back to the input
    input.value = formattedValue;
}

</script>


<script>
const initialData = {
    username: "<?php echo htmlspecialchars($user['username']); ?>",
    first_name: "<?php echo htmlspecialchars($user['first_name']); ?>",
    last_name: "<?php echo htmlspecialchars($user['last_name']); ?>",
    email: "<?php echo htmlspecialchars($user['email']); ?>",
    address: "<?php echo htmlspecialchars($user['address']); ?>",
    saved_payment: "<?php echo htmlspecialchars($user['saved_payment']); ?>",
    expiry_date: "<?php echo htmlspecialchars($user['expiry_date']); ?>",
    cvc: "<?php echo htmlspecialchars($user['cvc']); ?>"
};

function checkChanges() {
    if (!validateProfileForm()) {
        return;
    }

    const savedPayment = document.getElementById('saved_payment').value;
    const expiryDate = document.getElementById('expiry_date').value;
    const cvc = document.getElementById('cvc').value;

    // Validate card details
    if ((expiryDate || cvc) && !savedPayment) {
        showModal("Card number is required if expiry date or CVC is filled.");
        return;
    }
    if (savedPayment && (!expiryDate || !cvc)) {
        showModal("Expiry date and CVC are required if card number is filled.");
        return;
    }

    const currentData = {
        username: document.getElementsByName("username")[0].value,
        first_name: document.getElementsByName("first_name")[0].value,
        last_name: document.getElementsByName("last_name")[0].value,
        email: document.getElementsByName("email")[0].value,
        address: document.getElementsByName("address")[0].value,
        saved_payment: document.getElementsByName("saved_payment")[0].value,
        expiry_date: document.getElementsByName("expiry_date")[0].value,
        cvc: document.getElementsByName("cvc")[0].value
    };

    const changesMade = Object.keys(initialData).some(key => initialData[key] !== currentData[key]);
    if (changesMade) {
        document.getElementById('confirmationModal').style.display = "block";
    } else {
        document.getElementsByTagName('form')[0].submit();
    }
}




// Modal logic
const modal = document.getElementById("confirmationModal");
const span = document.getElementsByClassName("close")[0];
const confirmBtn = document.getElementById("confirmBtn");
const cancelBtn = document.getElementById("cancelBtn");

span.onclick = () => { modal.style.display = "none"; }
cancelBtn.onclick = () => { modal.style.display = "none"; }
confirmBtn.onclick = () => { document.getElementsByTagName('form')[0].submit(); }

window.onclick = (event) => {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function validateProfileForm() {
    var firstName = document.querySelector("[name='first_name']").value;
    var lastName = document.querySelector("[name='last_name']").value;

    var nameRegex = /^[a-zA-Z.]{2,50}$/;

    if (!nameRegex.test(firstName)) {
        showModal("Invalid First Name. It should be 2-50 characters long and can only contain letters, and periods.");
        return false;
    }

    if (!nameRegex.test(lastName)) {
        showModal("Invalid Last Name. It should be 2-50 characters long and can only contain letters, and periods.");
        return false;
    }

    return true;
}




</script>




 <!-- Include the footer -->
    <?php include('footer.php'); ?>
</body>
</html>

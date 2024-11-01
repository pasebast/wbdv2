<?php
session_start();

// Check if the user is logged in
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

// Get logged-in user's data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Mask saved payment method
$saved_payment = $user['saved_payment'];
if (!empty($saved_payment)) {
    $saved_payment_masked = str_repeat('*', strlen($saved_payment) - 4) . substr($saved_payment, -4);
} else {
    $saved_payment_masked = 'No payment method saved';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Café Solstice</title>
    <link rel="stylesheet" href="sty.css">
	<link rel="icon" type="image/png" href="images/logo01.png">
</head>
<body>

<!-- Background Image -->
<img src="images/coffee02.jpg" alt="Coffee Background" class="background-image">

<div class="navbar">
    <div class="icon">
        <img src="images/logo01.png" alt="Logo">
    </div>
    <div class="menu">
        <ul>
            <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="menu.php" class="<?php echo ($current_page == 'menu.php') ? 'active' : ''; ?>">Menu</a></li>
            <li><a href="gallery.php" class="<?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
            <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
            <li><a href="aboutus.php" class="<?php echo ($current_page == 'aboutus.php') ? 'active' : ''; ?>">About</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a></li>
            <?php else: ?>
                <li></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>



<div class="profile-container">
    <div class="profile-header">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <p>Your Profile</p>
    </div>

    <div class="profile-picture">
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" id="profileImg" style="cursor: pointer;">
        <?php else: ?>
            <img src="images/default-profile.png" alt="Default Profile Picture" id="profileImg" style="cursor: pointer;">
        <?php endif; ?>
    </div>

	<!-- Profile Details Grid -->
    <div class="profile-details-grid">
	 <!-- Left Side (Username, First Name, Last Name) -->
	 <div class="profile-left">
        <label>Username:</label>
        <p><?php echo htmlspecialchars($user['username']); ?></p>

        <label>First Name:</label>
        <p><?php echo htmlspecialchars($user['first_name']); ?></p>

        <label>Last Name:</label>
        <p><?php echo htmlspecialchars($user['last_name']); ?></p>
	</div>
	
	<!-- Right Side (Email, Address, Payment Method) -->
	<div class="profile-right">
        <label>Email:</label>
        <p><?php echo htmlspecialchars($user['email']); ?></p>

        <label>Address:</label>
        <p><?php echo htmlspecialchars($user['address']); ?></p>

        <label>Saved Payment Method:</label>
        <p><?php echo $saved_payment_masked; ?></p>
	</div>
    </div>

	   <!-- pol buttons -->
	<div class="profile-actions">
    <a href="orderhistory.php" class="order-history-button">Order History</a>
    <a href="edit_profile.php" class="edit-profile-button">Edit Profile</a>
    <a href="changepassword.php" class="change-password-button">Change Password</a> <!-- New Change Password link -->
    <a href="deactivateuser.php" class="deactivate-button">Deactivate Account</a>
</div>


</div>

<!-- Modal to show enlarged profile picture -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="imgModal">
    <div id="caption"></div>
</div>

<script>
// Modal functionality
var modal = document.getElementById("myModal");
var img = document.getElementById("profileImg");
var modalImg = document.getElementById("imgModal");
var captionText = document.getElementById("caption");

img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Close modal when 'x' is clicked
var span = document.getElementsByClassName("close")[0];
span.onclick = function() { 
    modal.style.display = "none";
}
</script>
 <!-- Include the footer -->
    <?php include('footer.php'); ?>

</body>
</html>

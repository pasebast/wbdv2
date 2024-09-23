<?php
// Start the session 
session_start();

// Simulate
$user = array(
    'username' => 'Username: pol_ng_pinas',
    'email' => 'Email: pol_ng_pinas@pharmacy.com',
    'full_name' => 'Name: Paul Sebastian',
    'bio' => 'Bio: "yanig ang banig"',
    'profile_picture' => 'images/profile01.png', // Replace 
	'address' => '123 Madilim Street, Dimakita City, NCR',
    'saved_payment' => 'Visa ending in 6969'
);

// If user is not logged in, redirect to login page
// if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
//    header('Location: login.php');
//    exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Café Solstice</title>
    <link rel="stylesheet" href="sty.css"> 
</head>
<body>
    <!-- Navbar Section -->
    <div class="navbar">
        <div class="icon">
            <img src="images/logo01.png" alt="Logo"> <!-- Use your existing logo filename -->
        </div>
        <div class="menu">
            <ul>
                <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                 <li><a href="menu.php" class="<?php echo ($current_page == 'menu.php') ? 'active' : ''; ?>">Menu</a></li>
                 <li><a href="gallery.php" class="<?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
                 <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                 <li><a href="aboutus.php" class="<?php echo ($current_page == 'aboutus.php') ? 'active' : ''; ?>">About</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

<!-- Profile Container -->
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-picture">
                <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h2><?php echo $user['full_name']; ?></h2>
                <p class="username"><?php echo $user['username']; ?></p>
                <p class="bio"><?php echo $user['bio']; ?></p>
            </div>
        </div>

        <!-- Additional Profile Details -->
        <div class="profile-details">
            <h3>Contact Information</h3>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Address: <?php echo $user['address']; ?></p>
            
            <h3>Saved Payment Method</h3>
            <p><?php echo $user['saved_payment']; ?></p>

            <button class="edit-btn">Edit Profile</button>
        </div>
		</div>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

    <!-- Footer Section -->
     <div class="footer">
           <?php include('footer.php'); ?>
    </div>
</body>
</html>

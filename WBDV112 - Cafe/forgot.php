<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="sty.css"> 
</head>
<body>
    <!-- Navbar Section -->
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
					
            </ul>
        </div>
    </div>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

    <!-- Main Content Section -->
    <div class="forgot-container">
        <div class="forgot-content">
            <!-- Forgot Password Form -->
            <div class="forgot-form">
                <h2>Forgot Your Password?</h2>
                <p>Enter your email address below and we'll send you instructions to reset your password.</p>
                <form action="forgot_process.php" method="POST">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" placeholder="Your Email Address" required>
                    <button type="submit" class="btnn">Send Reset Link</button>
                </form>
                <p class="back-to-login">Remembered your password? <a href="index.php">Back to Login</a></p>
            </div>
        </div>
    </div>

     <!-- Include the footer -->
    <?php include('footer.php'); ?>
	
</body>
</html>

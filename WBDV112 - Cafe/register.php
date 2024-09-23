<?php
// Initialize session and cart, etc.
session_start();


// Get the current page filename
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Café Solstice</title>
    <link rel="stylesheet" href="sty.css">
</head>
<body>

    <div class="main">
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

         <!-- Registration Section -->
        <div class="register-container">
            <!-- Welcome Message and Instructions -->
            <div class="intro">
                <h1>Welcome to Café Solstice !</h1>
                <p>We’re excited to have you join us. Please fill out the form below to create your account. Make sure to use a valid email address, as you’ll need it to activate your account.</p>
            </div>

            <!-- Flex Container for Content -->
            <div class="register-content">
                <!-- Additional Information Section -->
                <div class="register-info">
                    <h2>Why Register?</h2>
                    <p>Registering with us gives you access to exclusive content, personalized recommendations, and the ability to connect with our vibrant community. Don't miss out on the opportunity to stay updated with the latest news and events.</p>
                    <h2>Membership Benefits</h2>
                    <p>As a member, you’ll enjoy special discounts, early access to events, and the opportunity to participate in our forums and discussions. We value our community and strive to provide the best experience for our members.</p>
                    <h2>Need Help?</h2>
                    <p>If you have any questions or encounter any issues while registering, feel free to reach out to our support team at <a href="mailto:contact@cafesolstice.com">contact@cafesolstice.com</a>. We’re here to help!</p>
                </div>

                <!-- Registration Form Section -->
                <div class="register-form">
                    <form action="register_process.php" method="POST">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Choose a Username" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Your Email Address" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Create a Password" required>

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>

                        <button type="submit" class="btnn">Register</button>
                    </form>
                </div>
            </div>
			</div>
			
    </div>

<!-- Include the footer -->
    <?php include('footer.php'); ?>


</body>
</html>

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
                    <form action="register_process.php" method="POST" onsubmit="return validateForm()">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Choose a Username" required required pattern="^[a-zA-Z0-9_.]{4,36}$" title="Username should be 4-36 characters long and can only contain letters, numbers, periods, and underscores.">

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Your Email Address" required required pattern="^[a-zA-Z0-9_.@]{4,36}$" title="Email should be 4-36 characters long and can only contain letters, numbers, @, periods, and underscores.">

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Create a Password" required>

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>

						<label for="firstname">First Name:</label>
						<input type="text" id="firstname" name="firstname" placeholder="Your First Name" required>

						<label for="lastname">Last Name:</label>
						<input type="text" id="lastname" name="lastname" placeholder="Your Last Name" required>

						<label for="address">Address:</label>
						<input type="text" id="address" name="address" placeholder="Your Address" required>

						<label for="payment">Payment Method:</label>
						<input type="text" id="payment" name="payment" placeholder="Credit/Debit Card Number" required pattern="\d{16}" title="Enter a valid 16-digit card number.">

                        <button type="submit" class="btnn">Register</button>
						
						<script>
function validateForm() {
    var payment = document.getElementById("payment").value;
    var paymentPattern = /^\d{16}$/;
    if (!paymentPattern.test(payment)) {
        alert("Invalid card number. Please enter a valid 16-digit card number.");
        return false;
    }
    return true;
}
</script>



                    </form>
					<script>
function validateForm() {
    var username = document.getElementById("username").value;
    var regex = /^[a-zA-Z0-9_.]{4,36}$/; // Username should be 4-36 characters long and can contain letters, numbers, periods, and underscores
    if (!regex.test(username)) {
        alert("Invalid username. It should be 4-36 characters long and can only contain letters, numbers, periods, and underscores.");
        return false;
    }
    return true;
}
</script>
<script>
function validateForm() {
    var email = document.getElementById("email").value;
    var regex = /^[a-zA-Z0-9_.@]{4,36}$/; // Email should be 4-36 characters long and can contain letters, numbers, and underscores
    if (!regex.test(email)) {
        alert("Invalid email. It should be 4-36 characters long and can only contain letters, numbers, @, periods, and underscores.");
        return false;
    }
    return true;
}
</script>
                </div>
            </div>
			</div>
			
    </div>

<!-- Include the footer -->
    <?php include('footer.php'); ?>


</body>
</html>

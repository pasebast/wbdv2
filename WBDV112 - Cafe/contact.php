<?php
// Initialize session and cart, etc.
session_start();


// Get the current page filename
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Contact Us</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your external stylesheet -->
	
	
	<script>
        function showSuccessMessage() {
            // Display a success message when the form is submitted
            const messageBox = document.getElementById("success-message");
            messageBox.style.display = "block"; // Show the success message
            setTimeout(() => {
                messageBox.style.display = "none"; // Hide the message after 4 seconds
            }, 4000);
        }
		
		function showLoadingSpinner() {
    document.getElementById('loadingSpinner').style.display = 'block';
}

document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    if (status === 'success' || status === 'error') {
        document.getElementById('loadingSpinner').style.display = 'none';
    }
});

    </script>
    <style>
        /* Styling for the success and error messages */
#success-message, #error-message {
    display: block;
    padding: 15px;
    margin-top: 20px;
    text-align: center;
    border-radius: 5px;
    font-size: 16px;
}

#success-message {
    background-color: #4CAF50; /* Green color */
    color: white;
}

#error-message {
    background-color: #f44336; /* Red color */
    color: white;
}

    </style>
	
	
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
					
					<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php endif; ?>
					
                </ul>
            </div>
        </div>  
   
	
	

         <!-- Contact Section -->
        <div class="contact-container">
            <!-- Centered Heading for Contact Section -->
            <h2 class="contact-title">Get in Touch</h2>

            <!-- Flex Container for Content -->
            <div class="contact-content">
                <!-- Contact Information Section -->
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <p>We are here to help you with any inquiries or feedback. Feel free to reach out to us using the contact form or the information below. We value your thoughts and look forward to hearing from you!</p>
                    <p><strong>Email:</strong> contact@cafesolstice.com</p>
                    <p><strong>Phone:</strong> +123 456 7890</p>
                    <p><strong>Address:</strong> Tamaraw Hills, 120 MacArthur Highway, Valenzuela, Metro Manila</p>
                    
					<br></br>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

                    <!-- Additional Information -->
                    <h3>Why Reach Out to Us?</h3>
                    <p>At Café Solstice, we believe in creating a community where everyone feels welcome. Whether you have suggestions for improving our services, need information about our offerings, or simply want to say hello, we're here to listen. Your feedback helps us grow and provide the best experience possible.</p>
                    <h3>Our Commitment</h3>
                    <p>We strive to offer exceptional quality in every cup of coffee we serve. From our handpicked beans to our cozy ambiance, everything is designed to give you the best experience. Feel free to ask us anything about our process, our products, or our mission.</p>
                    <h3>Visit Us!</h3>
                    <p>Drop by and enjoy a relaxing time with your friends and family at Café Solstice. Whether you're looking for a quiet place to work, a casual meeting spot, or a place to unwind, our doors are always open to you.</p>
                </div>

							  <!-- Contact Form Section -->
<div class="contact-form">
    <form action="contact_process.php" method="POST" onsubmit="showLoadingSpinner()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Your Name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Your Email" required>
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" placeholder="Subject" required>
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" placeholder="Your Message" required></textarea>
        <button type="submit" class="btnn">Send Message</button>
    </form>

    <!-- Success and Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div id="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div id="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <!-- Loading Spinner -->
    <div id="loadingSpinner" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; text-align: center;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="loader"></div>
            <p style="color: white;">Loading...</p>
        </div>
    </div>
</div>



            </div>
        </div>

  
			
			
			
    </div>
	

    <?php include('footer.php'); ?>

</body>
</html>

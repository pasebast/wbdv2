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
    </script>
    <style>
        /* Styling for the success message */
        #success-message {
            display: none;
            padding: 15px;
            background-color: #4CAF50; /* Green color */
            color: white;
            margin-top: 20px;
            text-align: center;
            border-radius: 5px;
            font-size: 16px;
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
                    <form onsubmit="showSuccessMessage(); return false;">
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
					
					<!-- Success Message Box -->
                    <div id="success-message">Your message has been successfully received! We'll get back to you within 24-48 hours.
					</div>
					
                </div>
            </div>
        </div>

  
			
			
			
    </div>
	

    <?php include('footer.php'); ?>

</body>
</html>

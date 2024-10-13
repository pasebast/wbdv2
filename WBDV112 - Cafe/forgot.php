<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="sty.css"> 
	<style>
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff4e6;
            margin: 15% auto;
            padding: 20px;
            border: 2px solid #964B00;
            border-radius: 10px;
            width: 50%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #664228;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .modal-header {
            font-size: 20px;
            color: #964B00;
            margin-bottom: 10px;
        }

        .modal-body {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
        }

        .close-btn {
            padding: 10px 20px;
            background-color: #964B00;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: #7a3e1c;
        }
    </style>
</head>
<body>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

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

    <!-- Main Content Section -->
    <div class="forgot-container">
        <div class="forgot-content">
            <!-- Forgot Password Form -->
            <div class="forgot-form">
                <h2>Forgot Your Password?</h2>
                <p>Enter your email address below and we'll send you instructions to reset your password.</p>
                <form id="forgotForm" method="POST">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" placeholder="Your Email Address" required>
                    <button type="submit" class="btnn">Send Reset Link</button>
                </form>
                <p class="back-to-login">Remembered your password? <a href="index.php">Back to Login</a></p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="forgotModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader"></div>
            <div class="modal-body" id="modalBody"></div>
            <div class="modal-footer">
                <a class="close-btn" onclick="closeModal()">Close</a>
            </div>
        </div>
    </div>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>

    <script>
        function closeModal() {
            document.getElementById('forgotModal').style.display = 'none';
        }

        // Listen for form submission
        document.getElementById('forgotForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var email = document.getElementById('email').value;

    // Check if email is provided
    if (!email) {
        alert("Please enter your email address");
        return;
    }

    // AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'forgot_process.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText); // Attempt to parse JSON
                    var modalHeader = document.getElementById('modalHeader');
                    var modalBody = document.getElementById('modalBody');
                    var modal = document.getElementById('forgotModal');

                    if (response.success) {
                        modalHeader.innerHTML = 'Success';
                        modalBody.innerHTML = 'We have sent you a password reset link. It will expire in 24 hours. Please check your email, including your junk or spam folder.';
                    } else {
                        modalHeader.innerHTML = 'Error';
                        modalBody.innerHTML = response.error || 'The email address you entered is not registered. Please try again.';
                    }
                    
                    modal.style.display = 'block'; // Show the modal
                } catch (e) {
                    console.error("Invalid JSON response: ", xhr.responseText);
                    alert("An unexpected error occurred. Please try again.");
                }
            } else {
                console.error("AJAX error: " + xhr.status); // Handle non-200 HTTP responses
            }
        }
    };

    // Send the email via AJAX
    xhr.send('email=' + encodeURIComponent(email));
});

    </script>
	
	
</body>
</html>

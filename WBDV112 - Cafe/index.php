<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$dbusername = "root";  // Replace with your actual database username
$dbpassword = "";      // Replace with your actual database password
$dbname = "cafe_solstice";

// Connect to the database
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST['username']; // Can be username or email
    $password = md5($_POST['password']);   // Use md5() for older PHP versions to hash the input password

    // Query to check if user exists by username OR email and matching password
    $sql = "SELECT * FROM users WHERE (username='$usernameOrEmail' OR email='$usernameOrEmail') AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check account status
        if ($user['account_status'] === 'Active') {
            // Store user details in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['username'];  // Store username in session
            $_SESSION['logged_in'] = true;  // Set logged-in session flag
            header("Location: index.php");  // Redirect back to index.php
            exit();  // Ensure no further code is executed
        } elseif ($user['account_status'] === 'Pending') {
			$_SESSION['login_error'] = 'Your account is currently pending activation. Please check your email for the link. <a href="resend_activation.php?email=' . urlencode($user['email']) . '">Resend Activation Link</a>';
			
        } elseif ($user['account_status'] === 'Deactivated') {
            $_SESSION['login_error'] = 'Your account has been deactivated. Please contact support through the "Contact Us" form for assistance. <a href="contact.php">Contact Support</a>';
        }
    } else {
        // Invalid credentials
        $_SESSION['login_error'] = 'Invalid email, username, or password!';
    }
}

// Fetch the login error if it exists
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : null;
unset($_SESSION['login_error']); // Clear the error after using it



// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice</title>
    <link rel="stylesheet" href="sty.css">
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script> <!-- Ionicons JS -->
	
<script>

// Array of images
const images = [
    'images/menu01.png',  // Replace with your image paths
    'images/menu02.png',
    'images/menu03.png',
    'images/menu04.png',
    'images/menu05.png',
    'images/menu06.png',
    'images/menu07.png',
    'images/menu08.png',
    'images/menu09.png',
    'images/menu10.png',
    'images/menu11.png',
    'images/menu12.png',
    'images/menu16.png',
    'images/menu17.png',
    'images/menu18.png'
];

// Function to generate two images at fixed positions: one on the left and one on the right
function generateTwoFixedImages() {
    const heroBackground = document.querySelector('.hero-background');

    // Helper function to create an image at a specific side
    function createImage(side) {
        const img = document.createElement('div');
        img.classList.add('hero-image');

        // Select a random image from the array
        const randomImage = images[Math.floor(Math.random() * images.length)];
        img.style.backgroundImage = `url(${randomImage})`;

        // Set fixed horizontal position based on the side (left or right)
        if (side === 'left') {
            img.style.left = '10%';  // Fixed position on the left (10% from the left edge)
        } else {
            img.style.left = '80%';  // Fixed position on the right (80% from the left edge)
        }

        // Set fixed vertical position (e.g., centered vertically at 40%)
        img.style.top = '40%';

        // Set initial opacity to 0 for fade-in effect
        img.style.opacity = 0;

        // Append the image to the hero-background
        heroBackground.appendChild(img);

        // Fade the image in
        setTimeout(() => {
            img.style.opacity = 1;
        }, 100);  // Slight delay to ensure smooth fade-in

        // Remove the image after the animation is complete (after 3 seconds)
        setTimeout(() => {
            img.style.opacity = 0;  // Fade out
            setTimeout(() => heroBackground.removeChild(img), 1000);  // Remove from DOM after fade-out
        }, 3000);  // Keep the image visible for 3 seconds
    }

    // Create one image on the fixed left position
    createImage('left');

    // Create one image on the fixed right position
    createImage('right');
}

// Function to continuously generate two images at fixed positions at intervals
function startFixedImageAnimation() {
    setInterval(generateTwoFixedImages, 3000);  // Generate two images (left and right) every 3 seconds
}

// Start the animation when the page loads
document.addEventListener('DOMContentLoaded', startFixedImageAnimation);


</script>	

<style>
        /* Modal Styling */
        .modal {
            display: none; /* Hidden by default */
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
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>	
	
</head>
<body>

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
            <?php else: ?>
                <li><a href="login.php"></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- Background Image -->
<img src="images/coffee02.jpg" alt="Coffee Background" class="background-image">

<!-- Main Content Section -->
<div class="main-content">
    <div class="hero-section">
    <div class="hero-background"></div>
    <div class="hero-content">
        <h1>Welcome to Café Solstice</h1>
        <p>Your cozy place for the finest coffee and delightful community.</p>
    </div>
</div>


    <div class="content">
        <!-- Text Block -->
        <div class="text-block">
            <h1>Discover the Café Experience</h1>
            <p class="par">At Café Solstice, we pride ourselves on serving quality coffee and creating a warm, inviting atmosphere for all our guests. Whether you're looking for a quiet place to work, a cozy spot to relax with friends, or just a great cup of coffee, you'll find it here.</p>
        </div>

        <!-- Show login form only if the user is not logged in -->
        <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
            <div class="form">
                <form action="index.php" method="POST">
                    <h3>Login to Your Account</h3>
                    <input type="text" name="username" placeholder="Username or Email" required required pattern="^[a-zA-Z0-9_.@]{4,50}$" title="Username or Email should be 4-50 characters long and can only contain letters, numbers, @, periods, and underscores.">
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btnn">Login</button>  <!-- btnn class kept intact -->
                    <p class="forgot-password">Forgot your password? <a href="forgot.php">Click here</a> to reset it.</p>
                    <p class="register-link">New here? <a href="register.php">Register now</a></p>
                </form>
            </div>
        <?php else: ?>
            <!-- Welcome message for logged-in users -->
            <div class="welcome-message">
                <h3>Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h3>
                <p>You are logged in. Feel free to explore our site.</p>
            </div>
        <?php endif; ?>
    </div>
	
	
<!-- Modal for login error -->
<div id="loginErrorModal" class="modal" style="display: <?php echo $login_error ? 'block' : 'none'; ?>">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('loginErrorModal').style.display='none'">&times;</span>
        <h2>Error</h2>
        <p><?php echo ($login_error); ?></p>
    </div>
</div>	


</div>

<script>

// Get the modal
    var modal = document.getElementById('loginErrorModal');

    // When the user clicks on <span> (x), close the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

function validateForm() {
    var email = document.getElementById("email").value;
    var regex = /^[a-zA-Z0-9_.@]{4,50}$/; // Email should be 4-36 characters long and can contain letters, numbers, and underscores
    if (!regex.test(email)) {
        alert("Invalid email. It should be 4-50 characters long and can only contain letters, numbers, @, periods, and underscores.");
        return false;
    }
    return true;
}





</script>

<!-- Include the footer -->
<?php include('footer.php'); ?>

</body>
</html>

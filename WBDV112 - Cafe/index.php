<?php
// Start the session to handle user login
session_start();

// Check if the user is logging in
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulate user authentication (replace with actual database query)
    $users = array(
        array('username' => 'user1', 'password' => 'password1', 'name' => 'John Doe'),
        array('username' => 'user2', 'password' => 'password2', 'name' => 'Jane Smith')
    );
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            // Redirect to index.php after successful login
            header("Location: index.php");
            exit;
        }
    }
    $error = "Invalid username or password";
}

// Check if the user is logging out
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice</title>
    <link rel="stylesheet" href="sty.css">
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
                    <li><a href="#" class="active">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></a></li>
                    <li><a href="?logout=true">Logout</a></li>
					<?php else: ?>
					<li><a href="login.php"> </a></li>
					<?php endif; ?>
                </ul>
        </div>
    </div>
	
	
	 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->


     <!-- Main Content Section -->
    <div class="main-content">
        <div class="hero-section">
            <h1>Welcome to Café Solstice</h1>
            <p>Your cozy place for the finest coffee and delightful community.</p>
        </div>

        <div class="content">
            <!-- Text Block -->
            <div class="text-block">
                <h1>Discover the Café Experience</h1>
                <p class="par">At Café Solstice, we pride ourselves on serving quality coffee and creating a warm, inviting atmosphere for all our guests. Whether you're looking for a quiet place to work, a cozy spot to relax with friends, or just a great cup of coffee, you'll find it here.</p>
            </div>

            <!-- Registration Form -->
            <div class="form">
                <!-- Display login form if not logged in -->
                <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
                    <form action="index.php" method="POST">
                        <h3>Login to Your Account</h3>
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" class="btnn">Login</button>
                        <?php if (isset($error)): ?>
                            <p style="color: red;"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <p class="forgot-password">Forgot your password? <a href="forgot.php">Click here</a> to reset it.</p>
						<p class="register-link">New here? <a href="register.php">Register now</a></p> <!-- Register Link in Form -->
                    </form>
                <?php endif; ?>
            </div>
        </div>

        
    </div>
		
        
 

    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    
    <!-- Include the footer -->
    <?php include('footer.php'); ?>

</body>
</html>

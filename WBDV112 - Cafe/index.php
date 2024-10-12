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
        // Store user details in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['username'];  // Store username in session
        $_SESSION['logged_in'] = true;  // Set logged-in session flag
        header("Location: index.php");  // Redirect back to index.php
        exit();  // Ensure no further code is executed
    } else {
        echo "<script>alert('Invalid email, username, or password!'); window.location.href='index.php';</script>";
    }
}

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
        <h1>Welcome to Café Solstice</h1>
        <p>Your cozy place for the finest coffee and delightful community.</p>
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
                    <input type="text" name="username" placeholder="Username or Email" required>
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
</div>

<!-- Include the footer -->
<?php include('footer.php'); ?>

</body>
</html>

<?php
// Initialize session and cart, etc.
session_start();
// Your existing code...

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

        <div class="content">
            <h2>Register</h2>
            <div class="form">
                <form action="register_process.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btnn">Register</button>
                </form>
                <p class="link">Already have an account?<br>
                <a href="index.php">Login here</a></p>
            </div>
        </div>
    </div>

<!-- Include the footer -->
    <?php include('footer.php'); ?>


</body>
</html>

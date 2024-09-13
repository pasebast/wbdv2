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
                </ul>
        </div>
    </div>

    <div class="content">
	
        <div class="text-block">
            <br><h1>Welcome to<br><span>Café Solstice</span></h1></br>
            <p class="par">Your favorite place for<br> the best <br> coffee and delightful treats!</p>
        </div>
		
        <div class="form">
            <form action="login.php" method="POST">
                <input type="text" name="login" placeholder="Username or Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btnn">Login</button>
            </form>
            <p class="link">Don't have an account?<br><a href="register.php">Sign up here</a></p>
            <p class="liw">Reach us through our socials:</p>
            <div class="icons">
                <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                <a href="#"><ion-icon name="logo-google"></ion-icon></a>
            </div>
			
        </div>
		</br>
		
        <img src="images/coffee01.png" alt="Coffee" class="coffee-image">
    </div>

    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    
    <!-- Include the footer -->
    <?php include('footer.php'); ?>

</body>
</html>

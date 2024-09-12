<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="main">
        <div class="navbar">
            <div class="icon">

<img src="images/logo01.jpg" alt="Logo" style="
    max-width: 120px;
    height: auto;
    border: 5px solid rgba(0, 0, 0, 0.2); /* Transparent border */
    border-radius: 15px; /* Curved border */
    padding: 5px; /* Space between the image and border */
    background-clip: padding-box; /* Ensures background does not overlap border */
    margin-left: 100px; /* Move the image to the right; adjust as needed */
">


            </div>

            <div class="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="aboutus.php">About</a></li>
                </ul>
            </div>

        </div> 
		
        <div class="content">
            <h1>Welcome to<br><span>Café Solstice</span></h1>
            <p class="par">Your favorite place for<br> the best 
                <br> coffee and delightful treats!</p>

            <div class="form">
                <form action="login.php" method="POST">
                    <input type="text" name="login" placeholder="Username or Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btnn">Login</button>
                </form>

                <p class="link">Don't have an account?<br>
                <a href="register.php">Sign up here</a></p>

                <p class="liw">Reach us through our socials:</p>
                <div class="icons">
                    <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-google"></ion-icon></a>
                </div>
            </div>

         <img src="images/coffee01.png" alt="Coffee Haven" style="width:100%; max-width:400px; height:auto;">
        </div>
    </div>

    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
	
	
	
	<!-- Include the footer -->
    <?php include('footer.php'); ?>

</body>
</html>

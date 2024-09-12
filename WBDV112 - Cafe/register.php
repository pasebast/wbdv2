<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Café Solstice</title>
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
            <h1>Register</h1>
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

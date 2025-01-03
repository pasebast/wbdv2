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
    <title>Café Solstice - About Us</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your external stylesheet -->
    <link rel="icon" type="image/png" href="images/logo01.png">
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
                        <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a></li>
                    <?php endif; ?>
					
                </ul>
            </div>
        </div>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

        <div class="abouttext">
            <section>
                <h2>Our Story</h2>
                <p>At Café Solstice, we believe in crafting moments of joy and relaxation through our exquisite coffee and pastries. Founded in 2023, our café is dedicated to providing a warm and welcoming atmosphere where every customer can experience a touch of elegance and comfort. From our carefully sourced beans to our handcrafted desserts, every detail is designed with passion and care. Join us and be part of our story!</p>
            </section>

            <section><br></br><br></br>
                <h2>Meet Our Team</h2>
                <div class="team-container">
                    <div class="team-member">
                        <img src="images/test03.jpg" alt="Alice Guo">
                        <h3>Song Yiren</h3>
                        <p>Founder & Head Barista</p>
                    </div>
                    <div class="team-member">
                        <img src="images/test01.jpg" alt="Winston Churchill">
                        <h3>Walter White</h3>
                        <p>Pastry Chef</p>
                    </div>
                    <div class="team-member">
                        <img src="images/test02.png" alt="René Descartes">
                        <h3>Jesse Pinkman</h3>
                        <p>Customer Service</p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>
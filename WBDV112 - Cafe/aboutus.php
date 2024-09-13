<?php
// Initialize session and cart, etc.
session_start();
// Your existing code...

// Get the current page filename
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - About Us</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your external stylesheet -->
    
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

        <div class="abouttext">
            <section>
                <h2>Our Story</h2>
                <p>At Café Solstice, we believe in crafting moments of joy and relaxation through our exquisite coffee and pastries. Founded in 2023, our café is dedicated to providing a warm and welcoming atmosphere where every customer can experience a touch of elegance and comfort. From our carefully sourced beans to our handcrafted desserts, every detail is designed with passion and care. Join us and be part of our story!</p>
            </section>

            <section><br></br><br></br>
                <h2>Meet Our Team</h2>
                <div class="team-container">
                    <div class="team-member">
                        <img src="images/pic01.jpg" alt="Alice Guo">
                        <h3>Alice Guo</h3>
                        <p>Founder & Head Barista</p>
                    </div>
                    <div class="team-member">
                        <img src="images/pic02.jpg" alt="Winston Churchill">
                        <h3>Winston Churchill</h3>
                        <p>Pastry Chef</p>
                    </div>
                    <div class="team-member">
                        <img src="images/pic03.jpg" alt="René Descartes">
                        <h3>René Descartes</h3>
                        <p>Customer Service</p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>

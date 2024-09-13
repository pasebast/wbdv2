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
    <title>Café Solstice - Gallery</title>
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

        <div class="content">
            <h1 class="centered-heading">Store Ambiance</h1>
            <div class="gallery-container">
                <!-- First Image -->
                <div class="gallery-item">
                    <img src="images/place01.jpg" alt="Gallery Image 1">
                </div>

                <!-- Second Image -->
                <div class="gallery-item">
                    <img src="images/place02.jpg" alt="Gallery Image 2">
                </div>

                <!-- Third Image -->
                <div class="gallery-item">
                    <img src="images/place03.jpg" alt="Gallery Image 3">
                </div>
            </div>
        </div>
    </div>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>
</body>
</html>

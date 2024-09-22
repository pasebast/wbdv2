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
		
		<!-- Store Ambiance Text -->
    <div class="abouttext">
        <h2>Store Ambiance</h2>
        <p>Our store offers a unique blend of comfort and style, designed to give you a relaxing experience. Take a look at our ambiance through the gallery below.</p>
    </div>


       
            
            <div class="gallery-container">
                <!-- First Image -->
                <div class="gallery-item">
                    <img src="images/gallery01.jpg" alt="Gallery Image 1">
                </div>

                <!-- Second Image -->
                <div class="gallery-item">
                    <img src="images/gallery02.jpg" alt="Gallery Image 2">
                </div>

                <!-- Third Image -->
                <div class="gallery-item">
                    <img src="images/gallery03.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery04.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery05.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery06.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery07.jpg" alt="Gallery Image 3">
                </div>	
			
				<div class="gallery-item">
                    <img src="images/gallery08.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery09.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery10.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery11.jpg" alt="Gallery Image 3">
                </div>
				
				<div class="gallery-item">
                    <img src="images/gallery12.jpg" alt="Gallery Image 3">
                </div>
				
            </div>
        
    </div>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>
</body>
</html>

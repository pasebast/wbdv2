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
    <title>Café Solstice - Gallery</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your external stylesheet -->
	<link rel="icon" type="image/png" href="images/logo01.png">
</head>

<style>


.image-container {
    position: absolute;
    margin: 0;
    padding: 0;
}

.image-item {
    text-align: center;
    display: inline-block;
    position: relative;
    border: solid 12px #fff;
    background: #fff;
    box-shadow: 0 0 15px 0px #555;
    transition: all 1s ease;
    -o-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -webkit-transition: all 1s ease;
    top: 50px;
}

.image-item:hover {
    top: 0px;
    opacity: 0.5;
}

.image-item:nth-child(1) {
    transform: rotate(10deg);
}

.image-item:nth-child(2) {
    transform: rotate(0deg);
}

.image-item:nth-child(3) {
    transform: rotate(-10deg);
}

.image-item:nth-child(4) {
    transform: rotate(20deg);
}

.image-item:nth-child(5) {
    transform: rotate(-5deg);
}

.image-item:nth-child(6) {
    transform: rotate(15deg);
}

.image-item:nth-child(7) {
    transform: rotate(-15deg);
}

.image-item:nth-child(8) {
    transform: rotate(5deg);
}

.image-item:nth-child(9) {
    transform: rotate(25deg);
}

.image-item:nth-child(10) {
    transform: rotate(-25deg);
}

.image-item:nth-child(11) {
    transform: rotate(8deg);
}

.image-item:nth-child(12) {
    transform: rotate(-8deg);
}

p {
    margin: -15px 0 0 0;
}

.light {
    border-radius: 50%;
    position: absolute;
    left: 0;
    right: 0;
    width: 700px;
    height: 700px;
    background: #fff;
    filter: blur(100px);
    opacity: 0.3;
    pointer-events: none;
}
</style>
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
		
		<!-- Store Ambiance Text -->
    <div class="abouttext">
        <h2>Store Ambiance</h2>
        <p>Our store offers a unique blend of comfort and style, designed to give you a relaxing experience. Take a look at our ambiance through the gallery below.</p>
    </div>

 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

       
            
            <div class="gallery-container">
                <div class="image-container">
			<div class="image-item">
				<img src="images/gallery01.jpg" width="400">
			</div>
			<div class="image-item">
				<img src="images/gallery02.jpg" width="400">
			</div>
			<div class="image-item">
				<img src="images/gallery03.jpg" width="400">
			</div>
			<div class="image-item">
				<img src="images/gallery04.jpg" width="400">
				
			</div>
			<div class="image-item">
				<img src="images/gallery05.jpg" width="400">
				
			</div>
			<div class="image-item">
				<img src="images/gallery06.jpg" width="400">
				
			</div>
			<div class="image-item">
				<img src="images/gallery07.jpg" width="400">
				
			</div>
			<div class="image-item">
				<img src="images/gallery08.jpg" width="400">
				
			</div>
			<div class="image-item">
				<img src="images/gallery09.jpg" width="400">
				<?php include('footer.php'); ?>
			</div>
			<div class="image-item">
				<img src="images/gallery10.jpg" width="400">
				<?php include('footer.php'); ?>
			</div>
			<div class="image-item">
				<img src="images/gallery11.jpg" width="400">
				<?php include('footer.php'); ?>
			</div>
			<div class="image-item">
				<img src="images/gallery12.jpg" width="400">
			<?php include('footer.php'); ?>
			</div>
			
				</div>
			<div class="light"></div>
			
            </div>
        
    </div>

    <!-- Include the footer -->
    
</body>
</html>

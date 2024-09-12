<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Gallery</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your external stylesheet -->
    <style>
        .gallery-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px;
        }

        .gallery-item {
            border: 3px solid rgba(0, 0, 0, 0.3); /* Slightly transparent border */
            border-radius: 20px; /* Rounded corners */
            padding: 5px; /* Space between the image and border */
            background-clip: padding-box; /* Ensures background does not overlap border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
            margin: 10px; /* Space around each image */
            max-width: 400px; /* Set a maximum width for images */
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            border-radius: 15px; /* Rounded corners for the image itself */
        }
    </style>
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
            <h1>Gallery</h1>
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

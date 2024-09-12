<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Menu</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your external stylesheet -->
    <style>
        /* Add styles for menu container to use Flexbox */
        .menu-container {
            display: flex;
            flex-wrap: wrap; /* Allows wrapping if there's not enough space */
            gap: 20px; /* Space between items */
            justify-content: flex-start; /* Align items to the start */
        }

        .menu-item {
            display: flex;
            align-items: center;
            border: 2px solid rgba(0, 0, 0, 0.2); /* Transparent border */
            border-radius: 15px; /* Curved border */
            padding: 10px;
            max-width: 350px;
            background-color: #f9f9f9; /* Light background for contrast */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional shadow for depth */
        }

        .menu-item img {
            max-width: 120px;
            height: auto;
            border: 2px solid rgba(0, 0, 0, 0.2); /* Transparent border */
            border-radius: 15px; /* Curved border */
            padding: 5px;
            background-clip: padding-box;
            margin-right: 15px; /* Space between image and text */
        }

        .menu-item h3 {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #664228;
            font-size: 20px;
            margin: 0 0 10px 0; /* Margin for spacing */
        }

        .menu-item p {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #000000;
            font-size: 16px;
            line-height: 1.4;
            margin: 5px 0;
        }

        .menu-item span {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-weight: bold;
            color: #964B00;
            font-size: 18px;
        }

        .order-button {
            background-color: #964B00;
            color: #FFFFFF;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        .order-button svg {
            color: #FFFFFF;
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
            <h1>Our Menu</h1>
            <div class="menu-container">
                <!-- Solstice Berry Bliss Item -->
                <div class="menu-item">
                    <img src="images/menu01.png" alt="Solstice Berry Bliss">
                    <div>
                        <h3>Solstice Berry Bliss</h3>
                        <p>- A creamy and refreshing blend of strawberries and cream, capturing the sweetness of a summer solstice.</p>
                        <span>PHP 150.00</span>
                        <button class="order-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                            </svg>
                            Order Now
                        </button>
                    </div>
                </div>

                <!-- Choco Item -->
                <div class="menu-item">
                    <img src="images/menu02.png" alt="Caramel Macchiato">
                    <div>
                        <h3>Eclipse Choco Delight</h3>
                        <p>- A rich and creamy chocolate chip frappé that mirrors the allure of an eclipse—a rare, delightful experience.</p>
                        <span>PHP 120.00</span>
                        <button class="order-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                            </svg>
                            Order Now
                        </button>
                    </div>
                </div>

                <!-- Matcha Item -->
                <div class="menu-item">
                    <img src="images/menu03.png" alt="Vanilla Latte">
                    <div>
                        <h3>Aurora Matcha Dream</h3>
                        <p>- A smooth and creamy green tea frappé inspired by the natural beauty of the aurora.</p>
                        <span>PHP 190.00</span>
                        <button class="order-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                            </svg>
                            Order Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<!-- Include the footer -->
    <?php include('footer.php'); ?>

</body>
</html>

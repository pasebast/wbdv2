<?php
session_start(); // Start the session

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Initialize message
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $item = $_POST['item'];
        $_SESSION['cart'][$item] = isset($_SESSION['cart'][$item]) ? $_SESSION['cart'][$item] + 1 : 1;
        $message = "Item added to cart!";
    }
    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = array();
        $message = "Cart cleared!";
    }
}

// Calculate total items in cart
$cartCount = array_sum($_SESSION['cart']);

// Get the current page filename
$current_page = basename($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Menu</title>
    <link rel="stylesheet" href="sty.css">
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

        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="cart-icon" onclick="toggleCartPopup()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                <circle cx="8" cy="21" r="1" fill="currentColor"/>
                <circle cx="18" cy="21" r="1" fill="currentColor"/>
                <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
            </svg>
            <span><?php echo $cartCount; ?></span>
        </div>

        <div class="cart-popup" id="cartPopup">
            <div class="close" onclick="toggleCartPopup()">&times;</div>
            <h2>Your Cart</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <ul>
                    <?php foreach ($_SESSION['cart'] as $item => $quantity): ?>
                        <li><?php echo htmlspecialchars($item); ?>: <?php echo htmlspecialchars($quantity); ?></li>
                    <?php endforeach; ?>
                </ul>
                <form method="POST" action="checkout.php">
                    <button type="submit">Checkout</button>
                </form>
                <form method="POST">
                    <button name="clear_cart" type="submit">Clear Cart</button>
                </form>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <div class="content">
            <div class="menu-category">
                <h2>Frappe <img src="images/icon01.png" alt="Frappe Icon" class="category-icon"></h2>
                <div class="menu-container">
                    <?php 
                    $frappeItems = array(
                        array("image" => "images/menu01.png", "name" => "Solstice Berry Bliss", "desc" => "A blend capturing the sweetness of strawberries.", "price" => "PHP 150.00"),
                        array("image" => "images/menu02.png", "name" => "Eclipse Choco Delight", "desc" => "A chocolate frappé that mirrors the allure.", "price" => "PHP 120.00"),
                        array("image" => "images/menu03.png", "name" => "Aurora Matcha Dream", "desc" => "A smooth green frappé inspired by the aurora.", "price" => "PHP 190.00")
                    );

                    foreach ($frappeItems as $item): ?>
                    <div class="menu-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div>
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p><?php echo htmlspecialchars($item['desc']); ?></p>
                            <span><?php echo htmlspecialchars($item['price']); ?></span>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="item" value="<?php echo htmlspecialchars(strtolower(str_replace(' ', '_', $item['name']))); ?>">
                                <input type="hidden" name="add_to_cart" value="1">
                                <button class="order-button" type="submit" onclick="startCartAnimation(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                        <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                        <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                        <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                                    </svg>
                                    Order Now
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="menu-category">
                <h2>Hot Coffee <img src="images/icon02.png" alt="Coffee Icon" class="category-icon"></h2>
                <div class="menu-container">
                    <?php 
                    $coffeeItems = array(
                        array("image" => "images/menu04.png", "name" => "Solstice Shot", "desc" => "An espresso embodying the powerful energy of the solstice.", "price" => "PHP 100.00"),
                        array("image" => "images/menu05.png", "name" => "Sunrise Brew", "desc" => "A warm brew that awakens the first light of a solstice sunrise.", "price" => "PHP 130.00"),
                        array("image" => "images/menu06.png", "name" => "Dawn Flat White", "desc" => "A smooth and creamy flat white that reflects the quiet beauty of dawn.", "price" => "PHP 140.00")
                    );

                    foreach ($coffeeItems as $item): ?>
                    <div class="menu-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div>
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p><?php echo htmlspecialchars($item['desc']); ?></p>
                            <span><?php echo htmlspecialchars($item['price']); ?></span>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="item" value="<?php echo htmlspecialchars(strtolower(str_replace(' ', '_', $item['name']))); ?>">
                                <input type="hidden" name="add_to_cart" value="1">
                                <button class="order-button" type="submit" onclick="startCartAnimation(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                        <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                        <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                        <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                                    </svg>
                                    Order Now
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
			
		<div class="menu-category">
                <h2>Iced Coffee <img src="images/icon04.png" alt="Coffee Icon" class="category-icon"></h2>
                <div class="menu-container">
                    <?php 
                    $coffeeItems = array(
                        array("image" => "images/menu10.png", "name" => "Vanilla Breeze", "desc" => "A smooth cold brew infused with the light sweetness of vanilla cream.", "price" => "PHP 100.00"),
                        array("image" => "images/menu11.png", "name" => "Midday Cappuccino", "desc" => "A crisp and invigorating iced cappuccino", "price" => "PHP 130.00"),
                        array("image" => "images/menu12.png", "name" => "Golden Hour Caramel", "desc" => "A rich blend of smooth espresso, velvety milk, and sweet caramel drizzle.", "price" => "PHP 140.00")
                    );

                    foreach ($coffeeItems as $item): ?>
                    <div class="menu-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div>
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p><?php echo htmlspecialchars($item['desc']); ?></p>
                            <span><?php echo htmlspecialchars($item['price']); ?></span>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="item" value="<?php echo htmlspecialchars(strtolower(str_replace(' ', '_', $item['name']))); ?>">
                                <input type="hidden" name="add_to_cart" value="1">
                                <button class="order-button" type="submit" onclick="startCartAnimation(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                        <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                        <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                        <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                                    </svg>
                                    Order Now
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
			
            <div class="menu-category">
                <h2>Iced Tea <img src="images/icon03.png" alt="Iced Drinks Icon" class="category-icon"></h2>
                <div class="menu-container">
                    <?php 
                    $icedDrinksItems = array(
                        array("image" => "images/menu07.png", "name" => "Crimson Twilight Tea", "desc" => "A refreshing hibiscus tea with pomegranate pearls.", "price" => "PHP 110.00"),
                        array("image" => "images/menu08.png", "name" => "Vanilla Cloud", "desc" => "A delightful fusion of tea, coffee jelly, and smooth vanilla cold foam", "price" => "PHP 160.00"),
                        array("image" => "images/menu09.png", "name" => "Zenith Grapefruit Tea", "desc" => "A vibrant iced tea blend of ruby grapefruit and honey.", "price" => "PHP 170.00")
                    );

                    foreach ($icedDrinksItems as $item): ?>
                    <div class="menu-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div>
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p><?php echo htmlspecialchars($item['desc']); ?></p>
                            <span><?php echo htmlspecialchars($item['price']); ?></span>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="item" value="<?php echo htmlspecialchars(strtolower(str_replace(' ', '_', $item['name']))); ?>">
                                <input type="hidden" name="add_to_cart" value="1">
                                <button class="order-button" type="submit" onclick="startCartAnimation(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                        <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                        <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                        <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                                    </svg>
                                    Order Now
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
			
			<div class="menu-category">
                <h2>Bottled Drinks <img src="images/icon05.png" alt="Iced Drinks Icon" class="category-icon"></h2>
                <div class="menu-container">
                    <?php 
                    $icedDrinksItems = array(
                        array("image" => "images/menu13.png", "name" => "Spring Water", "desc" => "This bottled water captures the essence of a hidden spring", "price" => "PHP 110.00"),
                        array("image" => "images/menu14.png", "name" => "Horizon Wildberry Kombucha", "desc" => "A crisp and invigorating kombucha with wildberry essence.", "price" => "PHP 160.00"),
                        array("image" => "images/menu15.png", "name" => "Stellar Soy Cocoa", "desc" => "A soy chocolate drink that offers an indulgent experience.", "price" => "PHP 170.00")
                    );

                    foreach ($icedDrinksItems as $item): ?>
                    <div class="menu-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div>
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p><?php echo htmlspecialchars($item['desc']); ?></p>
                            <span><?php echo htmlspecialchars($item['price']); ?></span>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="item" value="<?php echo htmlspecialchars(strtolower(str_replace(' ', '_', $item['name']))); ?>">
                                <input type="hidden" name="add_to_cart" value="1">
                                <button class="order-button" type="submit" onclick="startCartAnimation(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                        <circle cx="8" cy="21" r="1" fill="currentColor"/>
                                        <circle cx="18" cy="21" r="1" fill="currentColor"/>
                                        <path d="M1 1h4l2 5h13l3 9H6" fill="none"/>
                                    </svg>
                                    Order Now
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
			

        </div>

        <div id="cartItemAnimation" class="cart-item-animation"></div>
    </div>

    <script>
        function toggleCartPopup() {
            var popup = document.getElementById('cartPopup');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        function startCartAnimation(event) {
            event.preventDefault();
            var cartItem = document.getElementById('cartItemAnimation');
            var button = event.currentTarget;
            var rect = button.getBoundingClientRect();
            var cartRect = document.querySelector('.cart-icon').getBoundingClientRect();

            cartItem.style.left = rect.left + 'px';
            cartItem.style.top = rect.top + 'px';
            cartItem.style.display = 'block';
            cartItem.style.animation = 'moveToCart 0.5s forwards';

            setTimeout(function() {
                cartItem.style.display = 'none';
            }, 500);

            // Submit form after animation
            button.closest('form').submit();
        }
    </script>
    
    <?php include('footer.php'); ?>
</body>
</html>

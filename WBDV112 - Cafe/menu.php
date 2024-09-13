<?php
session_start(); // Start the session to use session variables

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Initialize message
$message = '';

// Handle adding item to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $item = $_POST['item'];
        if (!isset($_SESSION['cart'][$item])) {
            $_SESSION['cart'][$item] = 0;
        }
        $_SESSION['cart'][$item]++;
        $message = "Item added to cart!";
    }
    
    // Handle clearing the cart
    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = array();
        $message = "Cart cleared!";
    }
}

// Calculate total items in cart
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $quantity) {
        $cartCount += $quantity;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Menu</title>
    <link rel="stylesheet" href="sty.css">
    <style>
        /* Add styles for menu container to use Flexbox */
        .menu-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
        }

        .menu-item {
            display: flex;
            align-items: center;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 10px;
            max-width: 350px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .menu-item img {
            max-width: 120px;
            height: auto;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 5px;
            background-clip: padding-box;
            margin-right: 15px;
        }

        .menu-item h3 {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #664228;
            font-size: 20px;
            margin: 0 0 10px 0;
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

        .cart-icon {
            position: fixed;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #964B00;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-icon span {
            background: #fff;
            border-radius: 50%;
            padding: 3px 8px;
            position: absolute;
            top: -5px;
            right: -10px;
            color: #964B00;
            font-size: 14px;
        }

        .cart-popup {
            display: none;
            position: fixed;
            top: 10%;
            right: 10px;
            max-width: 300px;
            width: 100%;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 15px;
            color: #964B00;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            box-sizing: border-box;
            border-radius: 8px;
            overflow: auto;
        }

        .cart-popup h2 {
            margin-top: 0;
        }

        .cart-popup ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cart-popup li {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .cart-popup button {
            background-color: #964B00;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        .cart-popup button:hover {
            background-color: #804000;
        }

        .cart-popup .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="main">
        <div class="navbar">
            <div class="icon">
                <img src="images/logo01.png" alt="Logo">
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
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <ul>
                    <?php foreach ($_SESSION['cart'] as $item => $quantity): ?>
                        <li><?php echo htmlspecialchars($item); ?>: <?php echo htmlspecialchars($quantity); ?></li>
                    <?php endforeach; ?>
                </ul>
                <form method="POST" action="checkout.php">
                    <button type="submit">Checkout</button>
                </form>
                <form method="POST" style="margin-top: 10px;">
                    <button name="clear_cart" type="submit">Clear Cart</button>
                </form>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <div class="content">
            <h1>Our Menu</h1>
            <div class="menu-container">
                <!-- Solstice Berry Bliss Item -->
                <div class="menu-item">
                    <img src="images/menu01.png" alt="Solstice Berry Bliss">
                    <div>
                        <h3>Solstice Berry Bliss</h3>
                        <p>A creamy blend of strawberries and cream, capturing the sweetness of a summer solstice.</p>
                        <span>PHP 150.00</span>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="item" value="solstice_berry_bliss">
                            <input type="hidden" name="add_to_cart" value="1">
                            <button class="order-button" type="submit">
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

                <!-- Eclipse Choco Delight Item -->
                <div class="menu-item">
                    <img src="images/menu02.png" alt="Eclipse Choco Delight">
                    <div>
                        <h3>Eclipse Choco Delight</h3>
                        <p>A rich chocolate frappé that mirrors the allure of an eclipse.</p>
                        <span>PHP 120.00</span>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="item" value="eclipse_choco_delight">
                            <input type="hidden" name="add_to_cart" value="1">
                            <button class="order-button" type="submit">
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

                <!-- Aurora Matcha Dream Item -->
                <div class="menu-item">
                    <img src="images/menu03.png" alt="Aurora Matcha Dream">
                    <div>
                        <h3>Aurora Matcha Dream</h3>
                        <p>A smooth green tea frappé inspired by the aurora.</p>
                        <span>PHP 190.00</span>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="item" value="aurora_matcha_dream">
                            <input type="hidden" name="add_to_cart" value="1">
                            <button class="order-button" type="submit">
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
            </div>
        </div>
    </div>

    <script>
        function toggleCartPopup() {
            var popup = document.getElementById('cartPopup');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }
    </script>
<footer class="footer">
    <?php include('footer.php'); ?>
</footer>
</body>
</html>

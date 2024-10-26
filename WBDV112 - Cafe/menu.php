<?php
session_start();




// Define items
$frappeItems = array(
    array("id" => "frappe_1", "image" => "images/menu01.png", "name" => "Solstice Berry Bliss", "desc" => "A creamy and refreshing blend of strawberries and cream.", "price" => 150.00),
    array("id" => "frappe_2", "image" => "images/menu02.png", "name" => "Eclipse Choco Delight", "desc" => "A rich and creamy chocolate chip frappé.", "price" => 120.00),
    array("id" => "frappe_3", "image" => "images/menu03.png", "name" => "Aurora Matcha Dream", "desc" => "A smooth and creamy green tea frappé.", "price" => 190.00)
);

$hotCoffeeItems = array(
    array("id" => "hotcoffee_1", "image" => "images/menu04.png", "name" => "Solstice Shot", "desc" => "Strong coffee shot.", "price" => 100.00),
    array("id" => "hotcoffee_2", "image" => "images/menu05.png", "name" => "Sunrise Brew", "desc" => "Classic brewed coffee.", "price" => 80.00),
    array("id" => "hotcoffee_3", "image" => "images/menu06.png", "name" => "Dawn Flat White", "desc" => "Smooth flat white coffee.", "price" => 120.00)
);

$icedcoffeeItems = array(
	array("id" => "icedcoffee_1", "image" => "images/menu10.png", "name" => "Vanilla Breeze", "desc" => "A smooth cold brew infused with the light sweetness of vanilla cream, creating a refreshing experience as gentle as a solstice breeze.", "price" => 100.00),
	array("id" => "icedcoffee_2", "image" => "images/menu11.png", "name" => "Midday Cappuccino", "desc" => "A crisp and invigorating iced cappuccino, perfect for a refreshing boost during the peak of your day.", "price" => 130.00),
	array("id" => "icedcoffee_3", "image" => "images/menu12.png", "name" => "Golden Hour Caramel", "desc" => "A rich blend of smooth espresso, velvety milk, and sweet caramel drizzle, inspired by the golden light of the solstice’s sunset.", "price" => 140.00)
);
					
$icedDrinksItems = array(
	array("id" => "iceddrinks_1", "image" => "images/menu07.png", "name" => "Crimson Twilight Tea", "desc" => "A refreshing hibiscus tea with pomegranate pearls, inspired by the deep hues of twilight.", "price" => 110.00),
	array("id" => "iceddrinks_2", "image" => "images/menu08.png", "name" => "Vanilla Cloud", "desc" => "A delightful fusion of bold black tea, coffee jelly, and smooth vanilla cold foam, this drink mirrors the soft clouds of the solstice sky.", "price" => 160.00),
	array("id" => "iceddrinks_3", "image" => "images/menu09.png", "name" => "Zenith Grapefruit Tea", "desc" => "A vibrant iced tea blend of ruby grapefruit and honey, representing the peak of refreshment during the zenith.", "price" => 170.00)
);
					
$bottledDrinksItems = array(
	array("id" => "botdrinks_1", "image" => "images/menu13.png", "name" => "Spring Water", "desc" => "Pure and refreshing, this bottled water captures the essence of a hidden spring.", "price" => 110.00),
	array("id" => "botdrinks_2", "image" => "images/menu14.png", "name" => "Horizon Wildberry Kombucha", "desc" => "A crisp and invigorating kombucha with wildberry essence, inspired by the endless possibilities of the horizon.", "price" => 160.00),
	array("id" => "botdrinks_3", "image" => "images/menu15.png", "name" => "Stellar Soy Cocoa", "desc" => "A velvety soy chocolate drink that offers a rich and indulgent experience, reminiscent of the sparkling beauty of the stars.", "price" => 170.00)
);
					
					
$PastryItems = array(
	array("id" => "pastry_1", "image" => "images/menu16.png", "name" => "French Toast", "desc" => "Bread dipped in a rich egg mixture, pan-fried to golden perfection, and topped with a sprinkle of cinnamon and maple syrup.", "price" => 110.00),
	array("id" => "pastry_2", "image" => "images/menu17.png", "name" => "Blueberry Cheesecake", "desc" => "Creamy cheesecake layered with fresh blueberries and a buttery graham cracker crust, topped with a luscious blueberry compote.", "price" => 160.00),
	array("id" => "pastry_3", "image" => "images/menu18.png", "name" => "Strawberry Tart Supreme", "desc" => "A delicate, buttery tart shell filled with smooth vanilla custard, topped with vibrant, juicy strawberries and a glossy glaze.", "price" => 170.00)
);


// Handle adding items to the cart
if (isset($_POST['add_to_cart'])) {
    $itemId = $_POST['item_id'];  // Get the item ID from the form
    $quantity = $_POST['quantity'];  // Get the quantity from the form

    // Validate the item ID
    if (isset($frappeItems[$itemId])) {
        $selectedItem = $frappeItems[$itemId];  // Get the selected item details

        // Check if the cart session is set, if not create it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // If the item already exists in the cart, increase the quantity
        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['name'] == $selectedItem['name']) {
                $cartItem['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // If the item doesn't exist in the cart, add it
        if (!$found) {
            $cartItem = array(
                'name' => $selectedItem['name'],
                'price' => $selectedItem['price'],
                'quantity' => $quantity
            );
            $_SESSION['cart'][] = $cartItem;
        }

        echo "<script>alert('Item added to cart');</script>";
    } else {
        echo "<script>alert('Invalid item ID');</script>";
    }
}







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Menu</title>
    <link rel="stylesheet" href="sty.css">
	
	
<script>
// Add item to cart via AJAX
function addToCart(itemId) {
    // Check if the user is logged in
    <?php if (!isset($_SESSION['user_id'])): ?>
        // User is not logged in, show the login prompt modal
        alert("Please log in to add items to your cart.");
        return; // Prevent the default behavior
    <?php else: ?>
        // User is logged in, proceed with adding the item to the cart
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_to_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Send the item ID to add to cart
        xhr.send("item_id=" + itemId);

        // Update the cart counter and cart contents dynamically
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("cart-count").innerText = response.cartCount; // Update cart count
                document.getElementById("cart-items").innerHTML = response.cartContent; // Update cart content

                // Enable the buttons when items are added
                document.getElementById("checkoutBtn").disabled = false;
                document.getElementById("clearCartBtn").disabled = false;
            }
        };
    <?php endif; ?>
}


// Clear cart via AJAX (works without refreshing the page)
function clearCart() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "clear_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the clear cart request
    xhr.send("clear_cart=1");

    // Update the cart counter and cart contents dynamically
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById("cart-count").innerText = 0; // Reset cart count
                document.getElementById("cart-items").innerHTML = "<p>Your cart is empty.</p>"; // Reset cart content

                // Disable the buttons when the cart is empty
                document.getElementById("checkoutBtn").disabled = true;
                document.getElementById("clearCartBtn").disabled = true;
            }
        }
    };
}
</script>








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
                        <li><a href="logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->


<!-- cart icon -->
<div class="cart-icon" onclick="toggleCartPopup()">
    <img src="images/cart-icon.png" alt="Cart">
    <span id="cart-count">
        <?php 
        $cartCount = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $cartCount += $cartItem['quantity'];  // Sum quantities for all items
            }
        }
        echo $cartCount; 
        ?>
    </span>
</div>



<!-- cart popup -->
<div class="cart-popup" id="cartPopup">
    <div class="close" onclick="toggleCartPopup()">&times;</div>
    <h2>Your Cart</h2>
    <div id="cart-items"> <!-- Cart items will be dynamically injected here -->
        <?php if (!empty($_SESSION['cart'])): ?>
            <ul>
    <?php foreach ($_SESSION['cart'] as $cartItem): ?>
        <li>
            <img src="<?php echo htmlspecialchars($cartItem['image']); ?>" alt="<?php echo htmlspecialchars($cartItem['name']); ?>" class="cart-item-image">
            <?php echo htmlspecialchars($cartItem['name']); ?> (x<?php echo $cartItem['quantity']; ?>): PHP <?php echo number_format($cartItem['price'], 2); ?> each
            <button class="adjust-qty" onclick="updateCartItem('<?php echo htmlspecialchars($cartItem['name']); ?>', 'decrease')">-</button>
            <button class="adjust-qty" onclick="updateCartItem('<?php echo htmlspecialchars($cartItem['name']); ?>', 'increase')">+</button>
        </li>
    <?php endforeach; ?>
</ul>


        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
    
    <!-- Checkout Button -->
    <form method="POST" action="checkout_receipt.php">
        <button type="submit" id="checkoutBtn" <?php echo empty($_SESSION['cart']) ? 'disabled' : ''; ?>>Checkout</button>
    </form>

    <!-- Clear Cart Button -->
    <button onclick="clearCart()" id="clearCartBtn" <?php echo empty($_SESSION['cart']) ? 'disabled' : ''; ?>>Clear Cart</button>
</div>







<!-- BODY POL -->

       <!-- Frappe Category -->
<div class="menu-category">
    <h2>Frappe</h2>
    <div class="menu-container">
    <?php foreach ($frappeItems as $index => $item): ?>
        <div class="menu-item">
            <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div>
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['desc']); ?></p>
                <span><?php echo number_format($item['price'], 2); ?> PHP</span>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="item_id" value="frappe_<?php echo $index; ?>"> <!-- Use frappe as prefix -->
                    <button class="order-button" onclick="addToCart('frappe_<?php echo $index; ?>')">Order Now</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>
			
			
			     <!-- hotcoffee Category -->
<div class="menu-category">
    <h2>Hot Coffee</h2>
    <div class="menu-container">
    <?php  foreach ($hotCoffeeItems as $index => $item): ?>
        <div class="menu-item">
            <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div>
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['desc']); ?></p>
                <span><?php echo number_format($item['price'], 2); ?> PHP</span>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="item_id" value="hot_<?php echo $index; ?>"> <!-- Use hot as prefix -->
                    <button class="order-button" onclick="addToCart('hot_<?php echo $index; ?>')">Order Now</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
			
<!-- icedcoffee Category -->
<div class="menu-category">
    <h2>Iced Coffee</h2>
    <div class="menu-container">
        <?php  foreach ($icedcoffeeItems as $index => $item): ?>
        <div class="menu-item">
            <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div>
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['desc']); ?></p>
                <span><?php echo number_format($item['price'], 2); ?> PHP</span>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="item_id" value="icedc_<?php echo $index; ?>"> <!-- Use icedc as prefix -->
                    <button class="order-button" onclick="addToCart('icedc_<?php echo $index; ?>')">Order Now</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
			
			
			<!-- iced drinks Category -->
<div class="menu-category">
    <h2>Iced Drinks</h2>
    <div class="menu-container">
        <?php  foreach ($icedDrinksItems as $index => $item): ?>
        <div class="menu-item">
            <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div>
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['desc']); ?></p>
                <span><?php echo number_format($item['price'], 2); ?> PHP</span>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="item_id" value="icedd_<?php echo $index; ?>"> <!-- Use icedd as prefix -->
                    <button class="order-button" onclick="addToCart('icedd_<?php echo $index; ?>')">Order Now</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
			
			<!-- bottled drinks Category -->
<div class="menu-category">
    <h2>Bottled Drinks</h2>
    <div class="menu-container">
        <?php  foreach ($bottledDrinksItems as $index => $item): ?>
        <div class="menu-item">
            <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div>
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['desc']); ?></p>
                <span><?php echo number_format($item['price'], 2); ?> PHP</span>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="item_id" value="bot_<?php echo $index; ?>"> <!-- Use bot as prefix -->
                    <button class="order-button" onclick="addToCart('bot_<?php echo $index; ?>')">Order Now</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
			
			
			<!-- pastryCategory -->
<div class="menu-category">
    <h2>Pastry</h2>
    <div class="menu-container">
        <?php  foreach ($PastryItems as $index => $item): ?>
        <div class="menu-item">
            <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div>
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['desc']); ?></p>
                <span><?php echo number_format($item['price'], 2); ?> PHP</span>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="item_id" value="pas_<?php echo $index; ?>"> <!-- Use bot as prefix -->
                    <button class="order-button" onclick="addToCart('pas_<?php echo $index; ?>')">Order Now</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
			
			
            </div> <!-- MAIN DIV END POL-->

			
			

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
		

function updateCartItem(itemName, action) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            document.getElementById('cart-count').innerText = response.cartCount;
            document.getElementById('cart-items').innerHTML = response.cartContent;
        }
    };
    xhr.send('item_name=' + encodeURIComponent(itemName) + '&action=' + encodeURIComponent(action));
}



		
    </script>
    
    <?php include('footer.php'); ?>
</body>
</html>

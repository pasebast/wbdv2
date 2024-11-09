<?php
session_start();

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "cafe_solstice";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch active products from the database
$sql = "SELECT id, category, image, name, description, price, status FROM products WHERE status = 'active'";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[$row['category']][] = $row;
    }
}

// Close the database connection
$conn->close();

// Handle adding items to the cart
if (isset($_POST['add_to_cart'])) {
    $itemId = $_POST['item_id'];  // Get the item ID from the form
    $quantity = $_POST['quantity'];  // Get the quantity from the form

    // Validate the item ID
    foreach ($products as $category => $items) {
        foreach ($items as $item) {
            if ($item['id'] == $itemId) {
                $selectedItem = $item;

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
                break;
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Menu</title>
    <link rel="stylesheet" href="sty.css">
	<link rel="icon" type="image/png" href="images/logo01.png">
	
<script>
// Add item to cart via AJAX
function addToCart(itemId) {
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert("Please log in to add items to your cart.");
            return;
        <?php else: ?>
            console.log("Adding to cart, item ID:", itemId); // Debug log
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "add_to_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Send the item ID to add to cart
            xhr.send("item_id=" + itemId);

            // Update the cart counter and cart contents dynamically
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log("Response received:", xhr.responseText); // Debug log
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("cart-count").innerText = response.cartCount;
                    document.getElementById("cart-items").innerHTML = response.cartContent;

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
                        <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a></li>
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
<?php
    foreach ($products as $category => $items) {
        echo "<div class='menu-category'>";
        echo "<h2>" . ucfirst($category) . "</h2>";
        echo "<div class='menu-container'>";
        foreach ($items as $item) {
            echo "<div class='menu-item'>";
            echo "<img src='{$item['image']}' alt='" . htmlspecialchars($item['name']) . "'>";
            echo "<div>";
            echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
            echo "<p>" . htmlspecialchars($item['description']) . "</p>";
            echo "<span>" . number_format($item['price'], 2) . " PHP</span>";
            echo "<form onsubmit='return false;' style='display:inline;'>"; // Prevent form submission
            echo "<input type='hidden' name='item_id' value='{$item['id']}'>";
            echo "<button class='order-button' type='button' onclick='addToCart({$item['id']})'>Order Now</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>


			
			

       

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

            if (response.cartCount === 0) {
                disableCheckoutAndClearCartButtons();
            }
        }
    };
    xhr.send('item_name=' + encodeURIComponent(itemName) + '&action=' + encodeURIComponent(action));
}

function disableCheckoutAndClearCartButtons() {
    document.getElementById('checkoutBtn').disabled = true;
    document.getElementById('clearCartBtn').disabled = true;
}

		
    </script>
    
    <?php include('footer.php'); ?>
</body>
</html>

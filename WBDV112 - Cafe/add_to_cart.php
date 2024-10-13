<?php
session_start();

// Check if the item ID is passed via POST
if (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];

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

    // Determine which category the item belongs to
    if (strpos($itemId, 'frappe_') !== false) {
        $itemIndex = str_replace('frappe_', '', $itemId);
        $selectedItem = $frappeItems[$itemIndex];
    } elseif (strpos($itemId, 'hot_') !== false) {
        $itemIndex = str_replace('hot_', '', $itemId);
        $selectedItem = $hotCoffeeItems[$itemIndex];
    } elseif (strpos($itemId, 'icedc_') !== false) {
        $itemIndex = str_replace('icedc_', '', $itemId);
        $selectedItem = $icedcoffeeItems[$itemIndex];
    } elseif (strpos($itemId, 'icedd_') !== false) {
        $itemIndex = str_replace('icedd_', '', $itemId);
        $selectedItem = $icedDrinksItems[$itemIndex];
    } elseif (strpos($itemId, 'bot_') !== false) {
        $itemIndex = str_replace('bot_', '', $itemId);
        $selectedItem = $bottledDrinksItems[$itemIndex];
    } elseif (strpos($itemId, 'pas_') !== false) {
        $itemIndex = str_replace('pas_', '', $itemId);
        $selectedItem = $PastryItems[$itemIndex];
    } else {
        echo json_encode(array('error' => 'Invalid item ID'));
        exit();
    }

    // Initialize the cart session if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Use a direct index-based approach to find and update items
    $found = false;

    foreach ($_SESSION['cart'] as $index => $cartItem) {
        if ($cartItem['name'] === $selectedItem['name']) {
            // If the item exists, increment the quantity at the correct index
            $_SESSION['cart'][$index]['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // If the item does not exist, add it as a new item
    if (!$found) {
        $_SESSION['cart'][] = array(
            'name' => $selectedItem['name'],
            'price' => $selectedItem['price'],
            'quantity' => 1,
            'image' => $selectedItem['image'] // Add the image to the cart session
        );
    }

    // Prepare the updated cart count and cart content for the response
    $cartCount = 0;
    $cartContent = '<ul>';
    foreach ($_SESSION['cart'] as $cartItem) {
        $cartCount += $cartItem['quantity'];
        $cartContent .= '<li>' . htmlspecialchars($cartItem['name']) . ' (x' . $cartItem['quantity'] . '): PHP ' . number_format($cartItem['price'], 2) . ' each</li>';
    }
    $cartContent .= '</ul>';

    // Return the updated cart count and content as JSON
    echo json_encode(array('cartCount' => $cartCount, 'cartContent' => $cartContent));
}

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

// Check if the item ID is passed via POST
if (isset($_POST['item_id'])) {
    $itemId = intval($_POST['item_id']); // Ensure the item ID is an integer

    // Fetch the product from the database
    $sql = "SELECT id, category, image, name, description, price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $stmt->bind_result($id, $category, $image, $name, $description, $price);
    
    if ($stmt->fetch()) {
        $selectedItem = array(
            'id' => $id,
            'category' => $category,
            'image' => $image,
            'name' => $name,
            'description' => $description,
            'price' => $price
        );

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
            $cartContent .= '<li><img src="' . htmlspecialchars($cartItem['image']) . '" alt="' . htmlspecialchars($cartItem['name']) . '" class="cart-item-image"> ' . htmlspecialchars($cartItem['name']) . ' (x' . $cartItem['quantity'] . '): PHP ' . number_format($cartItem['price'], 2) . ' each';
            $cartContent .= ' <button class="adjust-qty" onclick="updateCartItem(\'' . htmlspecialchars($cartItem['name']) . '\', \'decrease\')">-</button>';
            $cartContent .= ' <button class="adjust-qty" onclick="updateCartItem(\'' . htmlspecialchars($cartItem['name']) . '\', \'increase\')">+</button></li>';
        }
        $cartContent .= '</ul>';

        // Return the updated cart count and content as JSON
        echo json_encode(array('cartCount' => $cartCount, 'cartContent' => $cartContent));
    } else {
        echo json_encode(array('error' => 'Invalid item ID'));
    }

    $stmt->close();
} else {
    echo json_encode(array('error' => 'No item ID provided'));
}

$conn->close();
?>

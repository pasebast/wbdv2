<?php
session_start();

if (isset($_POST['item_name']) && isset($_POST['action'])) {
    $itemName = $_POST['item_name'];
    $action = $_POST['action'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    foreach ($_SESSION['cart'] as $index => $cartItem) {
        if ($cartItem['name'] === $itemName) {
            if ($action === 'increase') {
                $_SESSION['cart'][$index]['quantity'] += 1;
            } elseif ($action === 'decrease') {
                $_SESSION['cart'][$index]['quantity'] -= 1;
                if ($_SESSION['cart'][$index]['quantity'] <= 0) {
                    array_splice($_SESSION['cart'], $index, 1); // Remove item if quantity is 0 or less
                }
            }
            break;
        }
    }

    // Return the updated cart count and content as JSON
    $cartCount = 0;
    $cartContent = '<ul>';
    foreach ($_SESSION['cart'] as $cartItem) {
        $cartCount += $cartItem['quantity'];
		$cartContent .= '<li><img src="' . htmlspecialchars($cartItem['image']) . '" alt="' . htmlspecialchars($cartItem['name']) . '" class="cart-item-image"> ' . htmlspecialchars($cartItem['name']) . ' (x' . $cartItem['quantity'] . '): PHP ' . number_format($cartItem['price'], 2) . ' each';
		$cartContent .= ' <button class="adjust-qty" onclick="updateCartItem(\'' . htmlspecialchars($cartItem['name']) . '\', \'decrease\')">-</button>';
		$cartContent .= ' <button class="adjust-qty" onclick="updateCartItem(\'' . htmlspecialchars($cartItem['name']) . '\', \'increase\')">+</button>';
		$cartContent .= '</li>';

    }
    $cartContent .= '</ul>';
    echo json_encode(array('cartCount' => $cartCount, 'cartContent' => $cartContent));
}
?>

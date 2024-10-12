<?php
session_start();

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. Please go back to the menu and add items.</p>";
    exit;
}

// VAT settings
$vatPercentage = 12;
$totalAmount = 0;
$vatAmount = 0;
$grandTotal = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout Receipt</title>
</head>
<body>
    <div class="receipt-custom">
    <h2>Checkout Receipt</h2>
    <table>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price (Each)</th>
            <th>Total</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $cartItem): ?>
            <tr>
                <td><?php echo htmlspecialchars($cartItem['name']); ?></td>
                <td><?php echo htmlspecialchars($cartItem['quantity']); ?></td>
                <td>PHP <?php echo number_format($cartItem['price'], 2); ?></td>
                <td>PHP <?php echo number_format($cartItem['price'] * $cartItem['quantity'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="total-row">
            <td colspan="3">Total</td>
            <td>PHP <?php echo number_format($totalAmount, 2); ?></td>
        </tr>
    </table>

    <form action="checkout.php" method="POST">
        <button type="submit" name="confirm_checkout">Confirm Checkout</button>
    </form>

    <!-- Back to Menu Button -->
    <a href="menu.php" class="back-button">Back to Menu</a>
</div>

</body>
</html>

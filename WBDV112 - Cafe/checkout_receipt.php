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
    <link rel="stylesheet" href="sty.css"> <!-- Link to your CSS file -->
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
    <div class="receipt-custom">
        <h2>Checkout Receipt</h2>
        <table>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price (Each)</th>
                <th>Total</th>
            </tr>
			
            <?php foreach ($_SESSION['cart'] as $cartItem): 
    $itemTotal = $cartItem['price'] * $cartItem['quantity'];
    $totalAmount += $itemTotal;
?>
    <tr>
        <td>
            <div class="item-container">
                <img src="<?php echo htmlspecialchars($cartItem['image']); ?>" alt="<?php echo htmlspecialchars($cartItem['name']); ?>" class="small_img">
                <?php echo htmlspecialchars($cartItem['name']); ?>
            </div>
        </td>
        <td><?php echo htmlspecialchars($cartItem['quantity']); ?></td>
        <td>PHP <?php echo number_format($cartItem['price'], 2); ?></td>
        <td>PHP <?php echo number_format($itemTotal, 2); ?></td>
    </tr>
<?php endforeach; ?>


            <?php
            // Calculate VAT and grand total
            $vatAmount = ($totalAmount * $vatPercentage) / 100;
            $grandTotal = $totalAmount + $vatAmount;
            ?>
            <tr class="total-row">
                <td colspan="3">Subtotal</td>
                <td>PHP <?php echo number_format($totalAmount, 2); ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="3">VAT (<?php echo $vatPercentage; ?>%)</td>
                <td>PHP <?php echo number_format($vatAmount, 2); ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="3">Grand Total</td>
                <td>PHP <?php echo number_format($grandTotal, 2); ?></td>
            </tr>
        </table>

        <form action="checkout.php" method="POST">
    <button type="submit" name="confirm_checkout" class="checkout-button">Confirm Checkout</button>
</form>


        <!-- Back to Menu Button -->
        <a href="menu.php" class="back-button">Back to Menu</a>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>

<?php
// Start the session to handle cart data
session_start();



$menuItems = array(
    'Solstice Berry Bliss' => 150.00,
    'Eclipse Choco Delight' => 120.00,
    'Aurora Matcha Dream' => 190.00,
    'Blueberry Muffin' => 2.50,
    'Chocolate Cake' => 3.25
);

// Sample cart data
$cart = array(
    'Solstice Berry Bliss' => 2,
    'Eclipse Choco Delight' => 1,
    'Aurora Matcha Dream' => 3
);

// Calculate totals
$subtotal = 0;
foreach ($cart as $item => $quantity) {
    $subtotal += $menuItems[$item] * $quantity;
}
$tax = $subtotal * 0.08; // 8% tax
$total = $subtotal + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Receipt</title>
    <link rel="stylesheet" href="sty.css"> 
</head>
<body>
    <!-- Navbar Section -->
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

    <!-- Checkout Container -->
    <div class="checkout-container">
        <div class="receipt">
            <h2>Your Receipt</h2>
            <p>Thank you for your order! Below is a summary of your purchase.</p>

            <div class="receipt-table">
			 <div class="receipt-header">
                    <div class="receipt-column-header">Item</div>
                    <div class="receipt-column-header">Quantity</div>
                    <div class="receipt-column-header">Price</div>
                    <div class="receipt-column-header">Total</div>
                </div>
                <?php foreach ($cart as $item => $quantity): ?>
                    <div class="receipt-row">
                        <div class="receipt-item"><?php echo $item; ?></div>
                        <div class="receipt-quantity"><?php echo $quantity; ?></div>
                        <div class="receipt-price">PHP <?php echo number_format($menuItems[$item], 2); ?></div>
                        <div class="receipt-total">PHP <?php echo number_format($menuItems[$item] * $quantity, 2); ?></div>
                    </div>
                <?php endforeach; ?>
                <div class="receipt-row total-row">
                    <div class="receipt-item"></div>
                    <div class="receipt-quantity"></div>
                    <div class="receipt-price total-label">Subtotal</div>
                    <div class="receipt-total">PHP <?php echo number_format($subtotal, 2); ?></div>
                </div>
                <div class="receipt-row total-row">
                    <div class="receipt-item"></div>
                    <div class="receipt-quantity"></div>
                    <div class="receipt-price total-label">VAT - DTI</div>
                    <div class="receipt-total">PHP <?php echo number_format($tax, 2); ?></div>
                </div>
                <div class="receipt-row total-row">
                    <div class="receipt-item"></div>
                    <div class="receipt-quantity"></div>
                    <div class="receipt-price total-label">Grand Total</div>
                    <div class="receipt-total">PHP <?php echo number_format($total, 2); ?></div>
                </div>
            </div>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

            <p class="thank-you">We hope you enjoy your order! Please visit us again.</p>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
           <?php include('footer.php'); ?>
    </div>
</body>
</html>

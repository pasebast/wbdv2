<?php
session_start();
date_default_timezone_set('Asia/Manila'); // Set to your local time zone
// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. Please go back to the menu and add items.</p>";
    exit;
}

include('db_connection.php'); // Ensure correct path to your DB connection

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the saved payment method for the logged-in user
$query = "SELECT saved_payment FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($saved_payment);
$stmt->fetch();
$stmt->close();

// Check if the saved_payment is empty
if (empty($saved_payment)) {
    // If no saved payment, trigger the modal in the frontend
    $show_payment_modal = true;
} else {
    $show_payment_modal = false;
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
	
	<style>
        /* Modal Styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
        }

        .modal-content {
            background-color: #fff4e6;
            margin: 15% auto;
            padding: 20px;
            border: 2px solid #964B00;
            border-radius: 10px;
            width: 40%;
            text-align: center;
            font-family: 'Comic Sans MS', cursive;
            color: #664228;
        }

        .modal-header h2 {
            color: #964B00;
            margin-bottom: 20px;
        }

        .modal-footer {
            margin-top: 20px;
        }

        .close-btn, .btnn {
            padding: 10px 20px;
            background-color: #964B00;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .close-btn:hover, .btnn:hover {
            background-color: #7a3e1c;
        }
    </style>
	
	
</head>
<body>

<?php if ($show_payment_modal): ?>
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Missing Payment Method</h2>
            </div>
            <div class="modal-body">
                <p>You cannot proceed with the checkout as there is no payment method saved in your profile.</p>
            </div>
            <div class="modal-footer">
                <a class="close-btn" href="profile.php">Go to Profile to Add Payment Method</a> <!-- Link to Profile -->
            </div>
        </div>
    </div>

    <script>
        // Show the modal when the page loads if no payment method is saved
        document.getElementById('paymentModal').style.display = 'block';
    </script>
<?php endif; ?>


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
        <?php if (!$show_payment_modal): ?>
            <button type="submit" name="confirm_checkout" class="checkout-button">Confirm Checkout</button>
        <?php else: ?>
            <!-- Disable the button if no payment method -->
            <button type="submit" name="confirm_checkout" class="checkout-button" disabled>Confirm Checkout</button>
        <?php endif; ?>
    </form>


        <!-- Back to Menu Button -->
        <a href="menu.php" class="back-button">Back to Menu</a>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>

<?php
session_start();
include('db_connection.php'); // Ensure the correct path to db_connection.php

// Handle checkout confirmation
if (isset($_POST['confirm_checkout'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Get the logged-in user's ID
        $user_id = $_SESSION['user_id']; // Ensure user_id is stored in session after login

        // Fetch the saved payment method from the users table
        $query_user = "SELECT saved_payment FROM users WHERE id = ?";
        $stmt_user = $conn->prepare($query_user);
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $stmt_user->bind_result($saved_payment);
        $stmt_user->fetch();
        $stmt_user->close();

        // Ensure that saved_payment is not null
        if (empty($saved_payment)) {
            $saved_payment = 'Unknown'; // Default value if no payment method is found
        }

        // Generate a unique order number
        $order_number = uniqid('ORD');

        // Get the current date and time for the order
        $order_date = date('Y-m-d H:i:s');

        // Calculate the subtotal (total amount before tax)
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
        }

        // Calculate tax and grand total
        $tax_rate = 0.12; // Assuming a 12% tax rate
        $tax = $subtotal * $tax_rate;
        $grand_total = $subtotal + $tax;

        // Insert the order into the orders table, including the grand total
        $query = "INSERT INTO orders (user_id, order_number, order_date, total_amount, saved_payment) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issds", $user_id, $order_number, $order_date, $grand_total, $saved_payment);
        $stmt->execute();

        // Get the ID of the newly inserted order
        $order_id = $stmt->insert_id;

        // Insert each cart item into the order_items table
        foreach ($_SESSION['cart'] as $cartItem) {
            $product_name = $cartItem['name'];
            $quantity = $cartItem['quantity'];
            $price = $cartItem['price'];
            $image = $cartItem['image']; // Ensure image path is included in the cart data

            // Insert the item into the order_items table
            $item_query = "INSERT INTO order_items (order_id, product_name, quantity, price, image) VALUES (?, ?, ?, ?, ?)";
            $item_stmt = $conn->prepare($item_query);
            $item_stmt->bind_param("isids", $order_id, $product_name, $quantity, $price, $image);
            $item_stmt->execute();
        }

        // Clear the cart after checkout
        unset($_SESSION['cart']);

        // Confirmation page
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Order Confirmation</title>
            <link rel="stylesheet" href="sty.css"> <!-- Link to your main CSS file -->
            <style>
                .confirmation-container {
                    max-width: 600px;
                    margin: 50px auto;
                    padding: 30px;
                    text-align: center;
                    background-color: #fff4e6;
                    border: 2px solid #964B00;
                    border-radius: 10px;
                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                    font-family: 'Comic Sans MS', cursive, sans-serif;
                    color: #664228;
                }
                .confirmation-container h1 {
                    color: #964B00;
                    margin-bottom: 20px;
                    font-size: 28px;
                }
                .confirmation-container p {
                    font-size: 18px;
                    line-height: 1.5;
                }
                .confirmation-button {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    background-color: #964B00;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    font-size: 16px;
                    transition: background-color 0.3s ease;
                }
                .confirmation-button:hover {
                    background-color: #7a3e1c;
                }
            </style>
        </head>
        <body>

        <div class="confirmation-container">
            <h1>Thank you for your order!</h1>
            <p>Your order (Order No: <?php echo $order_number; ?>) has been confirmed and is being processed. We appreciate your business!</p>
            <a href="index.php" class="confirmation-button">Return to Home</a>
        </div>

        </body>
        </html>

        <?php
        $stmt->close();
        $item_stmt->close();
        $conn->close();
    } else {
        echo "<p>Your cart is empty. Unable to proceed with checkout.</p>";
    }
}
?>

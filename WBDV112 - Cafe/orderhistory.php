<?php
session_start();
include('db_connection.php'); // Ensure correct path to db_connection.php

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the user's order history with email and saved payment method from the orders table
$query = "SELECT orders.order_number, orders.order_date, orders.total_amount, orders.saved_payment, users.email
          FROM orders
          INNER JOIN users ON orders.user_id = users.id
          WHERE orders.user_id = ?
          ORDER BY orders.order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Bind the result variables
$stmt->bind_result($order_number, $order_date, $total_amount, $saved_payment, $email);

// Fetch the data into an array
$orderHistory = array();
while ($stmt->fetch()) {
    $orderHistory[] = array(
        'order_number' => $order_number,
        'order_date' => $order_date,
        'total_amount' => $total_amount,
        'saved_payment' => $saved_payment,  // Now fetched from the orders table
        'email' => $email
    );
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your main CSS file -->
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
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
        }
        .modal-content {
            background-color: #fff4e6;
            margin: 10% auto;
            padding: 20px;
            border: 2px solid #964B00;
            border-radius: 10px;
            width: 70%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .modal-header, .modal-body, .modal-footer {
            padding: 10px;
        }
        .modal-header h2 {
            margin: 0;
            color: #964B00;
        }
        .modal-body p {
            font-size: 16px;
        }
        .close-btn {
            color: white;
            background-color: #964B00;
            padding: 10px;
            text-decoration: none;
            cursor: pointer;
            float: right;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .close-btn:hover {
            background-color: #7a3e1c;
        }

        .modal-content {
            max-width: 800px;
        }

        .modal-body img {
            margin-left: 20px;
            max-width: 100px;
        }
    </style>
</head>
<body>

<!-- Background Image -->
<img src="images/coffee02.jpg" alt="Coffee Background" class="background-image">

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
            <?php else: ?>
                <li><a href="login.php"></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>


<div class="order-history-container">
    <h1>Your Order History</h1>

    <?php if (!empty($orderHistory)): ?>
        <table class="order-history-table">
            <thead>
                <tr>
                    <th>Order No</th>
                    <th>Date</th>
                    <th>Total (PHP)</th>
                    <th>Payment Method</th>
                    <th>Email</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tbody>
    <?php foreach ($orderHistory as $order): ?>
        <tr>
            <td><?php echo htmlspecialchars($order['order_number']); ?></td>
            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
            <td>PHP <?php echo number_format($order['total_amount'], 2); ?></td> <!-- This is now the grand total -->
            <td><?php echo htmlspecialchars($order['saved_payment']); ?></td>
            <td><?php echo htmlspecialchars($order['email']); ?></td>
            <td><a href="#" onclick="openModal('<?php echo htmlspecialchars($order['order_number']); ?>')" class="view-details-link">View Details</a></td>
        </tr>
    <?php endforeach; ?>
</tbody>

            </tbody>
        </table>
    <?php else: ?>
        <p>You have no past orders.</p>
    <?php endif; ?>

    <!-- Back to Home Button -->
    <div class="order-history-back-button-container">
        <a href="index.php" class="order-history-back-button">Back to Home</a>
    </div>
</div>

<!-- Modal for Order Details -->
<div id="orderDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Order Details</h2>
            <a class="close-btn" onclick="closeModal()">Close</a>
        </div>
        <div class="modal-body">
            <!-- Order details will be dynamically inserted here -->
            <p id="orderDetails"></p>
        </div>
    </div>
</div>

<script>

function openModal(orderNumber) {
    console.log("Fetching details for order: " + orderNumber);

    // AJAX request to fetch order details
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "fetch_order_details.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);

            var response = JSON.parse(xhr.responseText);
            var orderDetails = response.order_details;
            var orderSummary = response.order_summary;
            var orderDetailsHtml = "Order No: " + orderNumber + "<br><br>";

            // Add order date and saved payment method (assumes these values are the same for all items in the order)
            if (orderDetails.length > 0) {
                orderDetailsHtml += "Order Date: " + orderDetails[0].order_date + "<br>";
                orderDetailsHtml += "Payment Method: " + orderDetails[0].saved_payment + "<br><br>";
            }

            // Loop through the order details and format them with the image on the right
            orderDetails.forEach(function (item) {
                orderDetailsHtml += "<div style='display: flex; align-items: center; justify-content: space-between;'>"
                orderDetailsHtml += "<div>" +
                    "Product: " + item.product_name + "<br>" +
                    "Quantity: " + item.quantity + "<br>" +
                    "Price: PHP " + item.price + "<br><br>" +
                    "</div>";
                
                // Add product image if available
                if (item.image) {
                    orderDetailsHtml += "<img src='" + item.image + "' style='width: 100px; height: auto; margin-left: 20px;'>";
                }
                orderDetailsHtml += "</div>";
            });

            // Add the order summary (subtotal, tax, and grand total)
            orderDetailsHtml += "<hr>";
            orderDetailsHtml += "<strong>Subtotal: PHP " + orderSummary.subtotal.toFixed(2) + "</strong><br>";
            orderDetailsHtml += "<strong>Tax (12%): PHP " + orderSummary.tax.toFixed(2) + "</strong><br>";
            orderDetailsHtml += "<strong>Grand Total: PHP " + orderSummary.grand_total.toFixed(2) + "</strong><br>";

            // Insert the details into the modal
            document.getElementById('orderDetails').innerHTML = orderDetailsHtml;

            // Show the modal
            document.getElementById('orderDetailsModal').style.display = 'block';
        }
    };

    // Send the order number to the PHP script
    xhr.send("order_number=" + orderNumber);
}


function closeModal() {
    document.getElementById('orderDetailsModal').style.display = 'none';
}
</script>

</body>
</html>

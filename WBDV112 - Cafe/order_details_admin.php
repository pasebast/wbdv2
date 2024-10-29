<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "cafe_solstice";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order number from URL
$order_number = $_GET['order_number'];

// Fetch order details and user info
$sql_order = "SELECT o.order_number, o.order_date, o.total_amount, o.saved_payment, u.username 
              FROM orders o 
              JOIN users u ON o.user_id = u.id 
              WHERE o.order_number = '$order_number'";
$result_order = $conn->query($sql_order);
$order_details = $result_order->fetch_assoc();

// Fetch order items
$sql_items = "SELECT product_name, quantity, price, image 
              FROM order_items 
              WHERE order_id = (SELECT id FROM orders WHERE order_number = '$order_number')";
$result_items = $conn->query($sql_items);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your main CSS file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            border: 1px solid #ddd;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f8a21c;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .admin-banner {
            background-color: #d9534f;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        a {
            text-decoration: none;
            color: #0275d8;
        }
        a:hover {
            text-decoration: underline;
        }
        .home-back-button {
			margin-top: 20px;
			text-align: center;
		}

		.home-back-button a {
			background-color: #f8a21c;
			color: white;
			padding: 12px 25px; /* Increased padding for better spacing */
			text-decoration: none;
			border-radius: 5px;
			font-weight: bold;
			transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition for hover effect */
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
		}

		.home-back-button a:hover {
			background-color: #d9534f;
			color: white;
			box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1); /* Enhance shadow on hover */
		}
    </style>
</head>
<body>
    <div class="admin-banner">ADMIN ACCESS ONLY</div>
	
    <div class="container">
        <h2>Order Details for Order Number: <?php echo htmlspecialchars($order_details['order_number']); ?></h2>
        <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order_details['order_date']); ?></p>
        <p><strong>Total Amount:</strong> <?php echo htmlspecialchars($order_details['total_amount']); ?></p>
        <p><strong>Saved Payment:</strong> <?php echo htmlspecialchars($order_details['saved_payment']); ?></p>
        <p><strong>Ordered by:</strong> <?php echo htmlspecialchars($order_details['username']); ?></p>
        <h3>Items</h3>
        <?php
        if ($result_items->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Image</th></tr>";
            while ($row = $result_items->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['product_name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['price']}</td>
                        <td><img src='../../WBDV112%20-%20Cafe/{$row['image']}' alt='{$row['product_name']}' width='50'></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No items found for this order.";
        }
        $conn->close();
        ?>
        <div class="home-back-button">
            <a href="ordersadmin.php">Back to Orders</a>
        </div>
    </div>
</body>
</html>

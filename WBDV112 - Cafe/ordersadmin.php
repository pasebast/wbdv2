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

// Fetch orders along with the username
$sql = "SELECT o.id, o.order_number, o.order_date, o.total_amount, o.saved_payment, u.username 
        FROM orders o 
        JOIN users u ON o.user_id = u.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders Management</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your main CSS file -->
	<link rel="icon" type="image/png" href="images/logo01.png">
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
<!-- Background Image -->
<img src="images/coffee02.jpg" alt="Coffee Background" class="background-image">

    <div class="admin-banner">ADMIN ACCESS ONLY</div>
	<div class="home-back-button">
            <a href="index.php">Back to Home</a>
        </div>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Order Number</th><th>Order Date</th><th>Total Amount</th><th>Saved Payment</th><th>Username</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td><a href='order_details_admin.php?order_number={$row['order_number']}'>{$row['order_number']}</a></td>
                        <td>{$row['order_date']}</td>
                        <td>{$row['total_amount']}</td>
                        <td>{$row['saved_payment']}</td>
                        <td>{$row['username']}</td>
						<td><a href='delete_order.php?id={$row['id']}' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this order?\")'>Delete</a></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No orders found.";
        }
        $conn->close();
        ?>
        <div class="home-back-button">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>

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

// Fetch users from the database
$sql = "SELECT id, username, email, account_status FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - User Management</title>
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
        .back-button {
            margin-top: 20px;
            text-align: center;
        }
        .back-button a {
            background-color: #f8a21c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-button a:hover {
            background-color: #d9534f;
            color: white;
        }
        .resend-button {
            background-color: #f8a21c;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin-top: 5px;
        }
        .resend-button:hover {
            background-color: #d9534f;
            color: white;
        }
    </style>
</head>
<body>
    <div class="admin-banner">ADMIN ACCESS ONLY</div>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['account_status']}</td>
                        <td>
                            <a href='update_status_admin.php?id={$row['id']}&status=active'>Activate</a> | 
                            <a href='update_status_admin.php?id={$row['id']}&status=pending'>Pending</a> | 
                            <a href='update_status_admin.php?id={$row['id']}&status=deactivated'>Deactivate</a>";
                if ($row['account_status'] === 'Pending') {
                    echo " | <a href='resend_activation_admin.php?email={$row['email']}' class='resend-button'>Resend Activation Email</a>";
                }
                echo "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No users found.";
        }
        $conn->close();
        ?>
        <div class="back-button">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>

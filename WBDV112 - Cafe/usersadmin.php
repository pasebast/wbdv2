<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Database connection ko
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "cafe_solstice";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch ni pol ng pinas
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
		
		/* Spinner Styling */
        #loadingSpinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            text-align: center;
        }
        
        #loadingSpinner .loader {
            /* Add your loader styling here */
        }
        
        #loadingSpinner p {
            color: white;
        }

        /* Activation Status Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
		
    </style>
</head>
<body>
    <div id="loadingSpinner">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="loader"></div>
            <p>Loading...</p>
        </div>
    </div>

    <!-- Activation Status Modal -->
    <div id="activationStatusModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="activationStatusMessage"></p>
        </div>
    </div>

    <div class="admin-banner">ADMIN ACCESS ONLY</div>
	
	<div class="home-back-button">
            <a href="index.php">Back to Home</a>
        </div>
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
                    echo " | <a href='resend_activation_admin.php?email={$row['email']}' class='resend-button' onclick='showLoadingSpinner()'>Resend Activation Email</a>";
                }
                echo "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No users found.";
        }
        $conn->close();
        ?>
        <div class="home-back-button">
            <a href="index.php">Back to Home</a>
        </div>
    </div>

    <script>
        function showLoadingSpinner() {
            var spinner = document.getElementById('loadingSpinner');
            spinner.style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const activationStatus = "<?php echo isset($_SESSION['activation_status']) ? $_SESSION['activation_status'] : ''; ?>";
            const activationMessage = "<?php echo isset($_SESSION['activation_message']) ? $_SESSION['activation_message'] : ''; ?>";
            
            if (activationStatus) {
                var modal = document.getElementById('activationStatusModal');
                var message = document.getElementById('activationStatusMessage');
                message.innerHTML = activationMessage;
                modal.style.display = 'block';

                // Hide the loading spinner if the modal is shown
                var spinner = document.getElementById('loadingSpinner');
                spinner.style.display = 'none';

                // Close modal functionality
                var closeBtn = modal.querySelector('.close');
                closeBtn.onclick = function() {
                    modal.style.display = 'none';
                };
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                };
            }

            // Clear session variables after use
            <?php unset($_SESSION['activation_status'], $_SESSION['activation_message']); ?>
        });
    </script>
</body>
</html>

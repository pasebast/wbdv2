<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Footer</title>
    <style>
        .footer {
            background: #964B00; /* Dark brown background */
            color: #FFFFFF; /* White text */
            padding: 20px 0; /* Top and bottom padding */
            text-align: center; /* Center align text */
            position: relative; /* Ensure footer stays at the bottom of content */
        }
        .footer .social-links a {
            color: #FFFFFF; /* White icons */
            font-size: 24px; /* Icon size */
            margin: 0 10px; /* Space between icons */
            transition: color 0.3s ease; /* Smooth color transition */
        }
        .footer .social-links a:hover {
            color: #ff7200; /* Change color on hover */
        }
        .footer p {
            margin: 10px 0; /* Space around text */
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="social-links">
            <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="#"><ion-icon name="logo-google"></ion-icon></a>
        </div>
        <p>&copy; 2024 Café Solstice. All rights reserved.</p>
    </footer>

    <!-- Include Ionicons -->
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>

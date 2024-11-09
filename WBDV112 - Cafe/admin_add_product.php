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

// Handle adding a new product
if (isset($_POST['add_product'])) {
    $category = $_POST['new_category'];
    $image = $_POST['new_image'];
    $name = $_POST['new_name'];
    $description = $_POST['new_description'];
    $price = $_POST['new_price'];
    $status = $_POST['new_status'];

    $sql = "INSERT INTO products (category, image, name, description, price, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssds", $category, $image, $name, $description, $price, $status);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Product added successfully";
        header('Location: admin_modifyproducts.php');
        exit; // Ensure no further code is executed after redirection
    } else {
        $_SESSION['message'] = "Error adding product";
        header('Location: admin_modifyproducts.php');
        exit; // Ensure no further code is executed after redirection
    }
    $stmt->close();
}

$conn->close();
?>

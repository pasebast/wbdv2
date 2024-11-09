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

// Handle updating a product
if (isset($_POST['update_product'])) {
    foreach ($_POST['id'] as $index => $id) {
        // Get new values from the form
        $category = htmlspecialchars(stripslashes($_POST['category'][$index]));
        $image = htmlspecialchars(stripslashes($_POST['image'][$index]));
        $name = htmlspecialchars(stripslashes($_POST['name'][$index]));
        $description = htmlspecialchars(stripslashes($_POST['description'][$index]));
        $price = $_POST['price'][$index];
        $status = $_POST['status'][$index];

        // Get old values from the database
        $sql = "SELECT category, image, name, description, price, status FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($old_category, $old_image, $old_name, $old_description, $old_price, $old_status);
        $stmt->fetch();
        $stmt->close();

        // Check if any values have changed
        if ($category != $old_category || $image != $old_image || $name != $old_name || $description != $old_description || $price != $old_price || $status != $old_status) {
            $sql = "UPDATE products SET category = ?, image = ?, name = ?, description = ?, price = ?, status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssdsi", $category, $image, $name, $description, $price, $status, $id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Product updated successfully.";
            }
            $stmt->close();
        }
    }
    header('Location: admin_modifyproducts.php');
    exit;
}




// Handle deleting a product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Product was successfully deleted.";
    }
    $stmt->close();
    header('Location: admin_modifyproducts.php');
    exit;
}

// Handle hiding/showing a product
if (isset($_GET['hide'])) {
    $id = $_GET['hide'];
    $sql = "UPDATE products SET status = 'hidden' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['show'])) {
    $id = $_GET['show'];
    $sql = "UPDATE products SET status = 'active' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch products
$sql = "SELECT id, category, image, name, description, price, status FROM products";
$result = $conn->query($sql);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Modify Products</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your main CSS file -->
	<link rel="icon" type="image/png" href="images/logo01.png">
</head>

<body>
<div class="admin-banner">ADMIN ACCESS ONLY</div>
<div class="home-back-button">
            <a href="index.php">Back to Home</a>
        </div>


    <!-- Display Current Products with Editable Fields -->
    <h2>Current Products</h2>
    <form method="POST" action="admin_modifyproducts.php" onsubmit="return confirmUpdate(0);">
    <?php if ($result->num_rows > 0): ?>
        <table class="admin-product-table">
            <tr>
                <th>Category</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><input type="text" name="category[]" value="<?php echo htmlspecialchars(stripslashes($row['category'])); ?>" data-original="<?php echo htmlspecialchars(stripslashes($row['category'])); ?>"></td>
                    <td><input type="text" name="image[]" value="<?php echo htmlspecialchars(stripslashes($row['image'])); ?>" data-original="<?php echo htmlspecialchars(stripslashes($row['image'])); ?>"></td>
                    <td><input type="text" name="name[]" value="<?php echo htmlspecialchars(stripslashes($row['name'])); ?>" data-original="<?php echo htmlspecialchars(stripslashes($row['name'])); ?>"></td>
                    <td><textarea name="description[]" data-original="<?php echo htmlspecialchars(stripslashes($row['description'])); ?>"><?php echo htmlspecialchars(stripslashes($row['description'])); ?></textarea></td>
                    <td><input type="number" step="0.01" name="price[]" value="<?php echo $row['price']; ?>" data-original="<?php echo $row['price']; ?>"></td>
                    <td>
                        <select name="status[]" data-original="<?php echo $row['status']; ?>">
                            <option value="active" <?php echo $row['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="hidden" <?php echo $row['status'] == 'hidden' ? 'selected' : ''; ?>>Hidden</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="admin-product-update-button" name="update_product" value="<?php echo $row['id']; ?>">Update</button>
                        <a href="admin_modifyproducts.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        <?php if ($row['status'] === 'active'): ?>
                            <a href="admin_modifyproducts.php?hide=<?php echo $row['id']; ?>">Hide</a>
                        <?php else: ?>
                            <a href="admin_modifyproducts.php?show=<?php echo $row['id']; ?>">Show</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</form>

    <!-- Add New Product Form -->
    <h2>Add New Product</h2>
    <form method="POST" action="admin_add_product.php">
        <table class="admin-product-table">
            <tr>
                <th>Category</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td><input type="text" name="new_category" required></td>
                <td><input type="text" name="new_image" required></td>
                <td><input type="text" name="new_name" required></td>
                <td><textarea name="new_description" required></textarea></td>
                <td><input type="number" step="0.01" name="new_price" required></td>
                <td>
                    <select name="new_status">
                        <option value="active">Active</option>
                        <option value="hidden">Hidden</option>
                    </select>
                </td>
                <td><button type="submit" class="admin-product-add-button" name="add_product">Add</button></td>
            </tr>
        </table>
    </form>
	
	<div class="home-back-button">
        <a href="index.php">Back to Home</a>
    </div>


<!-- Modal -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('messageModal').style.display='none'">&times;</span>
            <p id="modalMessage"></p>
        </div>
    </div>	
	
	
 <!-- Modal Structure -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?></p>
        </div>
    </div>
</body>

<!-- Modal Structure -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?></p>
    </div>
</div>


<!-- Modal Structure -->
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeConfirmModal()">&times;</span>
        <p>Are you sure you want to apply these changes?</p>
        <button onclick="confirmChanges()">Yes</button>
        <button onclick="closeConfirmModal()">No</button>
    </div>
</div>


<script>
	// Show modal if message is set in session
	<?php if (isset($_SESSION['message'])): ?>
		document.getElementById('modalMessage').innerText = "<?php echo $_SESSION['message']; unset($_SESSION['message']); ?>";
		document.getElementById('messageModal').style.display = 'block';
	<?php endif; ?>
	
	
function openModal() {
        document.getElementById("deleteModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("deleteModal").style.display = "none";
    }

    // Open the modal if the session message is set
    <?php if (isset($_SESSION['message'])): ?>
        openModal();
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
	



function confirmUpdate(formIndex) {
    var form = document.forms[formIndex];
    var changed = false;

    // Compare form values with original values
    for (var i = 0; i < form.elements.length; i++) {
        var element = form.elements[i];
        if (element.name && element.name.includes('[]')) {
            var originalValue = element.getAttribute('data-original');
            if (element.value !== originalValue) {
                changed = true;
                break;
            }
        }
    }

    if (changed) {
        return confirm('Are you sure you want to apply these changes?');
    } else {
        alert('No changes detected.');
        return false;
    }
}


</script>



</html>

<?php
include('db_connection.php');

if (isset($_POST['order_number'])) {
    // Get the order number from the AJAX request
    $order_number = $_POST['order_number'];

    // Prepare the SQL query
    $query = "SELECT order_items.product_name, order_items.quantity, order_items.price, order_items.image,
              orders.order_date, orders.saved_payment, orders.address
              FROM order_items
              INNER JOIN orders ON orders.id = order_items.order_id
              WHERE orders.order_number = ?";

    // Check if the query preparation is successful
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $order_number);
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($product_name, $quantity, $price, $image, $order_date, $saved_payment, $address);

        // Fetch the data into an array and calculate subtotal
        $order_details = array();
        $subtotal = 0; // Initialize subtotal

        while ($stmt->fetch()) {
            $order_details[] = array(
                'product_name' => $product_name,
                'quantity' => $quantity,
                'price' => $price,
                'image' => $image,
                'order_date' => $order_date,
                'saved_payment' => $saved_payment,
                'address' => $address // Include address in the response
            );

            $subtotal += $price * $quantity; // Calculate the subtotal
        }

        // Calculate tax and grand total
        $tax_rate = 0.12; // Assuming a 12% tax rate
        $tax = $subtotal * $tax_rate;
        $grand_total = $subtotal + $tax;

        // Add subtotal, tax, and grand total to the response
        $order_summary = array(
            'subtotal' => $subtotal,
            'tax' => $tax,
            'grand_total' => $grand_total
        );

        // Return the details and order summary as a JSON object
        echo json_encode(array('order_details' => $order_details, 'order_summary' => $order_summary, 'address' => $address));
        $stmt->close();
    } else {
        // If query preparation failed, log the error message
        echo json_encode(array('error' => 'SQL error: ' . $conn->error));
        error_log("SQL error: " . $conn->error); // Log the error message
    }
} else {
    echo json_encode(array('error' => 'No order number provided'));
    error_log("No order number provided in POST request");
}

$conn->close();
?>

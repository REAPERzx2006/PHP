<?php
// Include the database connection
include './db_connect.php';

// Check if the 'id' is passed via the GET request
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $product_id = intval($_GET['id']);
    
    // Prepare the SQL delete query
    $sql = "DELETE FROM products WHERE id = ?";
    
    // Initialize a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the product ID to the prepared statement
        $stmt->bind_param("i", $product_id);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the product list page with a success message
            header("Location: product_list.php?message=Product deleted successfully");
            exit();
        } else {
            echo "Error: Could not execute the delete query.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare the delete statement.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Error: Product ID not provided.";
}

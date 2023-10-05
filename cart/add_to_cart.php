<?php
session_start();

if (isset($_GET['product_id']) && isset($_GET['product_name'])) {
    $product_id = $_GET['product_id'];
    $product_name = $_GET['product_name'];

    // Add the product to the session cart array
    $_SESSION['cart'][$product_id] = $product_name;

    // Return a JSON response indicating success
    echo json_encode(['success' => true]);
} else {
    // Return a JSON response indicating failure
    echo json_encode(['success' => false]);
}
?>

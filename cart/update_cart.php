<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = intval($_POST['quantity']); // Ensure quantity is an integer

        // Validate the quantity (e.g., ensure it's greater than or equal to 1)
        if ($quantity >= 1) {
            // Update the cart session variable with the new quantity
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
}

// Redirect back to the shopping cart
header("Location: ../cart/show_cart.php");
exit(); // Ensure that no code is executed after the header redirect
?>

<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Remove the item from the cart if it exists
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['cart_message'] = "Product removed from cart.";

        // Redirect back to the shopping cart
        header("Location: show_cart.php");
        exit(); // Ensure that no code is executed after the header redirect
    } else {
        $_SESSION['cart_message'] = "Product not found in cart.";

        // Redirect back to the shopping cart
        header("Location: show_cart.php");
        exit(); // Ensure that no code is executed after the header redirect
    }
} else {
    $_SESSION['cart_message'] = "Invalid request.";

    // Redirect back to the shopping cart
    header("Location: show_cart.php");
    exit(); // Ensure that no code is executed after the header redirect
}
?>

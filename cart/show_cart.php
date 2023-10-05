<!-- show_cart.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>
<div class="container">
    <h1>Shopping Cart</h1>
    <ul>
        <?php
        session_start();
        include '../config/config.php'; // Include your database configuration file

        // Initialize total price
        $totalPrice = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                // Retrieve the product details from your database
                $sql = "SELECT name, price FROM products WHERE id = $product_id"; // Replace 'products' with your actual table name
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $product_name = $row['name'];
                    $product_price = $row['price'];
        
                    // Ensure $quantity and $product_price are treated as numbers
                    $quantity = intval($quantity);
                    $product_price = floatval($product_price);
        
                    echo "<li>" . htmlspecialchars($product_name) . " - $" . number_format($product_price, 2) . " (Quantity: $quantity)</li>";
        
                    // Calculate and add the price to the total
                    $totalPrice += $product_price * $quantity;
        
                    // Add a form to adjust the quantity
                    echo "<form method='POST' action='update_cart.php'>";
                    echo "<input type='hidden' name='product_id' value='$product_id'>";
                    echo "Quantity: <input type='number' name='quantity' value='$quantity' min='1' step='1'>";
                    echo "<input type='submit' name='update' value='Update'>";
                    echo "</form>";
        
                    // Add a link to remove the item from the cart
                    echo "<a href='remove_from_cart.php?product_id=$product_id'>Remove</a>";
                }
            }
        } else {
            echo "<li>Your cart is empty.</li>";
        }
        
        
        // Close the database connection
        $conn->close();
        ?>
    </ul>

    <!-- Display the total price -->
    <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>

    <a href="../index/index.php">Back to Shopping</a>
</div>
</body>
</html>

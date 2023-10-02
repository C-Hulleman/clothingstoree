<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // Initialize the cart as an empty associative array
}

// Check if the "Add to Cart" button is clicked
if (isset($_POST['add-to-cart'])) {
    $product_id = $_POST['product-id']; // Get the product ID from the button's data attribute
    $quantity = 1; // You can set a default quantity or let the user specify it

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // If it is, update the quantity
        $_SESSION['cart'][$product_id] = (int)$_SESSION['cart'][$product_id] + $quantity;
    } else {
        // If it's not, add it to the cart
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothing Store</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7478ce291c.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>Clothing Store</h1>
    <i class="fa-solid fa-cart-shopping"></i>
    <a href="admin.php" class="admin-button" id="admin-button">Admin Panel</a>
    <a href="show_cart.php" class="cart-link">View Cart</a>
    <div class="product-list">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Price: $" . number_format($row['price'], 2) . "</p>";

                // Add "Add to Cart" button with product ID
                echo "<form method='POST'>";
                echo "<button class='add-to-cart' data-product-id='" . $row['id'] . "' data-product-name='" . htmlspecialchars($row['name']) . "' name='add-to-cart'>Add to Cart</button>";
                echo "<input type='hidden' name='product-id' value='" . $row['id'] . "'>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "No products available.";
        }

        $conn->close();
        ?>
    </div>
</div>
<script src="./js/script.js"></script>
</body>
</html>
